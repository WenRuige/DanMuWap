@extends('layouts.index')

@section('title')
    首页展示
@endsection
@section('content')
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

    <div class="row" style=" background-color: #ffffff;">


    </div>

    <!-- 轮播图结束-->

@endsection