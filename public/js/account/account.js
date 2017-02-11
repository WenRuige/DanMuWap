//好友查询
var AccountInfo = {
    init: function () {
        this.begin();
    },
    begin: function () {
        var dataObj = {};
        dataObj['page'] = 1;
    },
    //查找代理人
    findUser: function () {
        //查询的类别
        var text = $("#searchContent").val();
        var data = {};
        var tdLen = $("#table>thead>tr").find("th").length;
        var selfList = $("#selfList");
        var parentList = $("#parentList");
        var selfHtml = "";
        var parentHtml = "";
        if (text == "") {
            alert('不可空查');
            return false;
        }
        data['text'] = text;
        //写到一个方法因为ajax是异步的
        $.get("/account/friend/ajaxSearchSelf", data, function (data) {
            data = JSON.parse(data);
            if (data.code == '0') {
                //如果值为空的话
                if (data.data == "") {
                    selfHtml = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';

                } else {
                    var list = data.data;
                    selfHtml += '<tr>' +
                        '<td>' + list.id + '</td>' +
                        '<td>' + list.mobile + '</td>' +
                        '<td>' + list.create_time + '</td>' +
                        '<td>' + list.created_at + '</td>' +
                        '<td>' + list.updated_at + '</td>' +
                        '<td>' + list.agent_code + '</td>' +
                        '</tr>'

                }
                selfList.html(selfHtml);
            } else {
                alert(data.message);
            }

        });
        $.get("/account/friend/ajaxSearchParent", data, function (data) {
            data = JSON.parse(data);
            if (data.code == '0') {
                //如果值为空的话
                if (data.data == "") {
                    parentHtml = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';

                } else {
                    var list = data.data;
                    parentHtml += '<tr>' +
                        '<td>' + list.id + '</td>' +
                        '<td>' + list.mobile + '</td>' +
                        '<td>' + list.create_time + '</td>' +
                        '<td>' + list.created_at + '</td>' +
                        '<td>' + list.updated_at + '</td>' +
                        '<td>' + list.agent_code + '</td>' +
                        '</tr>'

                }
                parentList.html(parentHtml);
            } else {
                alert(data.message);
            }
        });
        AccountList.request(data);
    }
}

