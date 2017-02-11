var policyInfo = {
    init: function () {
        this.clean();
        this.linkSelect();
        this.openResource();
    },
    begin: function () {

    },
    clean: function () {
        $("input").each(function () {
            $(this).val('');
        });
    },
    linkSelect: function () {
        var policyOrderStatusHTML = '',
            policyOrderStatus = $('#po_order_status');
        $.get('/policy/index/ajaxGetOrderStatus', function (data) {
            policyOrderStatusHTML = '<option value="">请选择</option>';
            for (var i = 0; i < data.length; i++) {
                if (data[i].id != '') {
                    policyOrderStatusHTML += '<option value="' + data[i].id + '">' + data[i].value + '</option>';
                    // console.log(data[i].id+data[i].value);
                }
            }
            policyOrderStatus.html(policyOrderStatusHTML);
        }, 'json');
        var insurancePolicyStatusHTML = '',
            insurancePolicyStatus = $('#po_insurance_policy_status');

        $.get('/policy/index/ajaxGetInsuranceStatus', function (data) {
            // console.log(data);
            insurancePolicyStatusHTML = '<option value="">请选择</option>';
            for (var i = 0; i < data.length; i++) {
                if (data[i].id != '') {
                    insurancePolicyStatusHTML += '<option value="' + data[i].id + '">' + data[i].value + '</option>';
                    //console.log(data[i].id+data[i].value);
                }
            }
            insurancePolicyStatus.html(insurancePolicyStatusHTML);
        }, 'json');

        var cooperativePartnerHTML = '',
            cooperativePartner = $('#cooperativePartner');
        $.get('/policy/index/ajaxGetCooperativePartner', function (data) {
            cooperativePartnerHTML = '<option value="">请选择</option>';
            for (var i = 0; i < data.length; i++) {
                if (data[i].id != '') {
                    cooperativePartnerHTML += '<option value="' + data[i].id + '">' + data[i].developer_name + '</option>';
                    // console.log(data[i].id+data[i].value);
                }
            }
            cooperativePartner.html(cooperativePartnerHTML);
        }, 'json');
    },
    findPolicy: function () {
        var dataObj = {};
        dataObj['po_insurance_policy_id'] = $("#po_insurance_policy_id").val().trim();
        dataObj['po_order_status'] = $("#po_order_status").val().trim();
        var booking_time = $("#booking_time").val().trim();
        if (booking_time.trim() != '') {
            var time = booking_time.split('至');
            dataObj['po_booking_time'] = "po.booking_time >=" + "'" + time[0] + " 00:00:00'" + " AND " + "po.booking_time <=" + "'" + time[1] + " 23:59:59'" + "";
        }
        dataObj['ph_name'] = $("#ph_name").val().trim();
        dataObj['pip_name'] = $("#pip_name").val().trim();
        dataObj['pm_local_product_name'] = $("#pm_local_product_name").val().trim();
        dataObj['po_insurance_policy_status'] = $("#po_insurance_policy_status").val().trim();
        var begin_date = $("#begin_date").val();
        if (begin_date.trim() != '') {
            var time = begin_date.split('至');
            dataObj['po_begin_date'] = "po.begin_date >=" + "'" + time[0] + " 00:00:00 '" + " AND " + "po.begin_date <=" + "'" + time[1] + " 23:59:59'" + "";
        }
        dataObj['ph_id_number'] = $("#ph_id_number").val().trim();
        dataObj['pip_id_number'] = $("#pip_id_number").val().trim();
        dataObj['ph_mobile_number'] = $("#ph_mobile_number").val().trim();
        dataObj['developer_id'] = $("#cooperativePartner").val().trim();
        //alert(dataObj['develop_id']);
        this.openResource(dataObj);
        dataObj['page'] = 1;
        $('#allowPolicy').html('');
        $('#policyList').attr('data-First', 'false');
        PolicyList.request(dataObj);
    },
    openResource: function (obj) {
        var download = $("#open_resource");
        var dataurl = '/policy/index/exportPolicyOrder?';
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
    },
    download: function (obj) {
        var dataObj = {};
        dataObj['id'] = obj;
        $.get("/policy/detail/download", dataObj, function (data) {
            //   alert(data);
        });
    },//退保使用接口
    cancelUseInterface: function (obj) {
        var error = $("#error");
        var dataObj = {};
        dataObj['insurance_policy_status'] = $("#insurance_policy_status").text();
        dataObj['developer_id'] = $("#developer_id").text();
        dataObj['policy_order_id'] = obj;
        $.get("/operate/policy/cancelInsuranceUseInterface", dataObj, function (data) {
            data = JSON.parse(data || "null");
            if (data['code'] == 1) {
                //如果没有权限则提示没有权限
                html = '<div class="pad margin no-print">' +
                    '<div class="callout callout-danger" style="margin-bottom: 0!important;">' + data['messages'] +
                    '</div>' +
                    '</div>';
                error.append(html);
            } else {
                //退保成功刷新当前页面
                window.location.reload();
            }
        });
        //退保不使用接口
    }, cancelUseNoInterface: function (obj) {
        var error = $("#error");
        var dataObj = {};
        dataObj['insurance_policy_status'] = $("#insurance_policy_status").text();
        dataObj['developer_id'] = $("#developer_id").text();
        dataObj['policy_order_id'] = obj;
        $.get("/operate/policy/cancelInsuranceUseNoInterface", dataObj, function (data) {
            data = JSON.parse(data || "null");
            if (data['code'] == 1) {
                //如果没有权限则提示没有权限
                html = '<div class="pad margin no-print">' +
                    '<div class="callout callout-danger" style="margin-bottom: 0!important;">' + data['messages'] +
                    '</div>' +
                    '</div>';
                error.append(html);
            } else {
                //退保成功刷新当前页面
                window.location.reload();
            }
        });
    },
    policyAgain: function (obj) {
        var error = $("#error");
        var dataObj = {};
        dataObj['id'] = obj;
        $.get("/operate/policy/policyAgain", dataObj, function (data) {
            data = JSON.parse(data || "null");
            if (data['code'] == 1) {
                //如果没有权限则提示没有权限
                html = '<div class="pad margin no-print">' +
                    '<div class="callout callout-danger" style="margin-bottom: 0!important;">' + data['messages'] +
                    '</div>' +
                    '</div>';
                error.append(html);
            } else {
                //出单成功刷新当前界面
                window.location.reload();
            }
        });
    },
    paymentDetails: function (obj) {
        //订单号
        var policyOrderId = obj;
        $.get("/policy/detail/paymentDetail", {"policy_order_id": policyOrderId}, function (data) {
            console.log(data);
            data = JSON.parse(data || "null");
            $("#full_price").html(data.full_price);
            $("#service_full_price").html(data.service_full_price);
            $("#total").html(data.total);
            $("#coupon_price").html(data.coupon_price);
            $("#integral").html(data.integral);
            $("#pindan_price").html(data.pindan_price);
            $("#use_balance").html(data.use_balance);
            $("#total_pay_price").html(data.total_pay_price);
        });

    }
}
var PolicyList = {
    request: function (dataObj) {
        var html = '';
        var download = $("#download");
        var downloadHTML = '';
        var policyList = $("#policyList");
        var dataFirst = policyList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        policyList.html(load);
        $.get("/policy/index/getPolicyList", dataObj, function (data) {
            data = JSON.parse(data || "null");
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
                    policyList.html(error);
                    return false;
                }
                for (var i = 0; i < list.length; i++) {
                    listI = list[i];
                    html += '<tr>' +
                        '<td>' + listI.mobile_number + '</td>' +
                        '<td>' + listI.insurance_policy_id + '</td>' +
                        '<td>' + listI.local_product_name + '</td>' +
                        '<td>' + listI.order_status + '</td>' +
                        '<td>' + listI.insurance_policy_status + '</td>' +
                        '<td>' + listI.ph_name + '</td>' +
                        '<td>' + listI.pip_name + '</td>' +
                        '<td>' + listI.begin_date + '至' + listI.end_date + '</td>' +
                        '<td>' + listI.booking_time + '</td>' +
                        '<td>' + listI.developer_id + '</td>' +
                        '<td>' +
                        '<a  href="/account/detail/index?id=' + listI.user_id + '" type="button" class="btn btn-block btn-primary btn-xs" target="_Blank">进入账号</a>' +
                        '<a  href="/policy/detail/index?id=' + listI.id + '" type="button" class="btn btn-block btn-info btn-xs" target="_Blank">保单详情</a>' +
                        '<a  href="/policy/detail/download?id=' + listI.id + '" type="button" class="btn btn-block btn-default btn-xs">下载</a>' +
                        '<td>' +
                        '</tr>';
                }
                policyList.html(html);
                //如果是第一次加载
                if (dataFirst == 'false') {
                    PolicyList.pagination(data.count, 20, dataObj);
                    policyList.attr('data-first', true);
                }
            }
        });

    }, pagination: function (count, pageSize, dataObj) {
        //调用分页插件
        $("#allowPolicy").pagination(count, {
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
var showProductDetail = {
    show: function (product_main_id) {
        var page = $("#productDetail")
        var product_main_id = product_main_id;
        $.post("/policy/detail/showProductDetail", {"product_main_id": product_main_id}, function (data) {
            data = JSON.parse(data || "null");
            console.log(data);
            var html = "";
            html += "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>所属保险公司:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [(data[0].insurance_company_id =='')?'空':data[0].insurance_company_id] + "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>本站产品代码:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [(data[0].local_product_id=='')?'空':data[0].local_product_id ] + "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>本站产品名称:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [(data[0].local_product_name=='')?'空':data[0].local_product_name] + "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>本站计划代码:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [(data[0].local_plan_id=='')?'空':data[0].local_plan_id]+ "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>本站计划名称:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].local_plan_name==''?'空':data[0].local_plan_name] + "  </p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>保险公司产品代码:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].company_product_id==''?'空':data[0].company_product_id] + "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>保险公司产品名称:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].company_product_name==''?'空':data[0].company_product_name]  + "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>保险公司计划代码:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].company_plan_id==''?'空':data[0].company_plan_id]  + "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>保险公司计划名称:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].company_plan_name==''?'空':data[0].company_plan_name] + "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>一句话卖点:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].selling_point==''?'空':data[0].selling_point]+ "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>列表图片标签:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].product_label==''?'空':data[0].product_label]+ "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>最小生效时间:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].min_effective_time==''?'空':data[0].min_effective_time] + "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>最小生效时间单位:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].min_effective_time_unit==''?'空':data[0].min_effective_time_unit] + "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>最大生效时间:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].max_effective_time==''?'空':data[0].max_effective_time]  + "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>最大时间生效单位:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].max_effective_time_unit==''?'空':data[0].max_effective_time_unit] + "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>最小投保人年龄:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].min_applicant_age==''?'空':data[0].min_applicant_age]+ "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>最大投保人年龄:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].max_applicant_age==''?'空':data[0].max_applicant_age]+ "</p>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>最小被保人年龄:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].min_insured_age==''?'空':data[0].min_insured_age]+ "</p>" +
                "</div>" +
                "</div>"+
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>最小被保人年龄单位:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].min_insured_age_unit==''?'空':data[0].min_insured_age_unit]+ "</p>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>最大被保人年龄:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +   [data[0].max_insured_age==''?'空':data[0].max_insured_age]+ "</p>" +
                "</div>" +
                "</div>"
                +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>最大被保人年龄单位:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +[data[0].max_insured_age_unit==''?'空':data[0].max_insured_age_unit]+ "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>是否可延迟生效:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].is_delay_begin_date==''?'空':data[0].is_delay_begin_date]+ "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>观察期:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].observation_period==''?'空':data[0].observation_period]+ "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>观察期单位:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +   [data[0].observation_period_unit==''?'空':data[0].observation_period_unit]+ "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>保费计算类型:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].premium_calculate_type==''?'空':data[0].premium_calculate_type]+ "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>保费计算单位:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].premium_calculate_unit==''?'空':data[0].premium_calculate_unit] + "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>是否限定可选保额:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].is_amount_limit==''?'空':data[0].is_amount_limit] + "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>购买基数:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +   [data[0].base_buy_amount==''?'空':data[0].base_buy_amount] + "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>最大可购买量:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].max_buy_amount==''?'空':data[0].max_buy_amount] + "</p>" +
                "</div>" +
                "</div>"
                +
                // "</div>" +
                // "<div class='form-group'>" +
                // "<label for='inputEmail3' class='col-sm-4 control-label'>佣金率:</label>" +
                // " <div class='col-xs-8'>" +
                // "<p>" +  [data[0].rate==''?'空':data[0].rate] + "%</p>" +
                // "</div>" +
                // "</div>"+
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>是否启用:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].is_active==''?'空':data[0].is_active] + "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>是否促销:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].is_low_price==''?'空':data[0].is_low_price] + "</p>" +
                "</div>" +
                "</div>"+
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>促销价格:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].low_price==''?'空':data[0].low_price]+ "</p>" +
                "</div>" +
                "</div>"+
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>销售量:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].product_sales_volume==''?'空':data[0].product_sales_volume]+ "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>序号:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].sequence_number==''?'空':data[0].sequence_number]+ "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>投保页面类型:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].fill_type==''?'空':data[0].fill_type]+ "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>投保人是否同被保人:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" + [data[0].is_copy_insured==''?'空':data[0].is_copy_insured]+ "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>是否主推:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].is_recommend==''?'空':data[0].is_recommend]+ "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>是否可售:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +   [data[0].is_sales==''?'空':data[0].is_sales]+ "</p>" +
                "</div>" +
                "</div>"
                +
                "</div>" +
                "<div class='form-group'>" +
                "<label for='inputEmail3' class='col-sm-4 control-label'>销售量:</label>" +
                " <div class='col-xs-8'>" +
                "<p>" +  [data[0].product_sales_volume==''?'空':data[0].product_sales_volume]+ "</p>" +
                "</div>" +
                "</div>";

            page.html(html);
        });
    }

};
