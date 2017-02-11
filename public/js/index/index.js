var Index = {
  init:function(){
  },
  getMenuList:function(){

     $.get("/getMenuList",{},function(data){
        //console.log(data);
     });
  }
}