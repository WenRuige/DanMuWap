var login = new Vue({
    el: "#app",
    data: {
        //初始化数据
        email: '',
        password: '',
    }, methods: {
        submit: function () {
            if (this.$data.email == '') {
                alert('邮箱不可为空');
                return false;
            }
            if (this.$data.password == '') {
                alert('密码不可为空');
                return false;
            }
            this.$http.get('/ajaxLogin', {
                    params: {
                        'email': this.$data.email,
                        'password': this.$data.password
                    }
                }
            ).then(response => {
                var res = response.body;
                if (res.code != 0) {
                    alert(res.message);
                } else {
                    //注册成功后跳转
                    window.location.href = '/index'
                }
            }, response => {
                console.log(response);
            });
        }
    }
})