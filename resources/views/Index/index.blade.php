@extends('layouts.index')

@section('title')
    首页展示
@endsection
@section('content')
    <link rel="stylesheet" href="../plugins/barrager/css/barrager.css">
    <!-- 轮播图开始-->
    <div class="row" style="height: 240px;margin-top: 1px;">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img class="d-block img-fluid" src="../123.jpg" style="width: 100%;height:100%;" alt="第一张图">
                </div>
                <div class="carousel-item">
                    <img class="d-block img-fluid" src="../123.jpg" style="width: 100%;height: 100%;" alt="第二张图">
                </div>
                <div class="carousel-item">
                    <img class="d-block img-fluid" src="../123.jpg" style="width: 100%;height: 100%;" alt="第三张图">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    {{--<div class="row" style=" background-color: #ffffff;">--}}
    {{--<div class="card card-inverse">--}}
    {{--<img class="card-img" src="../123.jpg" alt="Card image">--}}
    {{--<div class="card-img-overlay">--}}
    {{--<h4 class="card-title">Card title</h4>--}}
    {{--<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>--}}
    {{--<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--</div>--}}
    <div class="row">
        <div class="card">
            <img class="card-img-top" src="../123.jpg" alt="Card image cap" style="width: 100%;height: 30%;">
            <div class="card-block">
                <h4 class="card-title">故事汇</h4>
                <p class="card-text">讲述了一个故事</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <img class="card-img-top" src="../123.jpg" alt="Card image cap" style="width: 100%;height: 30%;">
            <div class="card-block">
                <h4 class="card-title">故事汇</h4>
                <p class="card-text">讲述了一个故事</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <img class="card-img-top" src="../123.jpg" alt="Card image cap" style="width: 100%;height: 30%;">
            <div class="card-block">
                <h4 class="card-title">故事汇</h4>
                <p class="card-text">讲述了一个故事</p>
            </div>
        </div>
    </div>

    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="../plugins/barrager/js/jquery.barrager.min.js"></script>
    <script>
        var item = {
            img: '../123.jpg', //图片
            info: '弹幕文字信息', //文字
            href: 'http://www.baidu.com', //链接
            close: false, //显示关闭按钮
            speed: 10, //延迟,单位秒,默认6
            bottom: 70, //距离底部高度,单位px,默认随机
            color: 'gray', //颜色,默认白色
            old_ie_color: '#000000', //ie低版兼容色,不能与网页背景相同,默认黑色
        }
        $('body').barrager(item);
    </script>


    <!-- 轮播图结束-->

@endsection