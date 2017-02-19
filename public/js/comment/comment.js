var comment = new Vue({
    el: "#app",
    data: {
        items: [],
        input:''
    },
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
                res.data.forEach(function (value, index, array) {
                    //后期图片Url处理
                    value.photo = '../picture/upload/' + value.photo;
                    comment.items.push(value);
                });
            }
        }, response => {
            console.log(response);
        });
    }, methods: {
        sub: function () {
            this.$http.get('/ajaxAddCommentList', {
                    params: {
                        'comment': this.$data.input,
                        'video_id':location.pathname.split('/')[2]
                    }
                }
            ).then(response => {
                var res = response.body;
                if (res.code != 0) {
                    alert(res.message);
                } else {
                    window.location.reload();
                }
            }, response => {
                console.log(response);
            });
        }
    }
})