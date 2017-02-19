var comment = new Vue({
    el: "#app",
    created: function () {
        //拉取模板列表
        //获取url的pathname
        var url = location.pathname;
        //按照/分割
        var param = url.split('/')[2];

        this.$http.get('/ajaxGetCommentList', {
                params: {
                    'param': param,
                }
            }
        ).then(response => {
            var res = response.body;
            if (res.code != 0) {
                alert(res.message);
            } else {
                //注册成功后跳转
                window.location.href = "/home";
            }
        }, response => {
            console.log(response);
        });
    }
})