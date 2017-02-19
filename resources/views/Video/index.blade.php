@extends('layouts.index')
@section('title')
    视频页面
@endsection
@section('content')
    <!-- 引入 css -->
    <link rel="stylesheet" href="../plugins/danmu/css/main.css">
    <style>
        .owner {
            margin-top: 2px;
        }

        .inform ul li {
            border-right: 1px solid #f4f4f4;
            float: left;
        }
    </style>
    <div id="danmup"></div>
    <div class="owner">
        <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
                <div class="widget-user-image">
                    <img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">作者Nadia Carmichael</h3>
                <h5 class="widget-user-desc">Lead Developer <button  style="float: right" type="button" class="btn btn-default btn-xs">关注我</button></h5>


            </div>
            <div class="inform">
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li><a href="#">&nbsp;<span class="pull-right"><i class="fa fa-download"></i></span>&nbsp;</a></li>
                        <li><a href="#">视频播放量:<b>7.3w&nbsp;&nbsp;&nbsp;</b> 弹幕:<b>1w</b></a></li>
                        <li><a href="#">待更新</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="box-footer box-comments">
        <div class="box-comment">
            <!-- User image -->
            <img class="img-circle img-sm" src="../dist/img/user3-128x128.jpg" alt="User Image">

            <div class="comment-text">
                      <span class="username">
                        Maria Gonzales
                        <span class="text-muted pull-right">8:03 PM Today</span>
                      </span><!-- /.username -->
                It is a long established fact that a reader will be distracted
                by the readable content of a page when looking at its layout.
            </div>
            <!-- /.comment-text -->
        </div>
        <!-- /.box-comment -->
        <div class="box-comment">
            <!-- User image -->
            <img class="img-circle img-sm" src="../dist/img/user4-128x128.jpg" alt="User Image">

            <div class="comment-text">
                      <span class="username">
                        Luna Stark
                        <span class="text-muted pull-right">8:03 PM Today</span>
                      </span><!-- /.username -->
                It is a long established fact that a reader will be distracted
                by the readable content of a page when looking at its layout.
            </div>
            <!-- /.comment-text -->
        </div>
        <!-- /.box-comment -->
    </div>
    <div class="box-footer">
        <form action="#" method="post">
            <img class="img-responsive img-circle img-sm" src="../dist/img/user4-128x128.jpg" alt="Alt Text">
            <!-- .img-push is used to add margin to elements next to floating images -->
            <div class="img-push">
                <input type="text" class="form-control input-sm" placeholder="Press enter to post comment">
            </div>
        </form>
    </div>
    <br>
    <br>
    <br>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="../plugins/danmu/js/jquery.danmu.js"></script>
    <script src="../plugins/danmu/js/main.js"></script>
    <script src="../plugins/danmu/js/jquery.shCircleLoader.js"></script>
    <script>
        $("#danmup").DanmuPlayer({
            src: "{{url('video/upload/'.$data->video)}}",
            height: "30%", //区域的高度
            width: "100%", //区域的宽度
            urlToGetDanmu: "/getDanMu?id={{$data->id}}",
            urlToPostDanmu: "/video/index/saveDanmu?id=" + $("#video_id").val()
        });
    </script>
@endsection