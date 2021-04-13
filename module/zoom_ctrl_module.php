<?php
require_once(dirname(__FILE__)."/../../composer/vendor/autoload.php");
use \Firebase\JWT\JWT;
class ZoomCtrl{
  private $user = 0;
  private $api_key = "";
  private $secret = "";

  function __construct(string $user, string $key, string $secret){
    $this->user = $user;
    $this->api_key = $key;
    $this->secret = $secret;
  }

  private function get_jwt(){
    $payload = array(
      "iss" => $this->api_key,
      "exp" => time() + 30
    );

    $jwt = JWT::encode($payload, $this->secret);

    return $jwt;
  }

  function create_zoom_meeting(int $time, int $duration, string $title, int $user){
    $meeting_setting = array(
      "host_video"=>true, //ホストのビデオ
      "participant_video"=>true,  //参加者のビデオ
      "join_before_host"=>true,  //ホストの前に参加
      "waiting_room"=>false  //待機室
    );

    $create_request = array(
      "type"=>2,  //スケジュールされたミーティング
      "start_time"=>date("Y-m-d\TH:i:s\Z", $time), //開催時間
      "topic"=>$title, //ミーティングの名前
      "timezone"=>"Asia/Tokyo",
      "password"=>time(),  //パスワードはAPI実行と気のUNIXTIME
      "settings"=>$meeting_setting,
      "duration"=> $duration //ミーティングの開催時間
    );

    $curl = curl_init();

    $post_json = json_encode($create_request);

    curl_setopt($curl, CURLOPT_URL, "https://api.zoom.us/v2/users/".$this->user."/meetings");
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer ".$this->get_jwt(),
      "Content-type: application/json"
    ));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_json );
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $json = json_decode($response);

    $result = array(
      "url" => $json->join_url,
      "password" => $json->password,
      "id" => $json->id,
      "user" => $user
    );

    return $result;
  }

  /*****
  コマに連結した時間外ZOOMのミーティングを削除する処理
  *****/
  function delete_zoom_meeting(string $id){

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, "https://api.zoom.us/v2/meetings/".$id);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer ".$this->get_jwt(),
      "Content-type: application/json"
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    if($err){
      throw new Exception($err);
    }
  }

  /*
  function get_user_detail(){
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, "https://api.zoom.us/v2/users/");
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer ".$this->get_jwt().";",
      "Content-type: application/json; charset=UTF-8;"
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    if($err){
      throw new Exception($err);
    }
    $json = json_decode($response);
    return ["id" => $json->users[0]->id, "name" => $json->users[0]->first_name.$json->users[0]->last_name];
  }
  */
}
?>
