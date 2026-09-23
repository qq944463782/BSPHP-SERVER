<?php
namespace ip2region\xdb {
use \Exception;
const Structure_20=2;
const Structure_30=3;
const IPv4VersionNo=4;
const IPv6VersionNo=6;
const HeaderInfoLength=256;
const VectorIndexRows=256;
const VectorIndexCols=256;
const VectorIndexSize=8;
class Util {
public static function parseIP($ipString) {
$flag=FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6;
if (!filter_var($ipString, FILTER_VALIDATE_IP, $flag)) {
return null;
}
return inet_pton($ipString);
}
public static function ipToString($ipBytes) {
$l=strlen($ipBytes);
return ($l==4 || $l==16) ? inet_ntop($ipBytes) : '<invalid-ip-bytes>';
}
public static function ipSubCompare($ip1, $buff, $offset) {
$r=strcmp($ip1, substr($buff, $offset, strlen($ip1)));
if ($r < 0) {
return -1;
} else if ($r > 0) {
return 1;
} else {
return 0;
}
}
public static function ipCompare($ip1, $ip2) {
$r=strcmp($ip1, $ip2);
if ($r < 0) {
return -1;
} else if ($r > 0) {
return 1;
} else {
return 0;
}
}
public static function versionFromName($ver_name) {
$name=strtoupper($ver_name);
if ($name=="V4" || $name=="IPv4") {
return IPv4::default();
} else if ($name=="V6" || $name=="IPv6") {
return IPv6::default();
} else {
throw new Exception("invalid verstion name `{$ver_name}`");
}
}
public static function versionFromHeader($header) {
if ($header['version']==Structure_20) {
return IPv4::default();
}
if ($header['version'] !=Structure_30) {
throw new Exception("invalid xdb structure version `{$header['version']}`");
}
if ($header['ipVersion']==IPv4VersionNo) {
return IPv4::default();
} else if ($header['ipVersion']==IPv6VersionNo) {
return IPv6::default();
} else {
throw new Exception("invalid ip version number `{$header['ipVersion']}`");
}
}
public static function bytesToString($buff, $offset, $length) {
$sb=[];
for ($i=0; $i < $length; $i++) {
$sb[]=ord($buff[$offset+$i]) & 0xFF;
}
return '['.implode(' ', $sb).']';
}
public static function le_getUint32($b, $idx) {
$val=(ord($b[$idx])) | (ord($b[$idx+1]) << 8)
| (ord($b[$idx+2]) << 16) | (ord($b[$idx+3]) << 24);
if ($val < 0 && PHP_INT_SIZE==4) {
$val=sprintf("%u", $val);
}
return $val;
}
public static function le_getUint16($b, $idx) {
return ((ord($b[$idx])) | (ord($b[$idx+1]) << 8));
}
public static function verify($handle) {
$header=self::loadHeader($handle);
if ($header==null) {
return 'failed to load the header';
}
$runtimePtrBytes=0;
if ($header['version']==Structure_20) {
$runtimePtrBytes=4;
} else if ($header['version']==Structure_30) {
$runtimePtrBytes=$header['runtimePtrBytes'];
} else {
return "invalid structure version `{$header['version']}`";
}
$stat=fstat($handle);
if ($stat==false) {
return 'failed to stat the xdb file';
}
$maxFilePtr=(1 << ($runtimePtrBytes * 8)) - 1;
if ($stat['size'] > $maxFilePtr) {
return "xdb file exceeds the maximum supported bytes: {$maxFilePtr}";
}
return null;
}
public static function verifyFromFile($dbFile) {
$handle=fopen($dbFile, 'r');
if ($handle===false) {
return null;
}
$r=self::verify($handle);
fclose($handle);
return $r;
}
public static function loadHeader($handle) {
if (fseek($handle, 0)==-1) {
return null;
}
$buff=fread($handle, HeaderInfoLength);
if ($buff===false) {
return null;
}
if (strlen($buff) !=HeaderInfoLength) {
return null;
}
return array(
'version'=> self::le_getUint16($buff, 0),
'indexPolicy'=> self::le_getUint16($buff, 2),
'createdAt'=> self::le_getUint32($buff, 4),
'startIndexPtr'=> self::le_getUint32($buff, 8),
'endIndexPtr'=> self::le_getUint32($buff, 12),
'ipVersion'=> self::le_getUint16($buff, 16),
'runtimePtrBytes'=> self::le_getUint16($buff, 18)
);
}
public static function loadHeaderFromFile($dbFile) {
$handle=fopen($dbFile, 'r');
if ($handle===false) {
return null;
}
$header=self::loadHeader($handle);
fclose($handle);
return $header;
}
public static function loadVectorIndex($handle) {
if (fseek($handle, HeaderInfoLength)==-1) {
return null;
}
$rLen=VectorIndexRows * VectorIndexCols * VectorIndexSize;
$buff=fread($handle, $rLen);
if ($buff===false) {
return null;
}
if (strlen($buff) !=$rLen) {
return null;
}
return $buff;
}
public static function loadVectorIndexFromFile($dbFile) {
$handle=fopen($dbFile, 'r');
if ($handle===false) {
return null;
}
$vIndex=self::loadVectorIndex($handle);
fclose($handle);
return $vIndex;
}
public static function loadContent($handle) {
if (fseek($handle, 0, SEEK_END)==-1) {
return null;
}
$size=ftell($handle);
if ($size===false) {
return null;
}
if (fseek($handle, 0)==-1) {
return null;
}
$buff=fread($handle, $size);
if ($buff===false) {
return null;
}
if (strlen($buff) !=$size) {
return null;
}
return $buff;
}
public static function loadContentFromFile($dbFile) {
$str=file_get_contents($dbFile, false);
if ($str===false) {
return null;
} else {
return $str;
}
}
public static function now() {
return (microtime(true) * 1000);
}
}
class IPv4 {
public $id;
public $name;
public $bytes;
public $segmentIndexSize;
private static $C=null;
public static function default() {
if (self::$C==null) {
self::$C=new self(IPv4VersionNo, 'IPv4', 4, 14);
}
return self::$C;
}
public function __construct($id, $name, $bytes, $segmentIndexSize) {
$this->id=$id;
$this->name=$name;
$this->bytes=$bytes;
$this->segmentIndexSize=$segmentIndexSize;
}
public function ipSubCompare($ip1, $buff, $offset) {
$len=strlen($ip1);
$eIdx=$offset + $len;
for ($i=0, $j=$eIdx - 1; $i < $len; $i++, $j--) {
$i1=ord($ip1[$i]) & 0xFF;
$i2=ord($buff[$j]) & 0xFF;
if ($i1 > $i2) {
return 1;
} else if ($i1 < $i2) {
return -1;
}
}
return 0;
}
public function __toString() {
return sprintf(
"{id:%d, name:%s, bytes:%d, segmentIndexSize:%d}",
$this->id, $this->name, $this->bytes, $this->segmentIndexSize
);
}
}
class IPv6 {
public $id;
public $name;
public $bytes;
public $segmentIndexSize;
private static $C=null;
public static function default() {
if (self::$C==null) {
self::$C=new self(IPv6VersionNo, 'IPv6', 16, 38);
}
return self::$C;
}
public function __construct($id, $name, $bytes, $segmentIndexSize) {
$this->id=$id;
$this->name=$name;
$this->bytes=$bytes;
$this->segmentIndexSize=$segmentIndexSize;
}
public function ipSubCompare($ip, $buff, $offset) {
return Util::ipSubCompare($ip, $buff, $offset);
}
public function __toString() {
return sprintf(
"{id:%d, name:%s, bytes:%d, segmentIndexSize:%d}",
$this->id, $this->name, $this->bytes, $this->segmentIndexSize
);
}
}
class Searcher {
private $version;
private $handle=null;
private $ioCount=0;
private $vectorIndex=null;
private $contentBuff=null;
public static function newWithFileOnly($version, $dbFile) {
return new self($version, $dbFile, null, null);
}
public static function newWithVectorIndex($version, $dbFile, $vIndex) {
return new self($version, $dbFile, $vIndex, null);
}
public static function newWithBuffer($version, $cBuff) {
return new self($version, null, null, $cBuff);
}
function __construct($version, $dbFile, $vectorIndex=null, $cBuff=null) {
$this->version=$version;
if ($cBuff !=null) {
$this->vectorIndex=null;
$this->contentBuff=$cBuff;
} else {
$this->handle=fopen($dbFile, "r");
if ($this->handle===false) {
throw new Exception("failed to open xdb file '%s'", $dbFile);
}
$this->vectorIndex=$vectorIndex;
}
}
public function close() {
if ($this->handle !=null) {
fclose($this->handle);
}
}
public function getIPVersion() {
return $this->version;
}
public function getIOCount() {
return $this->ioCount;
}
public function search($ip) {
$ipBytes=Util::parseIP($ip);
if ($ipBytes==null) {
throw new Exception("invalid ip address `{$ip}`");
}
return $this->searchByBytes($ipBytes);
}
public function searchByBytes($ipBytes) {
if (strlen($ipBytes) !=$this->version->bytes) {
throw new Exception("invalid ip address ({$this->version->name} expected)");
}
$this->ioCount=0;
$il0=ord($ipBytes[0]) & 0xFF;
$il1=ord($ipBytes[1]) & 0xFF;
$idx=$il0 * VectorIndexCols * VectorIndexSize + $il1 * VectorIndexSize;
if ($this->vectorIndex !=null) {
$sPtr=Util::le_getUint32($this->vectorIndex, $idx);
$ePtr=Util::le_getUint32($this->vectorIndex, $idx + 4);
} else if ($this->contentBuff !=null) {
$sPtr=Util::le_getUint32($this->contentBuff, HeaderInfoLength + $idx);
$ePtr=Util::le_getUint32($this->contentBuff, HeaderInfoLength + $idx + 4);
} else {
$buff=$this->read(HeaderInfoLength + $idx, 8);
$sPtr=Util::le_getUint32($buff, 0);
$ePtr=Util::le_getUint32($buff, 4);
}
if ($sPtr==0 || $ePtr==0) {
return "";
}
[$bytes, $dBytes]=[strlen($ipBytes), strlen($ipBytes) << 1];
$idxSize=$this->version->segmentIndexSize;
[$dataLen, $dataPtr, $l, $h]=[0, 0, 0, ($ePtr - $sPtr) / $idxSize];
while ($l <=$h) {
$m=($l + $h) >> 1;
$p=$sPtr + $m * $idxSize;
$buff=$this->read($p, $idxSize);
if ($this->version->ipSubCompare($ipBytes, $buff, 0) < 0) {
$h=$m - 1;
} else if ($this->version->ipSubCompare($ipBytes, $buff, $bytes) > 0) {
$l=$m + 1;
} else {
$dataLen=Util::le_getUint16($buff, $dBytes);
$dataPtr=Util::le_getUint32($buff, $dBytes + 2);
break;
}
}
if ($dataLen==0) {
return "";
}
return $this->read($dataPtr, $dataLen);
}
private function read($offset, $len) {
if ($this->contentBuff !=null) {
return substr($this->contentBuff, $offset, $len);
}
$r=fseek($this->handle, $offset);
if ($r==-1) {
throw new Exception("failed to fseek to {$offset}");
}
$this->ioCount++;
$buff=fread($this->handle, $len);
if ($buff===false) {
throw new Exception("failed to fread from {$len}");
}
if (strlen($buff) !=$len) {
throw new Exception("incomplete read: read bytes should be {$len}");
}
return $buff;
}
}
}
namespace {
class ip2region
{
private $searcher_v4=null;
private $searcher_v6=null;
function raw($ip)
{
$ip=$this->clean($ip);
if ($ip==='' || !filter_var($ip, FILTER_VALIDATE_IP)) {
return '';
}
try {
$searcher=$this->searcher($ip);
if ($searcher===null) {
return '';
}
$raw=$searcher->search($ip);
return is_string($raw) ? $raw : '';
} catch (Exception $e) {
return '';
}
}
function format($raw)
{
$raw=trim((string) $raw);
if ($raw==='') {
return '';
}
$map=array(
'reserved'=> '本地网络',
'private'=> '本地网络',
'private network'=> '本地网络',
'lan'=> '本地网络',
'intranet'=> '本地网络',
'localhost'=> '本地网络',
);
$parts=explode('|', $raw);
if (count($parts) >=5) {
array_pop($parts);
}
$out=array();
foreach ($parts as $p) {
$p=trim($p);
if ($p==='' || $p==='0' || strcasecmp($p, 'null')===0) {
continue;
}
$key=strtolower($p);
if (isset($map[$key])) {
$p=$map[$key];
}
if (!empty($out) && end($out)===$p) {
continue;
}
$out[]=$p;
}
return implode(' · ', $out);
}
function region($ip)
{
return $this->format($this->raw($ip));
}
function show($ip)
{
$raw_ip=trim((string) $ip);
$clean=$this->clean($raw_ip);
if ($clean==='' || !filter_var($clean, FILTER_VALIDATE_IP)) {
return $this->miss_tip($clean !=='' ? $clean : '');
}
$region=$this->region($clean);
if ($region==='') {
return $this->miss_tip($clean);
}
return $clean . ' · ' . $region;
}
private function miss_tip($ip)
{
$tip='下载IP库 https://www.bsphp.com/ip.html';
if ($ip==='') {
return $tip;
}
return $ip . ' · ' . $tip;
}
private function clean($ip)
{
$ip=trim((string) $ip);
if ($ip==='') {
return '';
}
if (strpos($ip, '=>') !==false) {
$ip=trim(explode('=>', $ip, 2)[0]);
}
$dot=' · ';
if (strpos($ip, $dot) !==false) {
$ip=trim(explode($dot, $ip, 2)[0]);
}
return $ip;
}
private function searcher($ip)
{
if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
if ($this->searcher_v4===null) {
$db=����������������������������������������4�������������������� . 'Data/ip2region_v4.xdb';
if (!is_file($db)) {
return null;
}
$this->searcher_v4=\ip2region\xdb\Searcher::newWithFileOnly(
\ip2region\xdb\IPv4::default(),
$db
);
}
return $this->searcher_v4;
}
if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
if ($this->searcher_v6===null) {
$db=����������������������������������������4�������������������� . 'Data/ip2region_v6.xdb';
if (!is_file($db)) {
return null;
}
$this->searcher_v6=\ip2region\xdb\Searcher::newWithFileOnly(
\ip2region\xdb\IPv6::default(),
$db
);
}
return $this->searcher_v6;
}
return null;
}
}
}
