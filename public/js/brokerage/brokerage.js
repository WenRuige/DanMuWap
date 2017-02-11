/**
 * Created by gewenrui on 2016/12/7.
 */
var BrokerageInfo = {
    init:function () {
        this.begin();
    },
    begin:function () {
        var dataObj = {};
        dataObj['page'] = 1;
        BrokerageList.request(dataObj);
    },show:function (product_id) {
        var brokerageDetail = $("#brokerageDetail");
        var html = '';
        $.get("/brokerage/index/showBrokerageDetail", {product_id:product_id}, function (data) {
            data = JSON.parse(data);
            if(data.code == 0){
                list = data.data;
                for(var i = 0;i < list.length;i++){
                    listI = list[i];
                    html += '<tr>' +
                        '<td>' + listI.begin_date + '</td>' +
                        '<td>' + listI.end_date + '</td>' +
                        '<td>' +listI.brokerage_actrate+'%'+'</td>' +
                        '</tr>';
                }
                brokerageDetail.html(html);
            }
        });
    },save:function () {
        var productId = parseInt($("#productId").text().trim());
        var brokerage_extrate = $("#brokerage_extrate").val();
                var isFormValid = true;
            $('input[type="text"]').each(function() {
                if($.trim($(this).val()).length == 0){
                    isFormValid =  false;
                }
            });
            console.log(isFormValid);
            if(!isFormValid){
                alert('不可为空!');
                return false;
            }

        if(productId == "" || isNaN(productId)||brokerage_extrate == ""){
            alert('基础佣金/间接佣金/产品不可为空!');
            return false;
        }

        $.ajax({
            cache: true,
            type: "GET",
            url:'/operate/brokerage/saveData',
            data:$('#myForm').serialize()+"&val="+$("#current").val()+"&productId="+productId,
            async: false,
            error: function(request) {
                alert("未知错误");
            },
            success: function(data) {
             data = JSON.parse(data);
             alert(data.message);
                window.location.href = '/brokerage/index/index';


            }
        });
    },showProductId:function () {
        var value = $('#productTitle option:selected').val();
        $("#productId").text(value);
        $.get("/brokerage/index/ajaxCheckIsExits",{id: $("#productId").text()}, function (data) {
            data = JSON.parse(data);
            if(data.code !='00006'){
                flag = true;
            }else{
                $("#productId").html("<font color='red'>该商品已经存在</font>");
                //alert(data.message);
            }
        });
    }
}

//佣金列表
var BrokerageList = {
    request: function (dataObj) {
        var html = '';
        var brokerageList = $("#brokerageList");
        var dataFirst = brokerageList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        brokerageList.html(load);
        $.get("/brokerage/index/showBrokerageList", dataObj, function (data) {
            data = JSON.parse(data || "null");
            if (data.code == 0) {
                list = data.data;
                if (list.length == 0) {
                    var error = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                    brokerageList.html(error);
                    return false;
                }
                for (var i = 0; i < list.length; i++) {
                    listI = list[i];
                    listI.total = parseInt(listI.brokerage_rate,10) + parseInt(listI.brokerage_actrate,10);
                    html += '<tr>' +
                        '<td>' + listI.product_name + '</td>' +
                        '<td>' + listI.product_id + '</td>' +
                        '<td>' + listI.total+'%'+ '('+listI.brokerage_rate+'%'+'+'+listI.brokerage_actrate+'%)'+'</td>' +
                        '<td>' + listI.brokerage_extrate +'%'+ '</td>' +
                        '<td>' + listI.begin_date  +'</td>' +
                        '<td>' + listI.end_date + '</td>' +
                        '<td>' +
                        '<div class="form-group">'+
                        '<div class="col-xs-6">'+
                        '<a  href="/brokerage/index/edit?product_id=' + listI.product_id+'"  type="button"  class="btn btn-block btn-primary btn-xs" target="_Blank">编辑</a>' +
                        '</div>'+
                        '<div class="col-xs-6">'+
                        '<a  href="#" type="button" onclick="BrokerageInfo.show(\'' + listI.product_id + '\')"  data-toggle="modal" data-target="#myModal" class="btn btn-block btn-warning btn-xs" target="_Blank">历史</a>' +
                        '</div>'+
                        '</div>'+
                        '</td>'+
                        '</tr>';
                }
                brokerageList.html(html);
                //如果是第一次加载
                if (dataFirst == 'false') {
                    BrokerageList.pagination(data.count, 15, dataObj);
                    brokerageList.attr('data-first', true);
                }
            }else{
                alert(data.message);
            }
        });

    }, pagination: function (count, pageSize, dataObj) {
        //调用分页插件
        $("#allowProduct").pagination(count, {
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
            BrokerageList.request(dataObj);
        }
    },
    showAllProduct:function () {
        var productHTML='',
            productList = $('#productTitle');
        $.get('/brokerage/index/showAllProduct', function (data) {
            console.log(data);
            productHTML = '<option value="">请选择</option>';
            for(var i = 0;i<data.length;i++){
                if(data[i].id!='') {
                    productHTML += '<option value="' + data[i].product_id + '">' + data[i].product_id +'.'+data[i].product_name +'</option>';
                }
            }
            productList.html(productHTML);
        },'json');

    }
}