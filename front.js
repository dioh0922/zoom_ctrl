let page_controller = null;
(window.onload = function(){
  page_controller = new Vue({
    el: "#container",
    data:{
      req_date: "",
      req_time: "",
      req_title: "",
    },
    methods: {
      create_meeting(){
        axios.post("./api/create_zoom_meeting.php",{
          date: this.req_date,
          time: this.req_time,
          title: this.title
        }).then(function(response){
          alert(response);
        }).catch(function(){
          alert("er");
        });
      }
    },
  })
});