var AccountList = {
    request: function (dataObj) {
        var html = '';
        var subList = $("#subList");
        var dataFirst = subList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        subList.html(load);
        $.get("/account/friend/ajaxSearchSub", dataObj, function (data) {
            console.log(data);
            data = JSON.parse(data);
            console.log(data);
            if (data.code == '0') {
                //如果值为空的话
                if (data.data == "") {
                    html = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';

                } else {
                    var list = data.data;
                    for (var i = 0; i < list.length; i++) {
                        listI = list[i];
                        html += '<tr>' +
                            '<td>' + listI.user_id + '</td>' +
                            '<td>' + listI.mobile + '</td>' +
                            '<td>' + listI.create_time + '</td>' +
                            '<td>' + listI.created_at + '</td>' +
                            '<td>' + listI.updated_at + '</td>' +
                            '<td>' + listI.agent_code + '</td>' +
                            '</tr>'
                    }
                }
                subList.html(html);
                if (dataFirst == 'false') {
                    AccountList.pagination(data.count, 5, dataObj);
                    subList.attr('data-first', true);
                }
            } else {
                alert(data.message);
            }
        });
    }, pagination: function (count, pageSize, dataObj) {
        //调用分页插件
        $("#allowAccount").pagination(count, {
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
            AccountList.request(dataObj);
        }
    }
}


//账户查询
var Account = {
    findAccount: function () {
        var text = $("#searchContent").val();
        var tdLen = $("#table>thead>tr").find("th").length;
        var data = {};
        var html = "";
        var accountList = $("#accountList");
        data['text'] = text;
        $.get("/account/account/ajaxSearchAccount", data, function (data) {
            data = JSON.parse(data);
            console.log(data);
            if (data.code == '0') {
                //如果值为空的话
                if (data.data == "") {
                    html = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                } else {
                    var list = data.data;
                    html += '<tr>' +
                        '<td>' + list.id + '</td>' +
                        '<td>' + list.mobile + '</td>' +
                        '<td>' + list.username + '</td>' +
                        '<td>' + list.balance + '</td>' +
                        '<td>' + list.user_type + '</td>' +
                        '<td>' + list.create_time + '</td>' +
                        '<td>' + list.num + '</td>' +
                        '<td>' + '<a  href="/account/detail/index?id=' + list.id + '" type="button" class="btn btn-block btn-primary btn-xs" target="_Blank">账号详情</a>' + '</td>' +
                        '</tr>'

                }
                accountList.html(html);
            } else {
                alert(data.message);
            }

        });
    }
}

//账号下保单列表
var policyInfo = {
    init: function () {
        //alert(1);
        this.clear();
        this.begin();
        this.list();
    }, begin: function () {
        var dataObj = {};
        dataObj['page'] = 1;
        dataObj['userid'] = this.url();
        policyList.request(dataObj);
    }, clear: function () {
        $("input").each(function () {
            $(this).val('');
        });
    },
    //获取url
    url: function () {
        var url = location.search; //获取url中"?"符后的字串
        if (url.indexOf("?") != -1) {
            var str = url.substr(1);
            var data = str.split('=');
            return data[1];
        }
    },
    list: function () {
        var policyStatusHtml = '',
            policyStatus = $('#policy_status');
        $.get('/account/account/ajaxGetPolicyStatus', function (data) {
            policyStatusHtml = '<option value="">请选择</option>';
            for (var i = 0; i < data.length; i++) {
                if (data[i].id != '') {
                    policyStatusHtml += '<option value="' + data[i].id + '">' + data[i].value + '</option>';
                    // console.log(data[i].id+data[i].value);
                }
            }
            policyStatus.html(policyStatusHtml);
        }, 'json');
        //查找保单
    }, findPolicy: function () {
        var dataObj = {};
        dataObj['userid'] = this.url();
        dataObj['op_policyno'] = $("#op_policyno").val();
        dataObj['oph_name'] = $("#oph_name").val();
        dataObj['opi_name'] = $("#opi_name").val();
        dataObj['op_create_time'] = $("#op_create_time").val();
        dataObj['oph_id_number'] = $("#oph_id_number").val();
        dataObj['opi_id_number'] = $("#opi_id_number").val();
        dataObj['oph_mobile_number'] = $("#oph_mobile_number").val();
        dataObj['op_policy_status'] = $("#policy_status").val();
        dataObj['page'] = 1;
        $("#allowAccount").html('');
        $("#PolicyList").attr('data-first', 'false');
        policyList.request(dataObj);
    }
}


var policyList = {
    request: function (dataObj) {
        // return false;
        var html = '';
        var PolicyList = $("#PolicyList");
        var dataFirst = PolicyList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        PolicyList.html(load);
        $.get("/account/account/ajaxGetPolicyOrder", dataObj, function (data) {
            data = JSON.parse(data);
            if (data.code == '0') {
                //如果值为空的话
                if (data.data == "") {
                    html = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';

                } else {
                    var list = data.data.data;
                    console.log(list);
                    for (var i = 0; i < list.length; i++) {
                        listI = list[i];
                        html += '<tr>' +
                            '<td>' + listI.id + '</td>' +
                            '<td>' + '<a href="/account/order/detail?order_id=' + listI.order_id + '" target="_Blank">' + listI.order_id + '</a>' + '</td>' +
                            '<td>' + listI.order_policyno + '</td>' +
                            '<td>' + listI.policyno + '</td>' +
                            '<td>' + listI.policy_status + '</td>' +
                            '<td>' + listI.holder_name + '</td>' +
                            '<td>' + listI.insured_name + '</td>' +
                            '<td>' + listI.create_time + '</td>' +
                            '<td>' + listI.begin_date + '至' + listI.end_date + '</td>' +
                            '<td>' + '<a href="/account/policy/detail?id=' + listI.id + '" type="button" class="btn btn-block btn-primary btn-xs" target="_Blank">保单详情</a>' + '</td>' +
                            '</tr>'
                    }
                }
                PolicyList.html(html);
                if (dataFirst == 'false') {
                    policyList.pagination(data.data.count, 20, dataObj);
                    PolicyList.attr('data-first', true);
                }
            } else {
                alert(data.message);
            }
        });
    }, pagination: function (count, pageSize, dataObj) {
        //调用分页插件
        $("#allowAccount").pagination(count, {
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
            policyList.request(dataObj);
        }
    }
}

var brokerageInfo = {
    init: function () {

    }
    , begin: function () {

    }, findBrokerage: function () {
        var dataObj = {};
        var html = "";
        var brokerageHtml = '';
        var userList = $("#userList");
        var brokerageList = $("#brokerageList");
        dataObj['date'] = $("#datepicker").val();
        dataObj['information'] = $("#information").val();
        if (dataObj['date'] == "" || dataObj['information'] == "") {
            alert('这两项为必选项');
            return false;
        }
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        brokerageList.html(load);
        $.get("/account/brokerage/ajaxSearchUser", dataObj, function (data) {
            data = JSON.parse(data);
            console.log(data);
            if (data.code == '0') {
                //如果值为空的话
                if (data.data == "") {

                    html = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                } else {
                    var list = data.data;
                    html += '<tr>' +
                        '<td>' + list.id + '</td>' +
                        '<td>' + list.username + '</td>' +
                        '<td>' + list.mobile + '</td>' +
                        '<td>' + list.balance + '</td>' +
                        '<td>' + '<a  href="/account/brokerage/balanceDetail?id=' + list.id + '" type="button" class="btn btn-block btn-primary btn-xs" target="_Blank">余额明细</a>' + '</td>' +
                        '</tr>'

                }
                userList.html(html);
            } else {
                alert(data.message);
            }

        });

        $.get("/account/brokerage/ajaxSearchBrokerageSource", dataObj, function (data) {
            data = JSON.parse(data);
            console.log(data);
            if (data.code == '0') {
                //如果值为空的话
                if (data.data == "") {
                    brokerageHtml = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                } else {
                    var listI = data.data;
                    for (var i = 0; i < listI.length; i++) {
                        var list = listI[i];
                        brokerageHtml += '<tr>' +
                            '<td>' + list.source + '</td>' +
                            '<td>' + list.number + '</td>' +
                            '<td>' + list.brokerage + '</td>';
                        if (i != 3) {
                            brokerageHtml += '<td>' + '<a  onclick="brokerageInfo.redirect(\'' + list.source_type + '\')" type="button" class="btn btn-block btn-primary btn-xs" target="_Blank">佣金明细</a>' + '</td>' +
                                '</tr>';
                        }
                    }
                }
                brokerageList.html(brokerageHtml);
            } else {
                alert(data.message);
            }

        });
        //跳转 需要传递的参数,source_type,uid,month
    }, redirect: function (source_type) {
        //获取来源种类
        var source_type = source_type;
        //获取时间日期
        var date = $("#datepicker").val();
        //获取用户id or 手机号
        var information = $("#information").val();
        //判断,如果为
        if (source_type != '3') {
            window.location.href = "/account/brokerage/brokeragedetail?source_type=" + source_type + "&date=" + date + "&information=" + information;
        } else {
            window.location.href = "/account/brokerage/brokeragedetail2?source_type=" + source_type + "&date=" + date + "&information=" + information;

        }
    }
}


var balanceDetail = {
    init: function () {
        this.begin();
    },
    begin: function () {
        var dataObj = {};
        var id = this.url();
        dataObj['page'] = 1;
        dataObj['userid'] = id;
        $("#allowAccount").html();
        $("#balanceList").html('dataFirst', false);
        balanceList.request(dataObj);
    },
    url: function () {
        var url = location.search; //获取url中"?"符后的字串
        if (url.indexOf("?") != -1) {
            var str = url.substr(1);
            var data = str.split('=');
            return data[1];
        }
    }
}
//余额列表
var balanceList = {
    request: function (dataObj) {
        var html = '';
        var BalanceList = $("#balanceList");
        var dataFirst = BalanceList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        BalanceList.html(load);
        $.get("/account/brokerage/ajaxGetBalanceDetail", dataObj, function (data) {
            data = JSON.parse(data);
            console.log(data);
            if (data.code == '0') {
                //如果值为空的话
                if (data.data == "") {
                    html = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                } else {
                    var list = data.data;
                    console.log(list);
                    for (var i = 0; i < list.length; i++) {
                        listI = list[i];
                        html += '<tr>' +
                            '<td>' + listI.name + '</td>' +
                            '<td>' + listI.amount + '</td>' +
                            '<td>' + listI.created_at + '</td>' +
                            '<td>' + listI.record_value + '</td>' +
                            '</tr>'
                    }
                }
                BalanceList.html(html);
                if (dataFirst == 'false') {
                    balanceList.pagination(data.count, 15, dataObj);
                    BalanceList.attr('data-first', true);
                }
            } else {
                alert(data.message);
            }
        });
    }, pagination: function (count, pageSize, dataObj) {
        //调用分页插件
        $("#allowAccount").pagination(count, {
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
            balanceList.request(dataObj);
        }
    }
}
//佣金详情

var brokerageDetail = {
    init: function () {
        this.begin();
    }, url: function (name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null)return unescape(r[2]);
        return null;
    }, begin: function () {
        var dataObj = {};
        dataObj['source_type'] = this.url('source_type');
        dataObj['date'] = this.url('date');
        dataObj['information'] = this.url('information');
        dataObj['page'] = 1;
        brokerageDetailList.request(dataObj);
    }
}

//佣金详细列表详情界面2


//佣金详情列表页面
var brokerageDetailList = {
    request: function (dataObj) {
        var html = '';
        var BrokerageDetailList = $("#brokerageDetailList");
        var dataFirst = BrokerageDetailList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        BrokerageDetailList.html(load);
        var source_type = dataObj['source_type'];
        $.get("/account/brokerage/ajaxGetBrokerageDetail", dataObj, function (data) {
            data = JSON.parse(data);
            console.log(data);
            if (data.code == '0') {
                //如果值为空的话
                if (data.data == "") {
                    html = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';

                } else {
                    var list = data.data;
                    if (source_type == 3) {
                        for (var i = 0; i < list.length; i++) {
                            listI = list[i];
                            html += '<tr>' +
                                '<td>' + listI.name + '</td>' +
                                '<td>' + listI.brokerage + '</td>' +
                                '<td>' + listI.status + '</td>' +
                                '</tr>'
                        }

                    } else {
                        for (var i = 0; i < list.length; i++) {
                            listI = list[i];
                            html += '<tr>' +
                                '<td>' + listI.brokerage_time + '</td>' +
                                '<td>' + listI.name + '</td>' +
                                '<td>' + listI.policyno + '</td>' +
                                '<td>' + listI.premium + '</td>' +
                                '<td>' + listI.brokerage + '</td>' +
                                '<td>' + '生效时间' + '</td>' +
                                '<td>' + listI.status + '</td>' +
                                '</tr>'
                        }
                    }

                }
                BrokerageDetailList.html(html);
                if (dataFirst == 'false') {
                    brokerageDetailList.pagination(data.count, 20, dataObj);
                    BrokerageDetailList.attr('data-first', true);
                }
            } else {
                alert(data.message);
            }
        });
    }, pagination: function (count, pageSize, dataObj) {
        //调用分页插件
        $("#allowAccount").pagination(count, {
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
            brokerageDetailList.request(dataObj);
        }
    }

}
//该保单下的佣金详细
var policyBrokerageInfo = {
    //查询该保单对应的佣金
    findBrokerage: function () {
        var dataObj = {};
        var html = '';
        var BrokerageList = $("#brokeragePolicyList");
        var policyno = $("#policyno").val();
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        BrokerageList.html(load);
        dataObj['policyno'] = policyno.trim();
        $.get("/account/brokerage/getBrokerageByPolicyNo", dataObj, function (data) {
            data = JSON.parse(data);
            if (data.code == '0') {
                //如果值为空的话
                if (data.data == "") {
                    html = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                } else {
                    var listI = data.data;
                    for (var i = 0; i < listI.length; i++) {
                        var list = listI[i];
                        html += '<tr>' +
                            '<td>' + list.name + '</td>' +
                            '<td>' + list.brokerage + '</td>' +
                            '<td>' + list.source_type + '</td>' +
                            '<td>' + list.brokerage_time + '</td>' +
                            '<td>' + list.status + '</td>' +
                            '<td>' + '<a  href="/account/detail/index?id=' + list.user_id + '" type="button" class="btn btn-block btn-primary btn-xs" target="_Blank">账号详情</a>' + '</td>' +
                            '</tr>';

                    }
                }
                BrokerageList.html(html);
            } else {
                alert(data.message);
            }

        });
    }
}

var policySearchInfo = {
    init: function () {
        this.begin();
        this.list();
        this.clear();
    }, begin: function () {

    }, searchPolicy: function () {
        var dataObj = {};
        dataObj['order_id'] = $("#order_id").val();
        dataObj['policyno'] = $("#policyno").val();
        dataObj['policy_time'] = $("#policy_time").val();
        dataObj['policy_status'] = $("#policy_status").val();
        PolicySearchList.request(dataObj);

    }, list: function () {

    }, clear: function () {
        $("input").each(function () {
            $(this).val('');
        });
    }, list: function () {
        var policyStatusHtml = '',
            policyStatus = $('#policy_status');
        $.get('/account/account/ajaxGetPolicyStatus', function (data) {
            policyStatusHtml = '<option value="">请选择</option>';
            for (var i = 0; i < data.length; i++) {
                if (data[i].id != '') {
                    policyStatusHtml += '<option value="' + data[i].id + '">' + data[i].value + '</option>';
                    // console.log(data[i].id+data[i].value);
                }
            }
            policyStatus.html(policyStatusHtml);
        }, 'json');
    }}

    var PolicySearchList = {
        request: function (dataObj) {
            var html = '';
            var policySearchList = $("#policySearchList");
            var dataFirst = policySearchList.attr('data-First');
            var tdLen = $("#table>thead>tr").find("th").length;
            var load = '<tr class="box-body">' +
                '<td colspan="' + tdLen + '">' +
                '<div class="cover">' +
                '<div class="searLoading">' +
                '<p>结果正在查询中,请等待!</p>' +
                '</div></div></td></tr>';
            policySearchList.html(load);
            $.get("/account/policy/Ajaxsearchpolicy", dataObj, function (data) {
                data = JSON.parse(data);
                console.log(data);
                if (data.code == '0') {
                    //如果值为空的话
                    if (data.data == "") {
                        html = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                    } else {
                        var listI = data.data.data;
                        for (var i = 0; i < listI.length; i++) {
                            var list = listI[i];
                            html += '<tr>' +
                                '<td>' + list.id + '</td>' +
                                '<td>' + '<a href="/account/order/detail?order_id='+list.order_id+'">'+ list.order_id +'</a>'+ '</td>' +
                                '<td>' + '<a href="/account/detail/index?id='+list.user_id+'">'+ list.user_id +'</a>'+ '</td>' +
                                '<td>' + list.policyno + '</td>' +
                                '<td>' + list.product_name + '</td>' +
                                '<td>' + list.holder_name + '</td>' +
                                '<td>' + list.insure_name + '</td>' +
                                '<td>' + list.policy_time + '</td>' +
                                '<td>' + '<a  href="/account/policy/detail?id=' + list.id + '" type="button" class="btn btn-block btn-primary btn-xs" target="_Blank">保单详情</a>' + '</td>' +
                                '</tr>';

                        }

                    }
                    policySearchList.html(html);
                    if (dataFirst == 'false') {
                        PolicySearchList.pagination(data.count, 20, dataObj);
                        policySearchList.attr('data-first', true);
                    }
                } else {
                    alert(data.message);
                }
            });
        }, pagination: function (count, pageSize, dataObj) {
            //调用分页插件
            $("#allowAccount").pagination(count, {
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
                PolicySearchList.request(dataObj);
            }
        }

    }




