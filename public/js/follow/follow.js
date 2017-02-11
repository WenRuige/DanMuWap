/**
 * Created by gewenrui on 2016/11/3.
 */
var followInfo = {
    init:function(stroot){
        this.clear();
        this.begin();
    },
    clear:function(){
        $("#timefilter").val('');
    },
    begin:function(){
        var dataObj = {};
        dataObj['page'] = 1;
        FollowList.request(dataObj);
    },
    findCustomer: function () {
        var dataObj = {};
        var data = $("#follow").val();
        if(data == "is_new"){
            dataObj['is_new'] = 1;
        }else if(data == "is_again"){
            dataObj['is_again'] = 1;
        }

        dataObj['source'] = $('#source option:selected') .val();
        dataObj['star']   = $('#star option:selected') .val();
        //获取选择的时间
        var button_time   = $("#button_time").attr('value');
        var timefilter    = $("#timefilter").val();
        var button_phone  = $("#button_phone").attr('value');
        var phonefilter   = $("#phonefilter").val();
        if(button_time == 1){
            dataObj['policy_created_time']  = timefilter;
        }else if(button_time == 2){
            dataObj['contact_created_time'] = timefilter;
        } else{
            dataObj['contact_next_contact_time'] = timefilter;
        }
        if(button_phone == 1){
            dataObj['mobile_number']  = phonefilter;
        }else{
            dataObj['new_mobile_number'] = phonefilter;
        }
        //获取选取的手机号码
        var button_phone = $("#button_phone").attr('value');
        console.log(dataObj);
        //获取选择的手机号
        $('#allowFollow').html('');
        $('#followList').attr('data-First', 'false');
        FollowList.request(dataObj);

    },//修改用户的个人信息
    updateUserInformation: function () {
        var data = {},contact = {};
        var uid = $("#uid").val();
        //获取用户姓名
        data['name']  =  $("#name").val();
        //获取用户性别
        data['sex']   =  $("input[id='sex']").filter(':checked').val();
        //获取用户星级
        data['star']  =  $("input[id='star']").filter(':checked').val();
        //获取用户联系记录
        contact['content'] = $("#content").val();
        if(contact['content'] == ""){
            alert('联系记录不可为空!');
            return false;
        }
        //获取联系状态
        contact['call_status'] = $("#call_status").find("option:selected").val();
        if(contact['call_status'] == 0){
            alert("通话状态不可为空!");
            return false;
        }
        contact['next_contact_time'] = $("#datepicker").val();
        if(contact['next_contact_time'] !=""){
            var myDate = new Date();
            var year   = myDate.getFullYear();
            var month  = myDate.getMonth()+1;  //获取当前月份(0-11,0代表1月)
            var day    = myDate.getDate();
            var todayTime = year+""+month+""+day; //获取今日的时间
            var timePost= "";
            //用户选择的时间
            var timePostTemp = contact['next_contact_time'].split('-');
            for(var i = 0 ;i<timePostTemp.length;i++){
                timePost += timePostTemp[i];
            }
            //时间判断
            if(parseInt(timePost) <= parseInt(todayTime)){
                    alert("时间不可为过去");
                    return false;
            }
        }
        //获取保单状态
        var followStatusFinish = "";
        var followStatusAgain = "";
        var followAll   = $("input[class='followAll']").filter(':checked');
        for(var i = 0;i<followAll.length;i++){
            followStatusFinish += followAll[i].id + ',';
        }
        var followFinish = $("input[class='followFinish']").filter(':checked');
        for(var i = 0;i<followFinish.length;i++){
            followStatusAgain += followFinish[i].id + ',';
        }
        if(followStatusAgain!=""){
            if(contact['next_contact_time'] == ""){
                alert("下次联系时间不可为空!");
                return false;
            }
        }

        $.post("/follow/detail/updateInformation",{ data , contact ,'followStatusFinish':followStatusFinish,'followStatusAgain':followStatusAgain,"uid": uid}, function (data) {
            data = JSON.parse(data||"null");
            if(data.code == 0 ){
                alert(data.message);
                window.location.reload(true);
            }else{
                alert(data.message);
            }
        });
    }

};


