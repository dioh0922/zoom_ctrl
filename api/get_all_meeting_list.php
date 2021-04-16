<?php
require_once(dirname(__FILE__)."/../../env/connection_setting.php");

try{
  $mysqli = new mysqli($SQL_HOST, $SQL_USER, $SQL_PASS, $SQL_DB);
  $stmt = $mysqli->prepare("SELECT meeting_id as id, meeting_url as url, meeting_pass as pass, meeting_obj_id as obj FROM zoom_url LIMIT 50");
  $stmt->execute();
  $list = [];
  while($data = $stmt->fetch()){
    $list[] = $data;
  }

  $result["result"] = 1;
  $result["list"] = $list;
  $stmt->close();
  $mysqli->close();
}catch(Exception $e){
  $result["result"] = -1;
  $result["message"] = $e->getMessage();
}
echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>
