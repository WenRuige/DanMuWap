<html>
<head>
    <title>girigiri弹幕网</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="gewenrui's">
    <meta name="author" content="gewenrui">
    <!-- Bootstrap 3.3.6 -->

    <link rel="stylesheet" href="{{url('/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('/dist/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{url('/dist/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('../dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="{{url('/dist/css/skins/_all-skins.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{url('/dist/js/html5shiv.min.js')}}"></script>
    <script src="{{url('/dist/js/respond.min.js')}}"></script>
    <![endif]-->
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="../../index2.html"><b>girigiri</b>弹幕网</a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">注册成为我们的伙伴吧!</p>

        <div id="app">
            {{--<div class="form-group has-feedback">--}}
            {{--<input type="text" class="form-control" placeholder="Full name">--}}
            {{--<span class="glyphicon glyphicon-user form-control-feedback"></span>--}}
            {{--</div>--}}
            <div class="form-group has-feedback">
                <input v-model="email" type="email" class="form-control" placeholder="电子邮箱">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input v-model="password" type="password" class="form-control" placeholder="密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input v-model="repassword" type="password" class="form-control" placeholder="密码确认">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                    <a v-on:click="submit" type="button" class="btn btn-primary btn-block btn-flat">注册</a>
                </div>
                <!-- /.col -->
            </div>
        </div>

        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up
                using
                Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up
                using
                Google+</a>
        </div>
        <a href="login.html" class="text-center">我已经成为会员了</a>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{url('/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- 引入vue.js -->
<script src="{{url('/vue/vue.js')}}"></script>
<script src="{{url('/vue/vue-resource.js')}}"></script>
<script src="{{url('js/register/register.js')}}"></script>

</body>
</html>