@extends('layouts.index')
@section('title')
    增加/修改个人信息
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
        }
    </style>

    <!-- test area -->

    <!-- test area -->

    <!--重写nav -->
    <div id="back">
        <span class="glyphicon glyphicon-chevron-left"></span><a href='javascript:history.go(-1)'>后退</a>
    </div>
    <div id="app">
        <code>完善您的个人信息</code>
        <div class="box-body">
            <div class="form-group">
                <label for="昵称" class="col-sm-5 control-label">昵称</label>
                <div class="col-sm-8">
                    <input v-model="nickname" type="text" class="form-control" placeholder="昵称">
                </div>
            </div>
            <div class="form-group">
                <label for="一句话介绍自己" class="col-sm-2 control-label">一句话介绍自己</label>

                <div class="col-sm-10">
                    <input v-model="introduce" type="text" class="form-control" placeholder="一句话">
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-sm-10">
                <a v-on:click="sub" type="button" class="btn btn-block btn-info btn-sm">提交</a>
            </div>
        </div>
        <!-- /.box-footer -->

    </div>
    <!-- 引入 css -->
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="{{url('js/user/user.js')}}"></script>
    <script>


    </script>
@endsection