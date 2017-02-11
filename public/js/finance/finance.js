//退款信息
var refundInfo = {
    init: function () {
        this.linkage();
        this.begin();
        this.openResource();
        this.clear();
    },
    begin: function () {
        var dataObj = {};
        dataObj['page'] = 1;
        RefundList.request(dataObj);
    },
    clear: function () {
        //$("#quit_time").val('');
        $("input").each(function () {
            $(this).val('');
        });
    },//查找退款信息
    findRefund: function () {
        var dataObj = {};
        //退保时间
        dataObj['fr_cancle_time'] = $("#cancle_time").val().trim();
        //保单号
        dataObj['fr_policyno'] = $("#policyno").val().trim();
        //支付平台
        dataObj['fr_pay_platform'] = jQuery("#pay_platform  option:selected").val();
        //退款状态
        dataObj['fr_refund_status'] = jQuery("#refund_status option:selected").val();
        //平台id
        dataObj['fr_platform_tradeno'] = $("#platform_tradeno").val().trim();
        this.openResource(dataObj);
        $('#allowFinance').html('');
        $('#financeList').attr('data-First', 'false');
        RefundList.request(dataObj);
    },//获取支付平台
    linkage: function () {
        var onlinePaymentStatusHTML = '',
            onlinePaymentStatus = $('#pay_platform');
        $.get('/finance/Api/ajaxGetPaymentPlatform', function (data) {
            onlinePaymentStatusHTML = '<option value="">请选择</option>';
            for (var i = 0; i < data.length; i++) {
                if (data[i].id != '') {
                    onlinePaymentStatusHTML += '<option value="' + data[i].id + '">' + data[i].value + '</option>';
                    // console.log(data[i].id+data[i].value);
                }
            }
            onlinePaymentStatus.html(onlinePaymentStatusHTML);
        }, 'json');
        var refundStatusHTML = '',
            refundStatus = $('#refund_status');
        $.get('/finance/Api/ajaxGetRefundStatus', function (data) {
            console.log(data);
            refundStatusHTML = '<option value="">请选择</option>';
            for (var i = 0; i < data.length; i++) {
                if (data[i].id != '') {
                    refundStatusHTML += '<option value="' + data[i].id + '">' + data[i].value + '</option>';
                    // console.log(data[i].id+data[i].value);
                }
            }
            refundStatus.html(refundStatusHTML);
        }, 'json');
    },
    openResource: function (obj) {
        var download = $("#open_resource");
        var dataurl = '/finance/Api/exportRefundList?';
        if (arguments.length == 1) {
            for (var key in obj) {
                dataurl += key + '=' + obj[key] + '&';
            }
            dataurl += 'page=1';
        } else if (arguments.length == 2) {
            dataurl = download.attr('href').split('page=')[0];
            dataurl += 'page=' + $('#download').val();
        } else {
            dataurl += 'page=' + $('#download').val();
        }
        download.attr('href', dataurl);

    }, platformWrite: function (policyno, platform) {
        //记录保单号
        $("#policyNo").val(policyno);
        $("#platform").val(platform);
    }, Refund: function () {
        var policyNo = $("#policyNo").val();
        var platform = $("#platform").val();
        if (policyNo == "") {
            alert("保单号为空");
        }
        $.post('/operate/Refund/Refund', {policyno: policyNo, platform: platform}, function (data) {
            var data = JSON.parse(data);
            alert(data.message);
            window.location.reload();
        });
    }
}

