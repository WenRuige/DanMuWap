@extends('layouts.index')
@section('title')
    视频页面
@endsection
@section('content')
    <style>
        #personal {
            margin-top: 1px;
        }

        #nav {
            display: none;
        }
    </style>

    <!-- 引入 css -->
    <div class="personal">
        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-black" style="background: url('../dist/img/photo1.png') center center;">
                <h3 class="widget-user-username">{{isset($data['nickname'])?$data['nickname']:'无名氏'}}</h3>
                <h5 class="widget-user-desc">{{isset($data['introduce'])?$data['introduce']:'这个人很懒什么也没有写'}}</h5>
            </div>
            <div class="widget-user-image">
                @if(!empty($data['photo']))
                    <img class="img-circle" style="height: 85px" src="{{url('picture/upload/'.$data['photo'])}}"
                         alt="User Avatar">
                @endif
            </div>
            <div class="box-footer">
                <div class="col-xs-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header">{{$video}}</h5>
                        <span class="description-text">发布的视频</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-xs-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header">{{$follow}}</h5>
                        <span class="description-text">粉丝数</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <div class="description-block">
                        <h5 class="description-header">35</h5>
                        <span class="description-text">收集的赞</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </div>
    <div class="box-footer no-padding">
        <ul class="nav nav-stacked">
            <li><a href="/showAlterUserPhotoBlade">修改头像 <span class="pull-right"><i
                                class="fa fa-fw fa-file-photo-o"></i></span></a></li>
            <li><a href="/showUploadVideo">上传视频 <span class="pull-right"><i class="fa fa-fw fa-file-video-o"></i></span></a>
            </li>
            <li><a href="/showAlterUserBlade">编辑个人信息 <span class="pull-right"><i
                                class="fa fa-fw fa-male"></i></span></a></li>
            <li><a href="/logout">退出登录<span class="pull-right"><i class="fa fa-fw fa-power-off"></i></span></a></li>
        </ul>
    </div>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
@endsection