<?php
require_once(dirname(__FILE__)."/../../env/zoom_user_setting.php");
require_once(dirname(__FILE__)."/../../env/connection_setting.php");
require_once(dirname(__FILE__)."/../module/zoom_ctrl_module.php");

//Zoomアカウントの認証系の情報でインスタンス


$result = [];
try{
	$post_json = file_get_contents("php://input");
	$param = json_decode($post_json, true);
	$zoom = new ZoomCtrl(ZOOM_USER, ZOOM_APIKEY, ZOOM_SECRET);
	$time_unix = strtotime($param["date"]." ".$param["time"]);
	$time_unix -= (60 * 60 * 9);
	$zoom_obj = $zoom->create_zoom_meeting($time_unix, 60, $param["title"]);
	$mysqli = new mysqli($SQL_HOST, $SQL_USER, $SQL_PASS, $SQL_DB);
	$stmt = $mysqli->prepare("INSERT INTO zoom_url(meeting_url, meeting_pass, meeting_obj_id)VALUES(?,?,?)");
	$stmt->bind_param("sss", ...[$zoom_obj["url"], $zoom_obj["password"], $zoom_obj["id"]]);
	$stmt->execute();
	$result["result"] = 1;
	$result["ins"] = $stmt->insert_id;
	$stmt->close();
	$mysqli->close();
}catch(Exception $e){
	$result["result"] = -1;
	$result["message"] = $e->getMessage();
 }

 echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>
