@extends('layouts.index')
@section('title')
    选择您想说的话,动弹一下吧
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
            box-shadow: 0px 1px 3px rgba(34, 25, 25, 0.2);
        }

        .marquee {
            width: 100%; /* the plugin works for responsive layouts so width is not necessary */
            overflow: hidden;
            height: 25px;
            margin-top: 10px;
            background-color: #ffffff;
            box-shadow: 0px 1px 3px rgba(34, 25, 25, 0.2);
        }
        a:link{color:#000000}
    </style>
    <!--重写nav -->
    <div id="back">
        <span class="glyphicon glyphicon-chevron-left"></span><a href='javascript:history.go(-1)'>后退</a>
    </div>
    <code>看看大家都在说什么</code>
    <div class='marquee'>
        <code>xxx用户数</code> 太帅了
    </div>
    <div id="app">
        <code>动弹一下</code>
        <form action="/sendDynamic" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="您想说的话" class="col-sm-5 control-label">您想说的话*</label>
                <div class="col-sm-8">
                    <input name="info" type="text" class="form-control" placeholder="girigiri" required="required">
                </div>
            </div>

            {{--<div class="form-group">--}}
                {{--<label for="上传您的小图" class="col-sm-5 control-label">上传您的小图</label>--}}
                {{--<div class="col-sm-8">--}}
                    {{--<input type="file" name="file" id="filer_input" multiple="multiple">--}}
                {{--</div>--}}
            {{--</div>--}}
            <input type="submit" class="btn btn-block btn-info btn-sm" value="提交">
        </form>
    </div>

    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="{{url('plugins/marquee/marquee.js')}}" type="text/javascript"></script>

    <script>
        $('.marquee').marquee({
            duration: 3000,
            gap: 50,
            delayBeforeStart: 0,
            direction: 'up',
            duplicated: true
        });
    </script>
    <!-- 引入 css -->
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="{{url('plugins/filer/js/custom.js')}}"></script>
    <script src="{{url('plugins/filer/js/jquery.filer.min.js')}}"></script>

@endsection