<?php
defined('BSPHP_SET') or die('Not,This File Not Can in Ie Open');
if (BSPHP_SET !='ADMIN') {
die('Not,This File Not Can in Ie Modules');
}
class CustomFormFeature
{
public $admin_array;
private $db;
function __construct()
{
Plug_ResApi_Session_Open();
$this->admin_array=Plug_Admin_Assert_Login();
����������������������������������������������������������������::����������������������������N��������������������������������������������������������('custom', 'custom');
$this->db=����������������������������������������������������������������::��������2������������������������������������������������������������������������for（('mysql', 'mysql');
}
private function model_key()
{
$k=custom_safe_key(Plug_Set_Get('key'));
if ($k==='') {
$k=custom_safe_key(Plug_Set_Get('t'));
}
if ($k==='') {
$k=custom_safe_key(Plug_Set_Post('key'));
}
if ($k==='') {
$k=custom_safe_key(Plug_Set_Post('t'));
}
return $k;
}
function call_models()
{
Plug_Admin_Assert_Qx('yy_6');
$forms=custom_get_forms($this->db);
Plug_Admin_List_Json($forms, count($forms));
}
function call_table_json()
{
Plug_Admin_Assert_Qx('yy_6');
$key=$this->model_key();
if ($key==='') {
return $this->call_models();
}
$table=custom_table_name($key);
$form=custom_get_form_by_table($this->db, $table);
if (!$form) {
Plug_Admin_List_Json(array(), 0);
}
$columns=custom_get_table_columns($this->db, $table);
if (empty($columns)) {
$columns=array('id');
}
$p=Plug_Admin_Pager();
$DESC=((int) Plug_Set_Get('DESC')==1) ? 'ASC' : 'DESC';
$search_field=trim((string) Plug_Set_Get('soso_id'));
$kw=trim((string) Plug_Set_Get('soso'));
if ($kw==='') {
$kw=trim((string) Plug_Set_Get('keyword'));
}
if ($search_field==='' || !in_array($search_field, $columns, true)) {
$search_field=$columns[0];
}
$where='';
if ($kw !=='') {
$where=" WHERE `{$search_field}` LIKE '%" . custom_escape($kw) . "%'";
}
$cnt_arr=Plug_Query_Array("SELECT COUNT(*) AS hangshu FROM `{$table}`{$where}");
$rs=Plug_Query("SELECT * FROM `{$table}`{$where} ORDER BY `id` {$DESC} LIMIT {$p['offset']},{$p['limit']}");
$list=array();
while ($v=Plug_Pdo_Fetch_Assoc($rs)) {
$list[]=$v;
}
Plug_Print_Json(array(
'code'=> 0,
'msg'=> '',
'count'=> (int) ($cnt_arr['hangshu'] ?? 0),
'data'=> $list,
'columns'=> custom_get_table_columns_meta($this->db, $table),
'fields'=> custom_get_fields($this->db, $table),
'form'=> $form,
));
}
function call_model_save()
{
Plug_Admin_Assert_Qx('yy_6');
$model_key=Plug_Set_Post('model_key');
$model_name=Plug_Set_Post('model_name');
$ret=custom_create_form($this->db, $model_key, $model_name);
if (isset($ret['code']) && (int) $ret['code']===0) {
Plug_Admin_Ok(isset($ret['msg']) ? $ret['msg'] : Plug_Lang('添加成功'), $ret);
}
Plug_Admin_Fail(isset($ret['msg']) ? $ret['msg'] : Plug_Lang('添加失败'));
}
function call_model_delete()
{
Plug_Admin_Assert_Qx('yy_6');
$key=custom_safe_key(Plug_Set_Post('delete_key'));
if ($key==='') {
$key=$this->model_key();
}
$ok=custom_delete_model($this->db, $key);
if ($ok) {
Plug_Admin_Ok(Plug_Lang('模型删除成功'));
}
Plug_Admin_Fail(Plug_Lang('模型删除失败'));
}
function call_field_list()
{
Plug_Admin_Assert_Qx('yy_6');
$key=$this->model_key();
$table=custom_table_name($key);
$fields=custom_get_fields($this->db, $table);
Plug_Admin_List_Json($fields, count($fields));
}
function call_field_save()
{
Plug_Admin_Assert_Qx('yy_6');
$key=$this->model_key();
$table=Plug_Set_Post('table_name');
if ($table==='') {
$table=custom_table_name($key);
}
$field_key=Plug_Set_Post('field_key');
$field_name=Plug_Set_Post('field_name');
$field_type=Plug_Set_Post('field_type');
$old=Plug_Set_Post('old_field_key');
$ret=custom_save_field_with_type($this->db, $table, $field_key, $field_name, $field_type, '', $old);
if (isset($ret['code']) && (int) $ret['code']===0) {
Plug_Admin_Ok(isset($ret['msg']) ? $ret['msg'] : Plug_Lang('保存成功'), $ret);
}
Plug_Admin_Fail(isset($ret['msg']) ? $ret['msg'] : Plug_Lang('保存失败'));
}
function call_field_delete()
{
Plug_Admin_Assert_Qx('yy_6');
$key=$this->model_key();
$table=custom_table_name($key);
$del=custom_safe_key(Plug_Set_Post('delete_field_key'));
$ok=custom_delete_field($this->db, $table, $del);
if ($ok) {
Plug_Admin_Ok(Plug_Lang('字段删除成功'));
}
Plug_Admin_Fail(Plug_Lang('字段删除失败'));
}
function call_row_detail()
{
Plug_Admin_Assert_Qx('yy_6');
$key=$this->model_key();
$id=(int) Plug_Set_Get('id');
$table=custom_table_name($key);
$row=custom_get_row_by_id($this->db, $table, $id);
if (!$row) {
Plug_Admin_Fail(Plug_Lang('记录不存在'));
}
Plug_Admin_Ok('ok', array(
'row'=> $row,
'columns'=> custom_get_table_columns_meta($this->db, $table),
));
}
function call_row_save()
{
Plug_Admin_Assert_Qx('yy_6');
$key=$this->model_key();
$id=(int) Plug_Set_Post('id');
$table=custom_table_name($key);
$meta=custom_get_table_columns_meta($this->db, $table);
$data=array();
foreach ($meta as $col) {
$name=(string) $col['name'];
if ($name==='id') {
continue;
}
if (isset($_POST['col_' . $name])) {
$data[$name]=(string) $_POST['col_' . $name];
} elseif (isset($_POST[$name])) {
$data[$name]=(string) $_POST[$name];
}
}
$ok=custom_update_row($this->db, $table, $id, $data);
if ($ok) {
Plug_Admin_Ok(Plug_Lang('单条修改成功'));
}
Plug_Admin_Fail(Plug_Lang('单条修改失败'));
}
function call_row_batch()
{
Plug_Admin_Assert_Qx('yy_6');
$key=$this->model_key();
$table=custom_table_name($key);
$mode=trim((string) Plug_Set_Post('mode'));
$ids=custom_parse_id_list(Plug_Set_Post('ids'));
if ($mode==='delete') {
$ok=custom_delete_rows($this->db, $table, $ids);
if ($ok) {
Plug_Admin_Ok(Plug_Lang('批量删除成功'));
}
Plug_Admin_Fail(Plug_Lang('批量删除失败'));
}
if ($mode==='update') {
$field=trim((string) Plug_Set_Post('field'));
$value=(string) Plug_Set_Post('value');
$ok=custom_batch_update_field($this->db, $table, $ids, $field, $value);
if ($ok) {
Plug_Admin_Ok(Plug_Lang('批量修改成功'));
}
Plug_Admin_Fail(Plug_Lang('批量修改失败'));
}
Plug_Admin_Fail(Plug_Lang('未知操作类型'));
}
function call_export_csv()
{
Plug_Admin_Assert_Qx('yy_6');
$key=$this->model_key();
$table=custom_table_name($key);
$form=custom_get_form_by_table($this->db, $table);
if (!$form) {
Plug_Admin_Fail(Plug_Lang('模型不存在'));
}
$columns=custom_get_table_columns($this->db, $table);
if (empty($columns)) {
Plug_Admin_Fail(Plug_Lang('无字段'));
}
$DESC=((int) Plug_Set_Get('DESC')===1) ? 'ASC' : 'DESC';
$search_field=trim((string) Plug_Set_Get('soso_id'));
$kw=trim((string) Plug_Set_Get('soso'));
if ($search_field==='' || !in_array($search_field, $columns, true)) {
$search_field=$columns[0];
}
$where='';
if ($kw !=='') {
$where=" WHERE `{$search_field}` LIKE '%" . custom_escape($kw) . "%'";
}
$rows=custom_query_all_rows($this->db, "SELECT * FROM `{$table}`{$where} ORDER BY `id` {$DESC}");
$lines=array();
$header=array();
foreach ($columns as $c) {
$header[]=custom_csv_escape_cell($c);
}
$lines[]=implode(',', $header);
foreach ($rows as $row) {
$line=array();
foreach ($columns as $c) {
$line[]=custom_csv_escape_cell(isset($row[$c]) ? $row[$c] : '');
}
$lines[]=implode(',', $line);
}
$csv="\xEF\xBB\xBF" . implode("\n", $lines);
Plug_Admin_Ok('ok', array(
'filename'=> 'custom_' . $key . '_' . date('Ymd_His') . '.csv',
'csv'=> $csv,
'rows'=> count($rows),
'columns'=> $columns,
));
}
function call_import_csv()
{
Plug_Admin_Assert_Qx('yy_6');
$key=$this->model_key();
$table=custom_table_name($key);
$form=custom_get_form_by_table($this->db, $table);
$columns=custom_get_table_columns($this->db, $table);
if (!$form) {
Plug_Admin_Fail(Plug_Lang('模型不存在'));
}
$content='';
if (!empty($_FILES['csv_file']['tmp_name']) && is_uploaded_file($_FILES['csv_file']['tmp_name'])) {
$content=file_get_contents($_FILES['csv_file']['tmp_name']);
} else {
$content=(string) Plug_Set_Post('csv_text');
}
if (trim($content)==='') {
Plug_Admin_Fail(Plug_Lang('请上传CSV文件'));
}
$content=str_replace("\r\n", "\n", (string) $content);
$lines=explode("\n", $content);
if (empty($lines)) {
Plug_Admin_Fail(Plug_Lang('CSV内容为空'));
}
$header=custom_csv_parse_line(array_shift($lines));
if (!empty($header) && isset($header[0])) {
$header[0]=preg_replace('/^\xEF\xBB\xBF/', '', (string) $header[0]);
}
$valid_cols=array();
foreach ($header as $h) {
$h=trim((string) $h);
if (in_array($h, $columns, true) && $h !=='id') {
$valid_cols[]=$h;
}
}
$has_id=in_array('id', array_map('trim', $header), true) && in_array('id', $columns, true);
if (empty($valid_cols) && !$has_id) {
Plug_Admin_Fail(Plug_Lang('CSV表头无有效字段'));
}
$ok=0;
$updated=0;
foreach ($lines as $lineText) {
if (trim($lineText)==='') {
continue;
}
$cells=custom_csv_parse_line($lineText);
if (empty($cells)) {
continue;
}
$row_data=array();
foreach ($header as $idx=> $h) {
$h=trim((string) $h);
if ($h==='id') {
$row_data['id']=isset($cells[$idx]) ? (string) $cells[$idx] : '';
continue;
}
if (!in_array($h, $valid_cols, true)) {
continue;
}
$row_data[$h]=isset($cells[$idx]) ? (string) $cells[$idx] : '';
}
if (empty($row_data)) {
continue;
}
$row_id=isset($row_data['id']) ? (int) $row_data['id'] : 0;
unset($row_data['id']);
if ($row_id > 0) {
$old=custom_get_row_by_id($this->db, $table, $row_id);
if ($old && !empty($row_data)) {
if (custom_update_row($this->db, $table, $row_id, $row_data)) {
$updated++;
}
}
continue;
}
$insert_cols=array();
$insert_vals=array();
foreach ($row_data as $k=> $v) {
if (!in_array($k, $columns, true)) {
continue;
}
$insert_cols[]="`{$k}`";
$insert_vals[]="'" . custom_escape($v) . "'";
}
if (empty($insert_cols)) {
continue;
}
$sql='INSERT INTO `' . $table . '` (' . implode(',', $insert_cols) . ') VALUES (' . implode(',', $insert_vals) . ')';
if (Plug_Query($sql)) {
$ok++;
}
}
Plug_Admin_Ok(Plug_Lang('导入完成'), array('inserted'=> $ok, 'updated'=> $updated));
}
}
