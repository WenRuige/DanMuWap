<html>
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="gewenrui's">
    <meta name="author" content="gewenrui">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
</head>
<style>
    body {
        background-color: #e6ebee;
    }

    #nav {
        height: 50px;
        background-color: #ffffff;
        box-shadow: 0px 1px 3px rgba(34, 25, 25, 0.2);
    }

    #danmu {
        float: right;
        margin-top: 10px;
        margin-right: 4px;
    }

    #bottom {
        background-color: #ffffff;
    }
</style>
<body>
<!-- 导航栏 -->
<div class="row" id="nav">
    <a id="danmu" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
       aria-controls="collapseExample">
        弹幕
    </a>
</div>
<!--导航栏结束-->
<div class="row">
    <div class="collapse" id="collapseExample">
        <div class="card card-block">
            弹幕层, 弹幕层, 弹幕层, 弹幕层, 弹幕层, 弹幕层, 弹幕层, 弹幕层, 弹幕层, 弹幕层
        </div>
    </div>
</div>
@yield('content')
<!-- 底部导航栏目 -->
<div class="row">
    <nav id="bottom" class="navbar fixed-bottom navbar-light bg-faded">
        <a id="bottom">底部</a>
    </nav>
</div>
<!-- 底部导航栏目结束 -->

<!-- 引入javascript 文件-->
<script src="https://cdn.bootcss.com/jquery/3.1.1/jquery.slim.min.js"
        integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n"
        crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
        crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
        integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
        crossorigin="anonymous"></script>
<!-- 引入javascript 文件结束-->
</body>
</html>