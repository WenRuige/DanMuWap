/**
 * Created by gewenrui on 2017/2/14.
 */
var user = new Vue({
    el: "#app",
    data: {
        nickname: '',
        introduce: '',
    },
    created: function () {
        //创建的时候首先跑一遍接口
        this.$http.get('/ajaxGetUserInformation').then(response => {
            var res = response.body;
            console.log(res);
            if (res.code != 0) {
                alert(res.message);

            } else {
                //注册成功后跳转
                this.$data.nickname = res.data.nickname;
                this.$data.introduce = res.data.introduce;
            }
        }, response => {
            console.log(response);
        });
        this.$data.nickname = '123'
    }, methods: {
        sub: function () {
            if (this.$data.nickname == '') {
                alert('nickname不能为空');
                return false;
            } else if (this.$data.introduce == '') {
                alert('介绍信息为空');
                return false;
            }
            this.$http.get('/ajaxAlterUserInformation', {
                    params: {
                        'nickname': this.$data.nickname,
                        'introduce': this.$data.introduce
                    }
                }
            ).then(response => {
                var res = response.body;
                if (res.code != 0) {
                    alert(res.message);
                } else {
                    //注册成功后跳转
                }
            }, response => {
                console.log(response);
            });


        }
    }
})