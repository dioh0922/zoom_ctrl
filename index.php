<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://unpkg.com/vue@2.6.12"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  </head>
  <body>
    <div id="container">
      <ul>
        <li><input type="date" v-model="req_date"/></li>
        <li><input type="time" v-model="req_time"/></li>
        <li><input type="text" v-model="req_title"/></li>
        <li><input type="button" value="登録" v-on:click="create_meeting"/></li>
      </ul>
    </div>
    設定した日時でzoomのミーティングを作成して一覧で表示する
    <div>
    </div>
    <script src="./front.js"></script>
  </body>
</html>
