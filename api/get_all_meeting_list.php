<?php
require_once(dirname(__FILE__)."/../../env/connection_setting.php");

try{
  $mysqli = new mysqli($SQL_HOST, $SQL_USER, $SQL_PASS, $SQL_DB);
  $stmt = $mysqli->prepare("SELECT * FROM zoom_url");
  $stmt->execute();
  $list = [];
  while($data = $stmt->fetch_assoc()){
    $list[] = $data;
  }

  $result["result"] = 1;
  $result["ins"] = $list;
  $stmt->close();
  $mysqli->close();
}catch(Exception $e){
  $result["result"] = -1;
  $result["message"] = $e->getMessage();
}
echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>