var FollowList = {
    request:function(dataObj){
        var html = '';
        var followList = $("#followList");
        var dataFirst = followList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">'+
            '<td colspan="'+ tdLen +'">'+
            '<div class="cover">'+
            '<div class="searLoading">'+
            '<p>结果正在查询中,请等待!</p>'+
            '</div></div></td></tr>';
        followList.html(load);
        $.get("/follow/index/getFollowList", dataObj, function (data) {
            data = JSON.parse(data||"null");
            console.log(data);
            if (data.code == 0) {
                list = data.data;
                if(list.length == 0){
                    var error = '<tr><td style="text-align: center" colspan="'+ tdLen +'">查询暂无数据。</td></tr>';
                    followList.html(error);
                    return false;
                }

                for (var i = 0; i < list.length; i++) {
                    listI = list[i];
                    var starNum = "";var star = [1,2,3];
                    for(var j = 0;j<3;j++){
                        if(star[j] == listI.star){
                            for(var k = 0;k<star[j];k++){
                                starNum += "<font color='red'>★</font>";
                            }
                        }
                    }
                    if(listI.source != null){
                        //声明一个变量来存储图标
                        var storage = ""
                        var str = new Array();
                        //声明一个数组
                        str = listI.source.split(',');
                        for(var q = 0; q< str.length;q++){
                            if(str[q] == 1 ){
                                storage += "<img src='../../dist/icons/zhi.png' width='20px'>&nbsp;"
                            }else if(str[q] == 2){
                                storage += "<img src='../../dist/icons/xu.png' width='20px'>&nbsp;";
                            }else{
                                storage += "<img src='../../dist/icons/tui.png' width='20px'>&nbsp;"
                            }
                        }
                    }else{
                        storage = "";
                    }

                    if(listI.is_new == 1){
                        listI.is_new = "<img src='../../dist/icons/new.png' width='40px'>";
                    }else{
                        listI.is_new = "";
                    }
                    if(listI.is_again == 1){
                        listI.is_again = "<img src='../../dist/icons/again.png' width='40px'>";
                    }else{
                        listI.is_again = "";
                    }


                    //姓名判断
                    var name = ""
                    if(listI.name == null){
                        if(listI.nickname == ""){
                            name = "";
                        }else{
                            name = listI.nickname;
                        }
                    }else{
                        name = listI.name;
                    }
                    html +=
                        '<tr>' +
                        '<td>' +  name + listI.is_new +listI.is_again+'</td>' +
                        '<td>' + listI.mobile_number+ '</td>' +
                        '<td>' + starNum + '</td>' +
                        '<td>' + storage + '</td>' +
                        '<td>' + listI.created_time + '</td>' +
                        '<td>' + listI.last_time  + '</td>' +
                        '<td>' + listI.next_contact_time + '</td>' +
                        '<td>' + listI.opadmin_id + '</td>' +
                        '<td><a type="button" href="/follow/detail/index?id='+listI.uid+'"   class="btn btn-block btn-primary btn-xs" target="_Blank" >跟进</a></td>' +
                        '</tr>';
                }
                followList.html(html);
                //如果是第一次加载
                if (dataFirst == 'false') {
                    FollowList.pagination(data.count,20, dataObj);
                    followList.attr('data-first', true);
                }
            }else{

            }
        });

    },pagination: function (count, pageSize, dataObj) {
        //调用分页插件
        $("#allowFollow").pagination(count, {
            num_edge_entries: 2,
            num_display_entries: 8,
            items_per_page: pageSize,
            prev_text: '上一页',
            next_text: '下一页',
            link_to: 'javascript:void(0)',
            callback: callbackLoadList  //回调函数
        });
        function callbackLoadList(page_id, jq) {
            $('html, body').animate({scrollTop: 0}, 'normal');
            dataObj.page = page_id + 1;
            FollowList.request(dataObj);
        }
    }
}
//工具类 修改用户手机号
var Tool = {
    changeUserMobile:function(id){
        //用户id
        var userId = id;
        //获取用户手机号码
        var mobile = $("#mobile").val().trim();
        var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
        if(userId == ""){
            alert('用户不存在!');
            return false;
        }
        if(mobile == ""){
            alert('手机号为空!');
            return false;
        }else if(!myreg.test(mobile)){
            alert('手机号不合法');
            return false;
        }
       $.post("/follow/detail/changeUserMobile",{'mobile':mobile,'userId':userId}, function (data) {
           data = JSON.parse(data||"null");
           if(data.data == 1 ){
               alert(data.message);
               $("#phone").text(data.res);
           }else{
               alert(data.message);
           }
        });
    }
    ,showContact:function(id){
        var contact = $("#contactDetailInformation");
        var html = '';
        $.post("/follow/detail/showContactDetail",{'id':id}, function (data) {
            data = JSON.parse(data||"null");
            console.log(data);
            html +=
                '<form class="form-horizontal">'+
                '<div class="form-group">'+
                '<label for="inputEmail3" class="col-sm-4 control-label">联系时间:</label>'+
                '<div class="col-xs-8">'+
                '<p>'+ data.created_time+'</p>'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label for="inputEmail3" class="col-sm-4 control-label">通话状态:</label>'+
                '<div class="col-xs-8">'+
                '<p>'+ data.call_status+'</p>'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label for="inputEmail3" class="col-sm-4 control-label">联系内容:</label>'+
                '<div class="col-xs-8">'+
                '<p>'+ data.content +'</p>'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label for="inputEmail3" class="col-sm-4 control-label">客服:</label>'+
                '<div class="col-xs-8">'+
                '<p>'+ data.opadmin_id+'</p>'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label for="inputEmail3" class="col-sm-4 control-label">下次联系时间:</label>'+
                '<div class="col-xs-8">'+
                '<p>'+ data.next_contact_time+'</p>'+
                '</div>'+
                '</div>'+
                '</form>'+
                '<hr>'
                contact.html(html);
        });
    }
   }


