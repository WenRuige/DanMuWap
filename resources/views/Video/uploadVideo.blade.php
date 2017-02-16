@extends('layouts.index')
@section('title')
    增加/修改个人信息
@endsection
@section('content')
    <link rel="stylesheet" href="{{url('plugins/filer/css/jquery.filer.css')}}">
    <style>
        #back {
            /*position:fixed;*/
            height: 50px;
            background-color: #ffffff;
            box-shadow: 0px 1px 3px rgba(34, 25, 25, 0.2);
        }

        #back span {
            margin-top: 15px;
            margin-left: 14px;
        }

        #nav {
            display: none;
        }

        #app {
            margin-top: 10px;
            background-color: #ffffff;
        }
    </style>
    <!--重写nav -->
    <div id="back">
        <span class="glyphicon glyphicon-chevron-left"></span>后退
    </div>

    <div id="app">
        <code>上传视频</code>
        <form action="/uploadVideo" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="视频名称" class="col-sm-5 control-label">视频名称</label>
                <div class="col-sm-8">
                    <input name="name" type="text" class="form-control" placeholder="昵称" required="required">
                </div>
            </div>
            <div class="form-group">
                <label for="视频名称" class="col-sm-5 control-label">填写您的视频简介</label>
                <div class="col-sm-8">
                    <textarea type="text" name="content" class="form-control" placeholder="昵称"
                              required="required"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="上传您的视频封面" class="col-sm-5 control-label">上传您的视频封面</label>
                <div class="col-sm-8">
                    <input type="file" name="picture">
                </div>
            </div>
            <div class="form-group">
                <label for="上传您的视频封面" class="col-sm-5 control-label">SystemHelp</label>
                <div class="col-sm-8">
                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">系统生成gif
                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">系统生成jpg

                </div>
            </div>
            <div class="form-group">
                <label for="上传您的视频" class="col-sm-5 control-label">上传您的视频</label>
                <div class="col-sm-8">
                    <input type="file" name="file" id="filer_input" multiple="multiple">
                </div>
            </div>
            <input type="submit" class="btn btn-block btn-info btn-sm" value="提交">
        </form>
    </div>

    <!-- 引入 css -->
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="{{url('plugins/filer/js/custom.js')}}"></script>
    <script src="{{url('plugins/filer/js/jquery.filer.min.js')}}"></script>

@endsection