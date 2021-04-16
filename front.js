let page_controller = null;
(window.onload = function(){
  page_controller = new Vue({
    el: "#container",
    data:{
      req_date: "",
      req_time: "",
      req_title: "",
      meeting_list: [{id:0,url:"test",pass:"password",obj:"object"}]
    },
    methods: {
      create_meeting(){
        axios.post("./api/create_zoom_meeting.php",{
          date: this.req_date,
          time: this.req_time,
          title: this.req_title
        }).then(function(response){
          let api_result = JSON.parse(response);
					if(api_result.result == 1){
						alert("登録しました");
					}else{
						alert(api_result.message);
					}
        }).catch(function(){
          alert("失敗しました");
        });
      }
    },
  });
  //get_all_meeting();
});

function get_all_meeting(){
  axios.get("./api/get_all_meeting_list.php")
  .then(function(resonse){
    let api_result = JSON.parse(response);
    if(api_result.result == 1){
      page_controller.meeting_list = api_result.list;
    }else{
      alert(api_result.message);
    }
  }).catch(function(){
    alert("失敗しました");
  });
}
