/*
 * Copyright (c) 2017. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
var noticeInfo = {
    //修改/新增notice
    init: function () {
        this.begin();
    },
    begin: function () {
        var dataObj = {};
        dataObj['page'] = 1;
        NoticeList.request(dataObj);
    },
    editNotice: function () {
        var dataObj = {};
        dataObj['content'] = $("#content").val().trim();
        dataObj['status'] = $("input[type='radio']:checked").val();
        dataObj['time'] = $("#time").val();
        dataObj['sort'] = $("#sort").val();
        dataObj['notice_id'] = $("#notice_id").val();
        if (dataObj['content'] == '' || dataObj['status'] == '' || dataObj['time'] == '') {
            alert('内容/状态/时间都是必填项!');
            return false;
        }

        $.get("/operate/notice/editNotice", dataObj, function (data) {
            data = JSON.parse(data);
            if (data.code == "0") {
                alert(data.message);
                window.location = '/notice/notice/index';
            } else {
                alert(data.message);
            }
        });
    }
}
//列表页
var NoticeList = {
    request: function (dataObj) {
        var html = '';
        var noticeList = $("#noticeList");
        var dataFirst = noticeList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        noticeList.html(load);
        $.get("/notice/Notice/getNoticeList", dataObj, function (data) {
            data = JSON.parse(data || "null");
            console.log(data);
            if (data.code == 0) {
                list = data.data;
                if (list.length == 0) {
                    var error = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                    noticeList.html(error);
                    return false;
                }
                for (var i = 0; i < list.length; i++) {
                    listI = list[i];
                    html += '<tr>' +
                        '<td>' + listI.id + '</td>' +
                        '<td>' + listI.content + '</td>' +
                        '<td>' + listI.show_time + '</td>' +
                        '<td>' + listI.sort + '</td>' +
                        '<td>' + listI.create_time + '</td>' +
                        '<td>' + listI.update_time + '</td>' +
                        '<td>' + '<a  href="/notice/notice/edit?id= ' + listI.id + '" type="button" class="btn btn-block btn-primary btn-xs" target="_Blank">编辑</a>' + '</td>' +
                        '</tr>';
                }
                noticeList.html(html);
                //如果是第一次加载
                if (dataFirst == 'false') {
                    NoticeList.pagination(data.count, 15, dataObj);
                    noticeList.attr('data-first', true);
                }
            } else {
                alert(data.message);
            }
        });

    }, pagination: function (count, pageSize, dataObj) {
        //调用分页插件
        $("#allowNotice").pagination(count, {
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
            NoticeList.request(dataObj);
        }
    }
}

var bannerInfo = {
    init: function () {
        this.begin();
    }, begin: function () {
        var dataObj = {};
        dataObj['page'] = 1;
        BannerList.request(dataObj);
    },
    upload: function () {
        var dataObj = {};
        dataObj['img_url'] = $("#img_url").val();
        dataObj['type'] = $("#type option:selected").val();
        dataObj['href'] = $("#href").val();
        dataObj['sort'] = $("#sort").val();
        dataObj['begin_date'] = $("#begin_date").val();
        dataObj['end_date'] = $("#end_date").val();
        dataObj['is_show'] = $("input[type='radio']:checked").val();
        dataObj['banner_id'] = $("#banner_id").val();
        if (dataObj['sort'] == "" ||dataObj['img_url'] == "" || dataObj['type'] == "" || dataObj["href"] == "" || dataObj["begin_date"] == "" || dataObj['end_date'] == "" || dataObj['is_show'] == "") {
            alert("不可为空");
            return false;
        }
        $.get("/operate/banner/editBanner", dataObj, function (data) {
            data = JSON.parse(data);
            if (data.code == "0") {
                alert(data.message);
                window.location = '/notice/banner/index';
            } else {
                alert(data.message);
            }
        });

    }
}

var BannerList = {
    request: function (dataObj) {
        var html = '';
        var bannerList = $("#bannerList");
        var dataFirst = bannerList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        bannerList.html(load);
        $.get("/notice/Banner/Ajaxgetbannerlist", dataObj, function (data) {
            data = JSON.parse(data || "null");
            console.log(data);
            if (data.code == 0) {
                list = data.data.list;
                if (list.length == 0) {
                    var error = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                    bannerList.html(error);
                    return false;
                }
                for (var i = 0; i < list.length; i++) {
                    listI = list[i];
                    html += '<tr>' +
                        '<td>' + listI.id + '</td>' +
                        '<td>' + listI.type + '</td>' +
                        '<td>' + listI.href + '</td>' +
                        '<td>' + listI.sort + '</td>' +
                        '<td>' + listI.is_show + '</td>' +
                        '<td>' + '<img src="'+listI.img_url+'" width="50px" height="40px">'+ '</td>' +
                        '<td>' + listI.begin_date + '</td>' +
                        '<td>' + listI.end_date + '</td>' +
                        '<td>' + '<a  href="/notice/banner/edit?id= ' + listI.id + '" type="button" class="btn btn-block btn-primary btn-xs" target="_Blank">编辑</a>' + '</td>' +
                        '</tr>';
                }
                bannerList.html(html);
                //如果是第一次加载
                if (dataFirst == 'false') {
                    BannerList.pagination(data.count, 10, dataObj);
                    bannerList.attr('data-first', true);
                }
            } else {
                alert(data.message);
            }
        });

    }, pagination: function (count, pageSize, dataObj) {
        //调用分页插件
        $("#allowBanner").pagination(count, {
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
            BannerList.request(dataObj);
        }
    }
}