var RefundList = {
    request: function (dataObj) {
        //配置api显示
        var api = ["wap微信支付", "app微信支付", "微信扫码支付"];
        var aliapi = ["wap支付宝", "app支付宝"];
        var html = '';
        var financeList = $("#financeList");
        var dataFirst = financeList.attr('data-first');
        var download = $("#download");
        var downloadHTML = '';
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        financeList.html(load);
        $.get("/finance/api/getRefundlist", dataObj, function (data) {
            data = JSON.parse(data || "null");
            console.log(data);
            if (data.count >= 0) {
                var dnum = Math.ceil(data.count / 5000);
                for (var j = 1; j <= dnum; j++) {
                    downloadHTML += '<option value="' + j + '">导出' + j + '/' + dnum + '</option>';
                }
                download.html(downloadHTML);
            }
            if (data.code == 0) {
                list = data.data;
                if (list.length == 0) {
                    var error = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                    financeList.html(error);
                    return false;
                }
                for (var i = 0; i < list.length; i++) {
                    listI = list[i];
                    var total = parseInt(listI.pay_price) + parseInt(listI.use_balance);
                    //微信开发平台判断
                    html += '<tr>' +
                        '<td>' + listI.holder_name + '</td>' +
                        '<td>' + listI.policyno + '</td>' +
                        '<td>' + listI.create_time + '</td>' +
                        '<td>' + listI.cancle_time + '</td>' +
                        '<td>' + listI.premium + '</td>' +
                        '<td>' + total + "" + "(余额" + listI.use_balance + ')</td>' +
                        '<td>' + listI.pay_platform + '</td>' +
                        '<td>' + listI.platform_tradeno + '</td>' +
                        '<td>' + listI.refund_status + '</td>' +
                        '<td>';

                    if (api.indexOf(listI.pay_platform) > -1) {
                        if (listI.refund_status === "已退保未退款") {
                            html += '<a type="button" class="btn btn-block btn-primary btn-xs"  href="#" data-toggle="modal" data-target="#myModal3" onclick="refundInfo.platformWrite(\'' + listI.policyno + '\',2)">微信退款</a>';
                        }
                    } else if (aliapi.indexOf(listI.pay_platform) > -1) {
                        if (listI.refund_status === "已退保未退款") {
                            html += '<a type="button" class="btn btn-block btn-primary btn-xs"  href="#" data-toggle="modal" data-target="#myModal4" onclick="refundInfo.platformWrite(\'' + listI.policyno + '\',1)">支付宝退款</a>';
                        }
                    } else {
                        if (listI.refund_status === "已退保未退款") {
                            html += '<a type="button" class="btn btn-block btn-primary btn-xs"  href="#" data-toggle="modal" data-target="#myModal4" onclick="refundInfo.platformWrite(\'' + listI.policyno + '\',3)">余额退款</a>';
                        }
                    }
                    html += '</tr>';
                }

                financeList.html(html);
                //如果是第一次加载
                if (dataFirst == 'false') {
                    RefundList.pagination(data.count, 20, dataObj);
                    financeList.attr("data-First", true);
                }

            } else {
                alert(data.message);
            }

        });
    }, pagination: function (count, pageSize, dataObj) {
        //调用分页插件
        $("#allowFinance").pagination(count, {
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
            RefundList.request(dataObj);
        }
    }
}
//同步ajax
$.ajaxSetup({
    async: false
});
//银行卡提现
var bankCardInfo = {
    init: function () {
        this.clear();
        this.select();
        this.begin();

    }, begin: function () {
        var dataObj = {};
        dataObj['page'] = 1;
        this.openResource(dataObj);
        backCardList.request(dataObj);
    }, clear: function () {
        $("input").each(function () {
            $(this).val('');
        });
    }, select: function () {
        var statusHTML = '',
            status = $('#fwr_status');
        $.get('/finance/Bankcard/ajaxGetStatus', function (data) {
            statusHTML = '<option value="">请选择</option>';
            for (var i = 0; i < data.length; i++) {
                statusHTML += '<option value="' + data[i].id + '">' + data[i].value + '</option>';
            }
            status.html(statusHTML);
        }, 'json');
    },
    openResource: function (obj) {
        var download = $("#open_resource");
        var dataurl = '/finance/Bankcard/exportCardInfo?';
        if (arguments.length == 1) {
            for (var key in obj) {
                dataurl += key + '=' + obj[key] + '&';
            }
            dataurl += 'page=1';
        } else if (arguments.length == 2) {
            dataurl = download.attr('href').split('page=')[0];
            dataurl += 'page=' + $('#download').val();
        } else {
            dataurl += 'page=' + $('#download').val();
        }
        download.attr('href', dataurl);

    }, findCardInfo: function () {
        var dataObj = {};
        dataObj['fwc_name'] = $("#fwc_name").val();
        dataObj['fwc_cardno'] = $("#fwc_cardno").val();
        dataObj['fwr_create_time'] = $("#fwr_create_time").val();
        dataObj['fwr_status'] = $("#fwr_status").val();
        this.openResource(dataObj);
        backCardList.request(dataObj);
    }, setProcess: function (flag) {
        var flag = flag;
        var dataObj = {};
        dataObj['fwc_name'] = $("#fwc_name").val();
        dataObj['fwc_cardno'] = $("#fwc_cardno").val();
        dataObj['fwr_create_time'] = $("#fwr_create_time").val();
        dataObj['fwr_status'] = $("#fwr_status").val();
        dataObj['flag'] = flag;
        $.get('/operate/Finance/setCardInfoStatus', dataObj, function (data) {
            var data = JSON.parse(data);
            alert(data.message);
            window.location.reload();
        });
        //直接设置为处理成功
    }, write: function (id) {
        $("#cardinfoId").val(id);
    }, setSuccess: function () {
        var id = $("#cardinfoId").val();
        $.get('/operate/Finance/setCardInfoSingle', {id: id}, function (data) {
            var data = JSON.parse(data);
            alert(data.message);
            window.location.reload();
        });
        //改变状态
    }, printPage: function (id) {
        var id = id;
        var html = '';
        //通过id去读取数据
        $.get('/finance/Bankcard/getBankInformation', {id: id}, function (data) {
            var data = JSON.parse(data);
            console.log(data);
            if (data.code == 0) {
                html += '<form class="form-horizontal">' +
                    '<input type="hidden" id="withdraw_id" value="' + id + '">' +
                    '<div class="form-group">' +
                    '<label for="inputEmail3" class="col-sm-3 control-label">真实姓名:</label>' +
                    ' <div class="col-xs-7">' +
                    '<input type="text" class="form-control" id="truename" value="' + data.data.name + '" placeholder="Enter ..." disabled="">' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="inputEmail3" class="col-sm-3 control-label">手机号:</label>' +
                    '<div class="col-xs-7">' +
                    '<input type="text" class="form-control" id="mobile" value="' + data.data.mobile + '" placeholder="Enter ..." disabled="">' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="inputEmail3" class="col-sm-3 control-label">开户行:</label>' +
                    '<div class="col-xs-7">' +
                    '<select id="bank" class="form-control">';
                var company = ['中国工商银行', '中国农业银行', '中国银行', '中国建设银行', '交通银行', '中信银行', '中国光大银行', '华夏银行', '中国民生银行', '广发银行', '平安银行', '招商银行', '上海普通发展银行'];
                for (var i = 0; i < company.length; i++) {
                    html += '<option value="' + company[i] + '">' + company[i] + '</option>';
                }
                html += '</select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="inputEmail3" class="col-sm-3 control-label">开户行所在地:</label>' +
                    '<div class="col-xs-3">' +
                    '<select id="selProvince" onchange="provinceChange();" class="form-control"></select>' +
                    '</div>' +
                    '<div class="col-xs-4">' +
                    '<select id="selCity" class="form-control"></select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="inputEmail3" class="col-sm-3 control-label">分行:</label>' +
                    '<div class="col-xs-7">' +
                    '<input type="text" id="branch" class="form-control"  value="' + data.data.branch + '"   placeholder="请输入分行">' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="inputEmail3" class="col-sm-3 control-label">支行:</label>' +
                    '<div class="col-xs-7">' +
                    '<input type="text" id="subbranch" class="form-control" value="' + data.data.subbranch + '" placeholder="请输入银行卡号">' +
                    '</div>' +
                    ' </div>' +
                    '<div class="form-group">' +
                    '<label for="inputEmail3" class="col-sm-3 control-label">银行卡号:</label>' +
                    '<div class="col-xs-7">' +
                    '<input type="text" id="cardno" class="form-control" value="' + data.data.cardno + '" placeholder="请输入银行卡号">' +
                    '</div>' +
                    '</div>' +
                    '</form>';


            } else {
                alert(data.message);
            }
        });
        var page = $("#page");
        page.html(html);
        setProvince();
    }, updateInformation: function () {
        var dataObj = {};
        dataObj['name'] = $("#truename").val();
        dataObj['mobile'] = $("#mobile").val();
        dataObj['bank'] = $("#bank").val();
        dataObj['province'] = $('#selProvince option:selected').val();
        dataObj['city'] = $('#selCity option:selected').val();
        dataObj['branch'] = $("#branch").val();
        dataObj['subbranch'] = $("#subbranch").val();
        dataObj['cardno'] = $("#cardno").val();
        dataObj['withdraw_id'] = $("#withdraw_id").val();
        console.log(dataObj);
        $.get('/operate/Finance/updateInformation', dataObj, function (data) {
            var data = JSON.parse(data);
            alert(data.message);
            window.location.reload();
        });

    }
}

var backCardList = {
    request: function (dataObj) {
        var html = '';
        var cardInfoList = $("#cardInfoList");
        var download = $("#download");
        var downloadHTML = '';
        var dataFirst = cardInfoList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        cardInfoList.html(load);
        $.get("/finance/Bankcard/ajaxGetCardInfo", dataObj, function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data.code == '0') {
                //如果值为空的话
                if (data.count >= 0) {
                    var dnum = Math.ceil(data.count / 5000);
                    for (var j = 1; j <= dnum; j++) {
                        downloadHTML += '<option value="' + j + '">导出' + j + '/' + dnum + '</option>';
                    }
                    download.html(downloadHTML);
                }
                if (data.sum) {
                    $("#num").text(data.num);
                    $("#sum").text(data.sum);
                }
                if (data.data == "") {
                    $("#num").text(0);
                    $("#sum").text(0);
                    html = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';

                } else {
                    var list = data.data;
                    for (var i = 0; i < list.length; i++) {
                        listI = list[i];
                        html += '<tr>' +
                            '<td>' + listI.id + '</td>' +
                            '<td>' + listI.user_id + '</td>' +
                            '<td>' + listI.cardno + '</td>' +
                            '<td>' + listI.name + '</td>' +
                            '<td>' + listI.idcard + '</td>' +
                            '<td>' + listI.bank + '</td>' +
                            '<td>' + listI.branch + '</td>' +
                            '<td>' + listI.subbranch + '</td>' +
                            '<td>' + listI.amount + '</td>' +
                            '<td>' + listI.province + '</td>' +
                            '<td>' + listI.city + '</td>' +
                            '<td>' + listI.mobile + '</td>' +
                            '<td>' + listI.create_time + '</td>' +
                            '<td>' + listI.status + '</td>';
                        if (listI.status == "提现中" || listI.status == "处理中") {
                            html += '<td>' + '<a type="button" class="btn btn-block btn-primary btn-xs"  href="#" data-toggle="modal" data-target="#myModal5" onclick="bankCardInfo.write(\'' + listI.id + '\')">提现</a>' +
                                '<a type="button" class="btn btn-block btn-primary btn-xs"  href="#" data-toggle="modal" data-target="#myModal6" onclick="bankCardInfo.printPage(\'' + listI.id + '\')">编辑</a>' + '</td>';
                        } else {
                            html += '<td>处理成功</td>';
                        }

                        html += '</tr>';
                    }
                }
                cardInfoList.html(html);
                if (dataFirst == 'false') {
                    backCardList.pagination(data.count, 20, dataObj);
                    cardInfoList.attr('data-first', true);
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
            backCardList.request(dataObj);
        }
    }

}
//已生效退保扣佣金
var withdrawInfo = {
    init: function () {
    }, //查找保单
    findPolicy: function () {
        var policyno = $("#policyno").val();
        withdrawList.request(policyno);
    },//扣除
    deduction: function (policyno) {
        var res = confirm("是否确认?确认会扣除下线分红佣金以及代购/推广佣金");
        if (res == true) {
            $.get('/operate/Withdraw/Withdraw', {policyno: policyno}, function (data) {
                 var data = JSON.parse(data);
                 if(data.code == 0 ){
                     alert(data.message);
                     withdrawInfo.findPolicy(policyno);
                 }else{
                     alert(data.message);
                     withdrawInfo.findPolicy(policyno);
                 }
            });

        }
    }
}

var withdrawList = {
    request: function (policyno) {
        var withdrawlist = $("#withdrawList");
        var html = '';
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        withdrawlist.html(load);
        $.get('/finance/withdraw/Ajaxfindpolicy', {policyno: policyno}, function (data) {
            var data = JSON.parse(data);
            if (data.code == 0) {
                if (data.data == '') {
                    html = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                } else {
                    var list = data.data;
                    for (var i = 0; i < list.length; i++) {
                        listI = list[i];
                        html += '<tr>' +
                            '<td>' + listI.user_id + '</td>' +
                            '<td>' + listI.name + '</td>' +
                            '<td>' + listI.brokerage + '</td>' +
                            '<td>' + listI.premium + '</td>' +
                            '<td>' + listI.brokerage_time + '</td>' +
                            '<td>' + listI.policyno + '</td>' +
                            '<td>' + listI.withdraw_time + '</td>' +
                            '<td>' + listI.status + '</td>';
                            if(listI.status == "未处理") {
                                html +='<td>' + '<a type="button" class="btn btn-block btn-primary btn-xs" onclick="withdrawInfo.deduction(\'' + listI.policyno + '\')">退保扣除佣金</a>';
                            }else{
                                html += '<td>' +'' + '</td>';
                            }

                    }
                }
                withdrawlist.html(html);
            } else {
                alert(data.message);
            }

        });
    }
}

