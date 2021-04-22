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
      <input type="button" v-bind:value="disp_str" v-on:click="toggle_form"/>
      <ul v-show="form_disp == 1">
        <li><input type="date" v-model="req_date"/></li>
        <li><input type="time" v-model="req_time"/></li>
        <li><input type="text" v-model="req_title"/></li>
        <li><input type="button" value="登録" v-on:click="create_meeting"/></li>
      </ul>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>URL</th>
            <th>パスワード</th>
            <th>ミーティングID</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="meeting in meeting_list">
            <td>{{meeting.id}}</td>
            <td>{{meeting.url}}</td>
            <td>{{meeting.pass}}</td>
            <td>{{meeting.obj}}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <script src="./front.js"></script>
  </body>
</html>
