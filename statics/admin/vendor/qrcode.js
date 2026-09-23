/**
 * 纯 JS 二维码编码器（byte 模式 / 纠错等级 M / 版本 1-10 自适应）
 *
 * 用法（浏览器）：
 *   <script src="statics/vendor/qrcode.js"></script>
 *   var m = BsQr.qrMatrix('https://demo.com/bsphp')  // m[r][c] === 1 表示黑点
 *
 * 只负责编码，不负责渲染：网页侧用原生 canvas，App 侧用 uni.createCanvasContext。
 * 无任何外部依赖，不联网（地址不会泄露给第三方二维码服务）。
 *
 * ⚠ 本文件与 客户端/admin/utils/qrcode.js 是同一份实现的两种包装（UMD / ESM），
 *   改动其中一份时必须同步另一份。
 */
(function (root, factory) {
  if (typeof module === 'object' && module.exports) module.exports = factory()
  else root.BsQr = factory()
})(typeof self !== 'undefined' ? self : this, function () {
  'use strict'

  /* ---------------- GF(256) ---------------- */

  const EXP = new Array(256)
  const LOG = new Array(256)
  ;(function initGF() {
    let x = 1
    for (let i = 0; i < 255; i++) {
      EXP[i] = x
      LOG[x] = i
      x <<= 1
      if (x & 0x100) x ^= 0x11d
    }
    EXP[255] = EXP[0]
  })()

  function gfMul(a, b) {
    if (a === 0 || b === 0) return 0
    return EXP[(LOG[a] + LOG[b]) % 255]
  }

  const genCache = {}
  /** 生成 n 个纠错码字用的生成多项式，最高次在前 */
  function rsGenPoly(n) {
    if (genCache[n]) return genCache[n]
    let poly = [1]
    for (let i = 0; i < n; i++) {
      const next = new Array(poly.length + 1).fill(0)
      for (let j = 0; j < poly.length; j++) {
        next[j] ^= poly[j]
        next[j + 1] ^= gfMul(poly[j], EXP[i])
      }
      poly = next
    }
    genCache[n] = poly
    return poly
  }

  /** Reed-Solomon 纠错码字 */
  function rsEncode(data, ecLen) {
    const gen = rsGenPoly(ecLen)
    const buf = new Array(data.length + ecLen).fill(0)
    for (let i = 0; i < data.length; i++) buf[i] = data[i]
    for (let i = 0; i < data.length; i++) {
      const coef = buf[i]
      if (coef === 0) continue
      for (let j = 0; j < gen.length; j++) buf[i + j] ^= gfMul(gen[j], coef)
    }
    return buf.slice(data.length)
  }

  /* ---------------- 版本表（纠错等级 M） ---------------- */

  /**
   * [每块纠错码字数, [[块数, 每块数据码字数], ...]]
   * 版本 1-10，等级 M；byte 模式下最多可放 213 字节，足够放地址 URL。
   */
  const EC_M = {
    1: [10, [[1, 16]]],
    2: [16, [[1, 28]]],
    3: [26, [[1, 44]]],
    4: [18, [[2, 32]]],
    5: [24, [[2, 43]]],
    6: [16, [[4, 27]]],
    7: [18, [[4, 31]]],
    8: [22, [[2, 38], [2, 39]]],
    9: [22, [[3, 36], [2, 37]]],
    10: [26, [[4, 43], [1, 44]]],
  }

  /** 校正图形中心坐标 */
  const ALIGN = {
    1: [],
    2: [6, 18],
    3: [6, 22],
    4: [6, 26],
    5: [6, 30],
    6: [6, 34],
    7: [6, 22, 38],
    8: [6, 24, 42],
    9: [6, 26, 46],
    10: [6, 28, 50],
  }

  const MODE_BYTE = 4

  function totalDataCodewords(version) {
    let n = 0
    const groups = EC_M[version][1]
    for (let i = 0; i < groups.length; i++) n += groups[i][0] * groups[i][1]
    return n
  }

  /* ---------------- 编码 ---------------- */

  function toUtf8(str) {
    const out = []
    for (let i = 0; i < str.length; i++) {
      const c = str.charCodeAt(i)
      if (c < 0x80) {
        out.push(c)
      } else if (c < 0x800) {
        out.push(0xc0 | (c >> 6), 0x80 | (c & 63))
      } else if (c >= 0xd800 && c <= 0xdbff && i + 1 < str.length) {
        const c2 = str.charCodeAt(++i)
        const cp = 0x10000 + ((c - 0xd800) << 10) + (c2 - 0xdc00)
        out.push(
          0xf0 | (cp >> 18),
          0x80 | ((cp >> 12) & 63),
          0x80 | ((cp >> 6) & 63),
          0x80 | (cp & 63),
        )
      } else {
        out.push(0xe0 | (c >> 12), 0x80 | ((c >> 6) & 63), 0x80 | (c & 63))
      }
    }
    return out
  }

  function pickVersion(byteLen) {
    for (let v = 1; v <= 10; v++) {
      const ccBits = v < 10 ? 8 : 16
      if (4 + ccBits + byteLen * 8 <= totalDataCodewords(v) * 8) return v
    }
    return 0
  }

  function encodeData(bytes, version) {
    const cap = totalDataCodewords(version) * 8
    const ccBits = version < 10 ? 8 : 16
    const bits = []
    const push = (val, len) => {
      for (let i = len - 1; i >= 0; i--) bits.push((val >>> i) & 1)
    }
    push(MODE_BYTE, 4)
    push(bytes.length, ccBits)
    for (let i = 0; i < bytes.length; i++) push(bytes[i], 8)
    // 终止符（最多 4 位，不越界）
    for (let i = 0; i < 4 && bits.length < cap; i++) bits.push(0)
    // 补齐到字节边界
    while (bits.length % 8 !== 0) bits.push(0)
    // 填充码字 0xEC / 0x11 交替
    const pad = [0xec, 0x11]
    let pi = 0
    while (bits.length < cap) push(pad[pi++ % 2], 8)
    // 位流转码字
    const cw = []
    for (let i = 0; i < bits.length; i += 8) {
      let v = 0
      for (let j = 0; j < 8; j++) v = (v << 1) | bits[i + j]
      cw.push(v)
    }
    return cw
  }

  /** 按块分组 → 计算纠错 → 交错排列 */
  function interleave(cw, version) {
    const ecLen = EC_M[version][0]
    const groups = EC_M[version][1]
    const blocks = []
    let pos = 0
    for (let g = 0; g < groups.length; g++) {
      const cnt = groups[g][0]
      const dc = groups[g][1]
      for (let i = 0; i < cnt; i++) {
        const d = cw.slice(pos, pos + dc)
        pos += dc
        blocks.push({ d, e: rsEncode(d, ecLen) })
      }
    }
    const out = []
    let maxD = 0
    for (let i = 0; i < blocks.length; i++) maxD = Math.max(maxD, blocks[i].d.length)
    for (let i = 0; i < maxD; i++) {
      for (let b = 0; b < blocks.length; b++) {
        if (i < blocks[b].d.length) out.push(blocks[b].d[i])
      }
    }
    for (let i = 0; i < ecLen; i++) {
      for (let b = 0; b < blocks.length; b++) out.push(blocks[b].e[i])
    }
    return out
  }

  /* ---------------- 矩阵 ---------------- */

  function formatBits(mask) {
    // 纠错等级 M 的 2 位标识为 00
    const data = mask & 7
    let rem = data
    for (let i = 0; i < 10; i++) rem = (rem << 1) ^ ((rem >>> 9) * 0x537)
    return (((data << 10) | rem) ^ 0x5412) & 0x7fff
  }

  function versionBits(version) {
    let rem = version
    for (let i = 0; i < 12; i++) rem = (rem << 1) ^ ((rem >>> 11) * 0x1f25)
    return (version << 12) | rem
  }

  function maskFn(mask, r, c) {
    switch (mask) {
      case 0: return (r + c) % 2 === 0
      case 1: return r % 2 === 0
      case 2: return c % 3 === 0
      case 3: return (r + c) % 3 === 0
      case 4: return (Math.floor(r / 2) + Math.floor(c / 3)) % 2 === 0
      case 5: return ((r * c) % 2) + ((r * c) % 3) === 0
      case 6: return (((r * c) % 2) + ((r * c) % 3)) % 2 === 0
      default: return (((r + c) % 2) + ((r * c) % 3)) % 2 === 0
    }
  }

  /** 生成功能图形层：定位 / 定时 / 校正 / 格式预留 / 版本信息 */
  function makeBase(version) {
    const size = version * 4 + 17
    const m = []
    const fn = []
    for (let i = 0; i < size; i++) {
      m.push(new Array(size).fill(0))
      fn.push(new Array(size).fill(false))
    }
    const set = (r, c, v) => {
      m[r][c] = v ? 1 : 0
      fn[r][c] = true
    }

    // 定位图形 + 分隔符
    const finder = (r0, c0) => {
      for (let r = -1; r <= 7; r++) {
        for (let c = -1; c <= 7; c++) {
          const rr = r0 + r
          const cc = c0 + c
          if (rr < 0 || rr >= size || cc < 0 || cc >= size) continue
          const ring = ((r === 0 || r === 6) && c >= 0 && c <= 6) || ((c === 0 || c === 6) && r >= 0 && r <= 6)
          const core = r >= 2 && r <= 4 && c >= 2 && c <= 4
          set(rr, cc, ring || core)
        }
      }
    }
    finder(0, 0)
    finder(0, size - 7)
    finder(size - 7, 0)

    // 定时图形
    for (let i = 8; i < size - 8; i++) {
      set(6, i, i % 2 === 0)
      set(i, 6, i % 2 === 0)
    }

    // 校正图形
    const centers = ALIGN[version] || []
    for (let a = 0; a < centers.length; a++) {
      for (let b = 0; b < centers.length; b++) {
        const r0 = centers[a]
        const c0 = centers[b]
        // 与三个定位图形重叠的位置不画
        if ((r0 <= 8 && c0 <= 8) || (r0 <= 8 && c0 >= size - 9) || (r0 >= size - 9 && c0 <= 8)) continue
        for (let r = -2; r <= 2; r++) {
          for (let c = -2; c <= 2; c++) {
            set(r0 + r, c0 + c, Math.max(Math.abs(r), Math.abs(c)) !== 1)
          }
        }
      }
    }

    // 预留格式信息区（值稍后写入）
    for (let i = 0; i <= 5; i++) {
      set(i, 8, false)
      set(8, i, false)
    }
    set(7, 8, false)
    set(8, 7, false)
    set(8, 8, false)
    for (let i = 0; i < 8; i++) set(8, size - 1 - i, false)
    for (let i = 8; i < 15; i++) set(size - 15 + i, 8, false)
    // 固定暗模块
    set(size - 8, 8, true)

    // 版本信息（版本 7 起）
    if (version >= 7) {
      const vb = versionBits(version)
      for (let i = 0; i < 18; i++) {
        const bit = (vb >>> i) & 1
        const a = size - 11 + (i % 3)
        const b = Math.floor(i / 3)
        set(b, a, bit)
        set(a, b, bit)
      }
    }

    return { size, m, fn }
  }

  function drawFormat(out, size, mask) {
    const fb = formatBits(mask)
    const bit = (i) => (fb >>> i) & 1
    for (let i = 0; i <= 5; i++) out[i][8] = bit(i)
    out[7][8] = bit(6)
    out[8][8] = bit(7)
    out[8][7] = bit(8)
    for (let i = 9; i < 15; i++) out[8][14 - i] = bit(i)
    for (let i = 0; i < 8; i++) out[8][size - 1 - i] = bit(i)
    for (let i = 8; i < 15; i++) out[size - 15 + i][8] = bit(i)
    out[size - 8][8] = 1
  }

  /** 数据位按蛇形从右下往左上填，跳过所有功能图形 */
  function placeData(base, cw, mask) {
    const size = base.size
    const out = []
    const filled = []
    for (let i = 0; i < size; i++) {
      out.push(base.m[i].slice())
      filled.push(base.fn[i].slice())
    }
    const total = cw.length * 8
    let idx = 0
    let upward = true
    for (let col = size - 1; col > 0; col -= 2) {
      if (col === 6) col = 5 // 竖直定时图形所在列整列跳过
      for (let i = 0; i < size; i++) {
        const row = upward ? size - 1 - i : i
        for (let k = 0; k < 2; k++) {
          const c = col - k
          if (filled[row][c]) continue
          let bit = 0
          if (idx < total) {
            bit = (cw[idx >> 3] >>> (7 - (idx & 7))) & 1
            idx++
          }
          if (maskFn(mask, row, c)) bit ^= 1
          out[row][c] = bit
          filled[row][c] = true
        }
      }
      upward = !upward
    }
    return out
  }

  function penalty(m) {
    const size = m.length
    let p = 0

    // 规则 1：行/列连续同色 >= 5
    for (let i = 0; i < size; i++) {
      let rr = 1
      let rc = 1
      for (let j = 1; j < size; j++) {
        if (m[i][j] === m[i][j - 1]) {
          rr++
          if (rr === 5) p += 3
          else if (rr > 5) p++
        } else rr = 1
        if (m[j][i] === m[j - 1][i]) {
          rc++
          if (rc === 5) p += 3
          else if (rc > 5) p++
        } else rc = 1
      }
    }

    // 规则 2：2x2 同色
    for (let i = 0; i < size - 1; i++) {
      for (let j = 0; j < size - 1; j++) {
        const v = m[i][j]
        if (v === m[i][j + 1] && v === m[i + 1][j] && v === m[i + 1][j + 1]) p += 3
      }
    }

    // 规则 3：形似定位图形的 1:1:3:1:1 且一侧有 4 个浅色
    const pat = [1, 0, 1, 1, 1, 0, 1]
    const scan = (get) => {
      for (let i = 0; i + 11 <= size; i++) {
        let a = true
        for (let k = 0; k < 7 && a; k++) if (get(i + k) !== pat[k]) a = false
        if (a) for (let k = 7; k < 11 && a; k++) if (get(i + k) !== 0) a = false
        if (a) p += 40
        let b = true
        for (let k = 0; k < 7 && b; k++) if (get(i + 4 + k) !== pat[k]) b = false
        if (b) for (let k = 0; k < 4 && b; k++) if (get(i + k) !== 0) b = false
        if (b) p += 40
      }
    }
    for (let i = 0; i < size; i++) scan((k) => m[i][k])
    for (let j = 0; j < size; j++) scan((k) => m[k][j])

    // 规则 4：暗模块占比偏离 50%
    let dark = 0
    for (let i = 0; i < size; i++) {
      for (let j = 0; j < size; j++) if (m[i][j]) dark++
    }
    p += Math.floor(Math.abs((dark * 100) / (size * size) - 50) / 5) * 10

    return p
  }

  /**
   * 把文本编码成二维码矩阵
   * @param {string} text
   * @returns {number[][]} 二维数组，1 为黑点；text 过长（超过版本 10 容量，约 213 字节）时返回 []
   */
  function qrMatrix(text) {
    const str = String(text == null ? '' : text)
    const bytes = toUtf8(str)
    const version = pickVersion(bytes.length)
    if (!version) return []

    const cw = interleave(encodeData(bytes, version), version)
    const base = makeBase(version)

    let best = null
    let bestP = Infinity
    for (let mask = 0; mask < 8; mask++) {
      const out = placeData(base, cw, mask)
      drawFormat(out, base.size, mask)
      const p = penalty(out)
      if (p < bestP) {
        bestP = p
        best = out
      }
    }
    return best
  }

  return { qrMatrix: qrMatrix }
})
