var register = new Vue({
    el: "#app",
    data: {
        //初始化数据
        email: '',
        password: '',
        repassword: ''
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
            if (this.$data.repassword == '') {
                alert('确认密码不可为空');
                return false;
            }
            if (this.$data.password != this.$data.repassword) {
                alert('两次输入的密码不一致');
                return false;
            }
            this.$http.get('/ajaxRegisterAccount', {
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
                    window.location.href = "/home";
                }
            }, response => {
                console.log(response);
            });
        }
    }
})