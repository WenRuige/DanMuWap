@extends('layouts.index')

@section('title')
    首页展示
@endsection
@section('content')
    <link rel="stylesheet" href="../plugins/barrager/css/barrager.css">
    <link rel="stylesheet" href="../plugins/sHover/css/example.css">
    <!-- 轮播图开始-->
    <div class="Carousel" style="margin-top: 1px;">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            {{--<ol class="carousel-indicators">--}}
            {{--<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>--}}
            {{--<li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>--}}
            {{--<li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>--}}
            {{--</ol>--}}
            <div class="carousel-inner">
                <div class="item active">
                    <img src="../123.jpg" style="width: 100%;height: 30%" alt="First slide">

                    <div class="carousel-caption">
                        First Slide
                    </div>
                </div>
                <div class="item">
                    <img src="../123.jpg" style="width: 100%;height: 30%" alt="Second slide">

                    <div class="carousel-caption">
                        Second Slide
                    </div>
                </div>
                <div class="item">
                    <img src="../123.jpg" style="width: 100%;height: 30%" alt="Third slide">

                    <div class="carousel-caption">
                        Third Slide
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                <span class="fa fa-angle-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                <span class="fa fa-angle-right"></span>
            </a>
        </div>
    </div>
    <!-- 轮播图结束--->
    <style>
        #video {
            background-color: #ffffff;
            margin-top: 3px;

        }

        .user-block {
            padding: 10px;
        }

        .commet {
            margin-top: 10px;
            padding-bottom: 5px;

        }

        .commet a {
            margin-left: 10px;
        }
    </style>


    <div id="video">

        <div class="user-block">
            <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
            <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
            <span class="description">Posted 5 photos - 5 days ago</span>


        </div>
        <div class="sHoverItem" style="margin-bottom:5px;border-bottom: 1px black solid">
            <img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">
            <span id="intro1" class="sIntro">
					<h2>Movie</h2>
					<p>Flowers are so inconsistent! But I was too young to know how to love her</p>
					<button>点击查看视频</button>
				</span>

        </div>
        <div class="commet">
            <a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a>
            <a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
            <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments(5)</a>
        </div>

    </div>

    <div id="video">

        <div class="user-block">
            <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
            <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
            <span class="description">Posted 5 photos - 5 days ago</span>


        </div>
        <div class="sHoverItem" style="margin-bottom:5px;border-bottom: 1px black solid">
            <img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">
            <span id="intro1" class="sIntro">
					<h2>Movie</h2>
					<p>Flowers are so inconsistent! But I was too young to know how to love her</p>
					<button>点击查看视频</button>
				</span>

        </div>
        <div class="commet">
            <a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a>
            <a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
            <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments(5)</a>
        </div>

    </div>
    <div id="video">

        <div class="user-block">
            <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
            <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
            <span class="description">Posted 5 photos - 5 days ago</span>


        </div>
        <div class="sHoverItem" style="margin-bottom:5px;border-bottom: 1px black solid">
            <img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">
            <span id="intro1" class="sIntro">
					<h2>Movie</h2>
					<p>Flowers are so inconsistent! But I was too young to know how to love her</p>
					<button>点击查看视频</button>
				</span>

        </div>
        <div class="commet">
            <a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a>
            <a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
            <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments(5)</a>
        </div>

    </div>
    <div id="video">

        <div class="user-block">
            <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
            <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
            <span class="description">Posted 5 photos - 5 days ago</span>


        </div>
        <div class="sHoverItem" style="margin-bottom:5px;border-bottom: 1px black solid">
            <img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">
            <span id="intro1" class="sIntro">
					<h2>Movie</h2>
					<p>Flowers are so inconsistent! But I was too young to know how to love her</p>
					<button>点击查看视频</button>
				</span>

        </div>
        <div class="commet">
            <a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a>
            <a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
            <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments(5)</a>
        </div>

    </div>
    <div id="video">

        <div class="user-block">
            <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
            <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
            <span class="description">Posted 5 photos - 5 days ago</span>


        </div>
        <div class="sHoverItem" style="margin-bottom:5px;border-bottom: 1px black solid">
            <img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">
            <span id="intro1" class="sIntro">
					<h2>Movie</h2>
					<p>Flowers are so inconsistent! But I was too young to know how to love her</p>
					<button>点击查看视频</button>
				</span>

        </div>
        <div class="commet">
            <a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a>
            <a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
            <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments(5)</a>
        </div>

    </div>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="../plugins/barrager/js/jquery.barrager.min.js"></script>
    <script src="../plugins/sHover/js/sHover.min.js"></script>
    <script>
        var a = new sHover("sHoverItem", "sIntro");
        a.set({
            slideSpeed: 5,
            opacityChange: true,
            opacity: 80
        });
    </script>
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