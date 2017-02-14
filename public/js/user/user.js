/**
 * Created by gewenrui on 2017/2/14.
 */
var user = new Vue({
    el: "#app",
    data: {
        nickname: '',
        introduce: '',
    }, methods: {
        sub: function () {
            if (this.$data.nickname == '') {
                alert('nickname不能为空')
            } else if (this.$data.introduce == '') {
                alert('介绍信息为空');
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