@extends('layouts.index')
@section('title')
    选择您想说的话,动弹一下吧
@endsection
@section('content')
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
            height: 300px;
            margin-top: 10px;
            background-color: #ffffff;
            box-shadow: 0px 1px 3px rgba(34, 25, 25, 0.2);
        }

        #inside {
            margin: 10px;
        }

        a:link {
            color: #000000
        }
    </style>
    <!--重写nav -->
    <div id="back">
        <span class="glyphicon glyphicon-chevron-left"></span><a href='javascript:history.go(-1)'>后退</a>
    </div>

    <code>看看大家都在说什么</code>
    <div class='marquee'>

        <div id="inside">
            @foreach($dynamic as $value)
                <div class="direct-chat-msg">
                    <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">{{$value['nickname']}}</span>
                        <span class="direct-chat-timestamp pull-right">{{$value['create_time']}}</span>
                    </div>
                    <!-- /.direct-chat-info -->

                    <img class="direct-chat-img" src="{{$value['img']}}" alt="message user image">

                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        {{$value['info']}}
                    </div>
                    <!-- /.direct-chat-text -->
                </div>
            @endforeach

        </div>

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
@endsection