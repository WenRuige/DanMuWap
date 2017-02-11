//产品详情信息
var ProductInfo = {
    init: function () {
        this.begin();
    },
    begin: function () {
        var dataObj = {};
        dataObj['page'] = 1;
        ProductList.request(dataObj);
    },
    delete: function (id) {
        if (window.confirm('确定要删除该产品吗？')) {
            $.get("/operate/product/deleteProduct", {id: id}, function (data) {
                console.log(data);
                data = JSON.parse(data);

                if (data.code == '0') {
                    alert('删除成功!');
                    window.location.reload()
                }
            });
        } else {
            return false;
        }
    },
    //更新排序功能
    updateSort: function (elm) {
        var dataObj = {};

        var sort = $(elm).val();
        var elm = $(elm);
        dataObj['product_id'] = elm.data("id");
        dataObj['sortby']     = sort;
        console.log(dataObj);
        if (isNaN(dataObj['sortby'])) {
            alert('请输入数字');
            return false;
        }
        $.get("/operate/product/editProductSort", dataObj, function (data) {
            data = JSON.parse(data);
            if (data.code == "0") {
                alert(data.message);
                window.location = '/product/index/index';
            } else {
                alert(data.message);
            }
        });


    },
    showProductId: function () {
        var value = $('#productTitle option:selected').val();
        $("#productId").text(value);
        $.get("/product/index/ajaxCheckIsExits", {id: $("#productId").text()}, function (data) {
            data = JSON.parse(data);
            if (data.code != '00006') {
                flag = true;
            } else {
                $("#productId").html("<font color='red'>该商品已经存在</font>");
                //alert(data.message);
            }
        });
    },
    addProduct: function () {
        //设置同步
        $.ajaxSetup({
            async: false //取消异步
        });
        var dataObj = {};
        //将string 转化为 int
        dataObj['product_id'] = parseInt($("#productId").text().trim());
        console.log(dataObj);
        //product_list 表中的表单号
        dataObj['id'] = $("#product_list_id").val();
        dataObj['remark'] = $("#remark").val();
        dataObj['show_rate'] = $("#show_rate").val();
        if (dataObj['product_id'] == "" || isNaN(dataObj['product_id'])) {
            alert('必填项为填写或商品重复');
            return false;
        }
        $.get("/operate/product/editProduct", dataObj, function (data) {
            data = JSON.parse(data);
            if (data.code == "0") {
                alert(data.message);
                window.location = '/product/index/index';
            } else {
                alert(data.message);
            }
        });

    }
}


//产品列表页面
var ProductList = {
    request: function (dataObj) {
        var html = '';
        var productList = $("#productList");
        var dataFirst = productList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        productList.html(load);
        $.get("/product/index/getProductList", dataObj, function (data) {
            data = JSON.parse(data || "null");
            console.log(data);
            if (data.code == 0) {
                list = data.data;
                if (list.length == 0) {
                    var error = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                    productList.html(error);
                    return false;
                }
                for (var i = 0; i < list.length; i++) {
                    listI = list[i];
                    html += '<tr>' +
                        '<td>' + listI.product_name + '</td>' +
                        '<td>' + listI.product_id + '</td>' +
                        '<td>' + listI.update_time + '</td>' +
                        '<td>' + '<input type="text"  value="' + listI.sortby + '"  data-id="' + listI.product_id + '"onchange="ProductInfo.updateSort(this)">' + '</td>' +
                        // '<td>' + '<input type="text"  value="'+listI.sortby+'" onchange="ProductInfo.updateSort(\'' + listI.product_id + '\',\'' + this + '\')">' + '</td>' +
                        '<td>' +
                        '<div class="form-group">' +
                        '<div class="col-xs-6">' +
                        '<a  href="/product/index/alter?id=' + listI.id + '&product_id=' + listI.product_id + '"  type="button"  class="btn  btn-primary btn-xs" target="_Blank">编辑</a>' +
                        '</div>' +
                        '<div class="col-xs-6">' +
                        '<a  href="#" type="button" onclick="ProductInfo.delete(\'' + listI.id + '\')" class="btn btn-danger btn-xs" target="_Blank">删除</a>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '</tr>';
                }
                productList.html(html);
                //如果是第一次加载
                if (dataFirst == 'false') {
                    ProductList.pagination(data.count, 15, dataObj);
                    productList.attr('data-first', true);
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
            ProductList.request(dataObj);
        }
    },
    showAllProduct: function () {
        var productHTML = '',
            productList = $('#productTitle');
        $.get('/product/index/showAllProduct', function (data) {
            productHTML = '<option value="">请选择</option>';
            for (var i = 0; i < data.length; i++) {
                if (data[i].id != '') {
                    productHTML += '<option value="' + data[i].product_id + '">' + data[i].product_id + '.' + data[i].product_name + '_' + data[i].inner_name + '</option>';
                }
            }
            productList.html(productHTML);
        }, 'json');

    }
}
//产品信息修改
var ProductEditInfo = {
    init: function () {
        this.beign();
    }, beign: function () {
        var dataObj = {};
        dataObj['page'] = 1;
        ProductEditList.request(dataObj);
    }, clear: function () {

    }, editProduct: function () {
        var dataObj = {};
        dataObj['product_id'] = $("#productId").text();
        dataObj['product_name'] = $("#product_name").val();
        dataObj['inner_name'] = $("#inner_name").val();
        console.log(dataObj);
        if (dataObj['product_id'] == "" || dataObj['product_name'] == "" || dataObj['inner_name'] == "") {
            alert('不能为空');
        }
        $.get("/operate/product/editProductByProductId", dataObj, function (data) {
            data = JSON.parse(data);
            if (data.code == "0") {
                alert(data.message);
                window.location = '/product/edit/index';
            } else {
                alert(data.message);
            }
        });
    }
}
//产品详情列表页面
var ProductEditList = {
    request: function (dataObj) {
        var html = '';
        var productList = $("#productList");
        var dataFirst = productList.attr('data-First');
        var tdLen = $("#table>thead>tr").find("th").length;
        var load = '<tr class="box-body">' +
            '<td colspan="' + tdLen + '">' +
            '<div class="cover">' +
            '<div class="searLoading">' +
            '<p>结果正在查询中,请等待!</p>' +
            '</div></div></td></tr>';
        productList.html(load);
        $.get("/product/edit/getAllProduct", dataObj, function (data) {
            data = JSON.parse(data || "null");
            console.log(data);
            if (data.code == 0) {
                list = data.data;
                if (list.length == 0) {
                    var error = '<tr><td style="text-align: center" colspan="' + tdLen + '">查询暂无数据。</td></tr>';
                    productList.html(error);
                    return false;
                }
                for (var i = 0; i < list.length; i++) {
                    listI = list[i];
                    html += '<tr>' +
                        '<td>' + listI.product_id + '</td>' +
                        '<td>' + listI.product_name + '</td>' +
                        '<td>' + listI.inner_name + '</td>' +
                        '<td>' + listI.create_time + '</td>' +
                        '<td>' + listI.update_time + '</td>' +
                        '<td>' +
                        '<a  href="/product/edit/edit?product_id=' + listI.product_id + '"  type="button"  class="btn btn-block btn-primary btn-xs" target="_Blank">编辑</a>' +
                        '</td>' +
                        '</tr>';
                }
                productList.html(html);
                //如果是第一次加载
                if (dataFirst == 'false') {
                    ProductEditList.pagination(data.count, 15, dataObj);
                    productList.attr('data-first', true);
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
            ProductEditList.request(dataObj);
        }
    }

}