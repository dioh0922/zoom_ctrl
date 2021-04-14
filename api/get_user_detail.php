<?php
require_once(dirname(__FILE__)."/../../env/zoom_user_setting.php");
require_once(dirname(__FILE__)."/../module/zoom_ctrl_module.php");

//Zoomアカウントの認証系の情報でインスタンス
$result = [];
try{
  $zoom = new ZoomCtrl(ZOOM_USER, ZOOM_APIKEY, ZOOM_SECRET);
  echo json_encode($zoom->get_user_detail(), JSON_UNESCAPED_UNICODE);
}catch(Exception $e){
	echo $e->getMessage();
}


?>
