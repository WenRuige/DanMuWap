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
        <span class="glyphicon glyphicon-chevron-left"></span><a href='javascript:history.go(-1)'>后退</a>
    </div>

    <div id="app">
        <code>选一张喜欢的图片作为头像吧</code>
        <form action="/uploadPhoto" method="post" enctype="multipart/form-data">
            <input type="file" name="file" id="filer_input" multiple="multiple">
            <input type="submit" class="btn btn-block btn-info btn-sm" value="提交">
        </form>
    </div>

    <!-- 引入 css -->
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="{{url('plugins/filer/js/custom.js')}}"></script>
    <script src="{{url('plugins/filer/js/jquery.filer.min.js')}}"></script>

@endsection