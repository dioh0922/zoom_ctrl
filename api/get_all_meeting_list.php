<?php
require_once(dirname(__FILE__)."/../../env/connection_setting.php");
require_once(dirname(__FILE__)."/../composer/vendor/autoload.php");
try{
  ORM::configure('mysql:host=127.0.0.1;port=3306;dbname='.$SQL_DB);
  ORM::configure('username', $SQL_USER);
  ORM::configure('password', $SQL_PASS);
  ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
ORM::configure('return_result_sets', true);
  $record = ORM::for_table("zoom_url")->limit(50)->find_many();
  $list = [];
  foreach($record->get_results() as $row){
    $list[] = ["id" => $row["meeting_id"], "url" => $row["meeting_url"], "pass" => $row["meeting_pass"], "obj" => $row["meeting_obj_id"]];
  }

  $result["result"] = 1;
  $result["list"] = $list;
}catch(Exception $e){
  $result["result"] = -1;
  $result["message"] = $e->getMessage();
}
$response = json_encode($result, JSON_UNESCAPED_UNICODE);
echo str_replace("\\", "", $response);
?>
