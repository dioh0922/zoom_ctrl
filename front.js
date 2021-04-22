let page_controller = null;
(window.onload = function(){
  page_controller = new Vue({
    el: "#container",
    data:{
      form_disp: 0,
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
					if(response.data.result == 1){
						alert("登録しました");
            location.reload();
					}else{
						alert(response.data.message);
					}
        }).catch(function(){
          alert("失敗しました");
        });
      },
      toggle_form(){
        if(this.form_disp == 0){
          this.form_disp = 1;
        }else{
          this.form_disp = 0;
        }
      }
    },
    computed:{
      disp_str(){
        if(this.form_disp == 1){
          return "隠す";
        }else{
          return "表示";
        }
      }
    }
  });
  get_all_meeting();
});

function get_all_meeting(){
  axios.get("./api/get_all_meeting_list.php")
  .then(function(response){
    if(response.data.result == 1){
      page_controller.meeting_list = response.data.list;
    }else{
      alert(response.data.message);
    }
  }).catch(function(){
    alert("失敗しました");
  });
}
