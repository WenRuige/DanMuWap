//产品详情信息
var TemplateInfo = {
    init: function () {
        this.begin();
    },
    begin: function () {
        var dataObj = {};
        dataObj['page'] = 1;
        TemplateList.request(dataObj);
    },
}


//产品列表页面
var TemplateList = {
    request: function (dataObj) {
        var html = '';
        var templateList = $("#templateList");
        var dataFirst = templateList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        templateList.html(load);
        $.get("/poster/template/ajaxlist", dataObj, function (data) {
            data = JSON.parse(data || "null");
            console.log(data);
            if (data.code == 0) {
                list = data.data;
                if (list.length == 0) {
                    var error = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                    templateList.html(error);
                    return false;
                }
                for (var i = 0; i < list.length; i++) {
                    listI = list[i];
                    html += '<tr>' +
                        '<td>' + listI.id + '</td>' +
                        '<td>' + listI.tpl_name + '</td>' +
                        '<td>' + listI.type_name + '</td>' +
                        '<td>' + listI.start_time + '至' + listI.end_time + '</td>' +
                        '<td><img src="' + listI.tpl_pic + '" style="width:50px;"/></td>' +
                        // '<td>' + '<input type="text"  value="'+listI.sortby+'" onchange="ProductInfo.updateSort(\'' + listI.product_id + '\',\'' + this + '\')">' + '</td>' +
                        '<td>' +
                        '<div class="form-group">' +
                        '<div class="col-xs-6">' +
                        '<a  href="/poster/template/edit?id=' + listI.id + '"  type="button"  class="btn  btn-primary btn-xs" target="_Blank">编辑</a>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '</tr>';
                }
                templateList.html(html);
                //如果是第一次加载
                if (dataFirst == 'false') {
                    TemplateList.pagination(data.count, 15, dataObj);
                    templateList.attr('data-first', true);
                }
            } else {
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
            TemplateList.request(dataObj);
        }
    }
}

var TemplateEdit = {
    init: function () {
        this.begin();
    },
    begin: function () {
    },
    addTemplate: function () {
        //设置同步
        $.ajaxSetup({
            async: false //取消异步
        });
        var dataObj = {};
        //将string 转化为 int
        dataObj['tpl_id'] = parseInt($("#tplId").attr("attrid").trim());
        if(!dataObj['tpl_id']){
            dataObj['tpl_id'] = 0;
        }

        console.log(dataObj);
        dataObj['type'] = $("#tplType option:selected").val().trim();
        dataObj['tpl_name'] = $("#tplName").val().trim();
        dataObj['tpl_pic'] = $("#tplPic").attr("src").trim();
        dataObj['tpl_pic_show'] = $("#tplPic_show").attr("src").trim();
        dataObj['start_time'] = $("#start_time").val().trim();
        dataObj['end_time'] = $("#end_time").val().trim();
        dataObj['use_count'] = $("#useCount").val().trim();
        var tmp_upload_pic = $("#uploadImgSrc").attr("attrpath").trim();
        var tmp_upload_pic_show = $("#uploadImgSrcShow").attr("attrpath").trim();
        if(tmp_upload_pic){
            dataObj['tpl_pic'] = tmp_upload_pic;
        }
        if(tmp_upload_pic_show){
            dataObj['tpl_pic_show'] = tmp_upload_pic_show;
        }

        if(!dataObj['start_time']){
            dataObj['start_time'] = '2017-01-01';
        }

        if(!dataObj['end_time']){
            dataObj['end_time'] = '2018-01-01';
        }
        var product_id = parseInt($("#productId").val().trim());
        if (dataObj['type'] == 3 && !product_id) {
            alert('请填入商品ID');
            return false;
        }

        var position = {};
        position['qr_x'] = $("#qr_x").val().trim();
        position['qr_y'] = $("#qr_y").val().trim();
        position['qr_font']  = $("#qr_font").val().trim();
        position['qr_size']  = $("#qr_size").val().trim();
        position['qr_color'] = $("#qr_color").val().trim();
        position['qr_measure'] = $("#qr_measure").val().trim();

        position['mobile_x'] = $("#mobile_x").val().trim();
        position['mobile_y'] = $("#mobile_y").val().trim();
        position['mobile_font']  = $("#mobile_font").val().trim();
        position['mobile_size']  = $("#mobile_size").val().trim();
        position['mobile_color'] = $("#mobile_color").val().trim();
        position['mobile_measure'] = $("#mobile_measure").val().trim();

        position['username_x'] = $("#username_x").val().trim();
        position['username_y'] = $("#username_y").val().trim();
        position['username_font']  = $("#username_font").val().trim();
        position['username_size']  = $("#username_size").val().trim();
        position['username_color'] = $("#username_color").val().trim();
        position['username_measure'] = $("#username_measure").val().trim();

        position['product_id'] = product_id;

        if (!dataObj['tpl_name'] || !dataObj['tpl_pic'] || !dataObj['tpl_pic_show']) {
            alert('请填入必填项');
            return false;
        }
        dataObj['extra'] = JSON.stringify(position);
        dataObj['start_time'] = dataObj['start_time'] + ' 00:00:00';
        dataObj['end_time'] = dataObj['end_time'] + ' 23:59:59';
        $.get("/poster/template/ajaxaddtemplate", dataObj, function (data) {
            data = JSON.parse(data);
            if (data.code == "0") {
                alert("操作成功");
                window.location = '/poster/template/index';
            } else {
                alert(data.message);
            }
        });

    }
}
