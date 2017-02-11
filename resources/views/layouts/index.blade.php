<html>
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="gewenrui's">
    <meta name="author" content="gewenrui">
{{--<link rel="icon" href="{$stroot}/dist/img/favicon.ico" type="image/x-icon"/>--}}
<!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <!--<link rel="stylesheet" href="../../dist/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="../dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">
    <link rel="stylesheet" href="../dist/css/styleSelf.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="../dist/js/html5shiv.min.js"></script>
    <script src="../dist/js/respond.min.js"></script>
    <![endif]-->
</head>
<style>
    body {
        /*margin: 0;*/
        background-color: #e6ebee;
    }

    #nav {
        /*position:fixed;*/
        height: 50px;
        background-color: #ffffff;
        box-shadow: 0px 1px 3px rgba(34, 25, 25, 0.2);
    }

    #logo {
        margin-left: 20px;
        margin-top: 5px;
    }
    #bottom{
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        box-shadow: 0px 1px 3px rgba(34, 25, 25, 0.2);
        broder-top: solid .01rem #ccc;
        background-color: #ffffff;
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    #bottom li {
        float: left;
        text-align:center;
        width: 33.33%;
    }

    #bottom li a {
        display: block;
        text-align:center;
    }
    #bottom li a i{
        margin-top: 2px;
        margin-right: 40px;
        /*text-align:center*/
    }

</style>
<body>

<!-- 导航栏 -->
<div class="" id="nav">
    <img src="../picture/logo.png" id="logo" style=" width:100px;height: 40px">
</div>
{{--<!--导航栏结束-->--}}


<div class="main">
    @yield('content')
</div>
<!-- 底部导航栏目 -->
{{--<ul>--}}
    {{--<li><a href="#home">Home</a></li>--}}
    {{--<li><a href="#news">News</a></li>--}}
    {{--<li><a href="#contact">Contact</a></li>--}}
{{--</ul>--}}
<div id="bottom" class="box-footer no-padding">
    <ul class="nav nav-stacked">
        <li><a href="#">   &nbsp; <span class="pull-right"><i class="fa fa-fw fa-user"></i></span> &nbsp;</a></li>
        <li><a href="#">  &nbsp;<span class="pull-right"><i class="fa fa-fw fa-user"></i></span> &nbsp;</a></li>
        <li><a href="#">  &nbsp;<span class="pull-right"><i class="fa fa-fw fa-user"></i></span> &nbsp;</a></li>
    </ul>
</div>
<!-- 底部导航栏目结束 -->

<!-- 引入javascript 文件-->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>
<!-- 引入javascript 文件结束-->
</body>
</html>