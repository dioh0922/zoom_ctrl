<?php
require_once(dirname(__FILE__)."/../setting.php");
require_once(dirname(__FILE__)."/../module/zoom_ctrl_module.php");

//Zoomアカウントの認証系の情報でインスタンス
$result = [];
try{
  $zoom = new ZoomCtrl(ZOOM_USER, ZOOM_APIKEY, ZOOM_SECRET);
  $zoom_obj = $zoom->create_zoom_meeting();
}catch(Exception $e){

}
?>