var PolicyInfo = {
  init:function(){
    this.begin();
  },
    begin:function(){
        var dataObj = {};
        var uid = $("#uid").val();
        dataObj['uid']  = uid;
        PolicyList.request(dataObj);
    }
};
var PolicyList = {
    request:function(dataObj){
        var html = '';
        var followList = $("#followList");
        var dataFirst = followList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">'+
            '<td colspan="'+ tdLen +'">'+
            '<div class="cover">'+
            '<div class="searLoading">'+
            '<p>结果正在查询中,请等待!</p>'+
            '</div></div></td></tr>';
        followList.html(load);
        $.get("/follow/detail/getAllPolicyInformation", dataObj, function (data) {
            data = JSON.parse(data||"null");
            if (data.code == 0) {
                list = data.data;
                console.log(list.length);
                if(list.length == 0){
                    var error = '<tr><td style="text-align: center" colspan="'+ tdLen +'">查询暂无数据。</td></tr>';
                    followList.html(error);
                    return false;
                }
                for (var i = 0; i < list.length; i++) {
                    listI = list[i];
                    html +=
                        '<tr>' +
                        '<td>' + listI.source + '</td>' +
                        '<td>' + listI.product_id + '</td>' +
                        '<td>' + listI.holder_name + '</td>' +
                        '<td>' + listI.insured_name + '</td>' +
                        '<td>' + listI.created_time + '</td>' +
                        '<td>' + listI.status  + '</td>' +
                        '<td><a  href="/policy/detail/index?id='+listI.policy_id+'" type="button" class="btn btn-block btn-primary btn-xs" target="_Blanks">保单详情</a></td>' +
                        '</tr>';
                }
                followList.html(html);
                //如果是第一次加载
                if (dataFirst == 'false') {
                    PolicyList.pagination(data.count,5, dataObj);
                    followList.attr('data-first', true);
                }
            }else{
                alert('加载失败!!');

            }
        });
    },pagination: function (count, pageSize, dataObj) {
        //调用分页插件
        $("#allowFollow").pagination(count, {
            num_edge_entries: 2,
            num_display_entries: 8,
            items_per_page: pageSize,
            prev_text: '上一页',
            next_text: '下一页',
            link_to: 'javascript:void(0)',
            callback: callbackLoadList  //回调函数
        });
        function callbackLoadList(page_id, jq) {
            $('html, body').animate({scrollTop: 0}, 'normal');
            dataObj.page = page_id + 1;
            PolicyList.request(dataObj);
        }
    }
}

