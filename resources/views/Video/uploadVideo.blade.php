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
        <code>上传视频</code>
        <div class="form-group">
            <label for="视频名称" class="col-sm-5 control-label">视频名称</label>
            <div class="col-sm-8">
                <input name="name" id="name" type="text" class="form-control" placeholder="视频名称" required="required">
            </div>
        </div>
        <div class="form-group">
            <label for="视频名称" class="col-sm-5 control-label">填写您的视频简介</label>
            <div class="col-sm-8">
                    <textarea type="text" id="content" class="form-control" placeholder="填写您的视频简介"
                              required="required"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="上传您的视频封面" class="col-sm-5 control-label">上传您的视频封面</label>
            <div class="col-sm-8">
                <input type="file" name="picture" id="picture" onchange="video.uploadPicture()">
            </div>
        </div>
        {{--<div class="form-group">--}}
        {{--<label for="上传您的视频封面" class="col-sm-5 control-label">SystemHelp</label>--}}
        {{--<div class="col-sm-8">--}}
        {{--<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">系统生成gif--}}
        {{--<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">系统生成jpg--}}
        <input type="hidden" id="hash">
        <input type="hidden" id="img">
        {{--</div>--}}
        {{--</div>--}}
        <div class="form-group">
            <label for="上传您的视频" class="col-sm-5 control-label">上传您的视频</label>
            <div class="col-sm-8">
                <input type="file" name="file" id="filer_input" multiple="multiple">
            </div>
        </div>
        <input type="button" class="btn btn-block btn-info btn-sm" value="提交" onclick="video.sub()">

    </div>
    <br>  <br>  <br>

    <!-- 引入 css -->
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="{{url('plugins/filer/js/jquery.filer.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#filer_input").filer({
                changeInput: '<div class="jFiler-input-dragDrop">' +
                '<div class="jFiler-input-inner">' +
                '<div class="jFiler-input-icon">' +
                '</div>' +
                '<div class="jFiler-input-text">' +
                '<a  href="#" style="margin-left: 4px"><i class="fa fa-cloud-upload"></i> 上传您的视频</a>' +
                '</div>',
                showThumbs: true,
                templates: {
                    box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
                    item: '<li class="jFiler-item">\
						<div class="jFiler-item-container">\
							<div class="jFiler-item-inner">\
								<div class="jFiler-item-thumb">\
									<div class="jFiler-item-status"></div>\
									<div class="jFiler-item-thumb-overlay">\
										<div class="jFiler-item-info">\
											<div style="display:table-cell;vertical-align: middle;">\
												<span class="jFiler-item-title"><b title="@{{fi-name}}">@{{fi-name}}</b></span>\
												<span class="jFiler-item-others">@{{fi-size2}}</span>\
											</div>\
										</div>\
									</div>\
									@{{fi-image}}\
								</div>\
								<div class="jFiler-item-assets jFiler-row">\
									<ul class="list-inline pull-left">\
										<li>@{{fi-progressBar}}</li>\
									</ul>\
									<ul class="list-inline pull-right">\
										<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
									</ul>\
								</div>\
							</div>\
						</div>\
					</li>',
                    itemAppend: '<li class="jFiler-item">\
							<div class="jFiler-item-container">\
								<div class="jFiler-item-inner">\
									<div class="jFiler-item-thumb">\
										<div class="jFiler-item-status"></div>\
										<div class="jFiler-item-thumb-overlay">\
											<div class="jFiler-item-info">\
												<div style="display:table-cell;vertical-align: middle;">\
													<span class="jFiler-item-title"><b title="@{{fi-name}}">@{{fi-name}}</b></span>\
													<span class="jFiler-item-others">@{{fi-size2}}</span>\
												</div>\
											</div>\
										</div>\
										@{{fi-image}}\
									</div>\
									<div class="jFiler-item-assets jFiler-row">\
										<ul class="list-inline pull-left">\
											<li><span class="jFiler-item-others">@{{fi-icon}}</span></li>\
										</ul>\
										<ul class="list-inline pull-right">\
											<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
										</ul>\
									</div>\
								</div>\
							</div>\
						</li>',
                    progressBar: '<div class="bar"></div>',
                    itemAppendToEnd: false,
                },
                uploadFile: {
                    url: "uploadVideo",
                    data: null,
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    synchron: true,
                    beforeSend: function () {
                        alert('开始处理请稍等哦');
                    },
                    success: function (data, itemEl, listEl, boxEl, newInputEl, inputEl, id) {
                        var parent = itemEl.find(".jFiler-jProgressBar").parent(),
                            new_file_name = JSON.parse(data);
                        $("#hash").val(new_file_name.filename);
                        console.log(new_file_name);
                        filerKit = inputEl.prop("jFiler");

                        filerKit.files_list[id].name = new_file_name;

                        itemEl.find(".jFiler-jProgressBar").fadeOut("slow", function () {
                            $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");
                        });
                    },
                    error: function (el) {
                        var parent = el.find(".jFiler-jProgressBar").parent();
                        el.find(".jFiler-jProgressBar").fadeOut("slow", function () {
                            $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
                        });
                    },
                    statusCode: null,
                    onProgress: null,
                    onComplete: null
                },
                onRemove: function (itemEl, file, id, listEl, boxEl, newInputEl, inputEl) {
                    var filerKit = inputEl.prop("jFiler"),
                        file_name = filerKit.files_list[id].name;

                    //$.post('./php/ajax_remove_file.php', {file: file_name});
                },
                onEmpty: null,
                options: null,
                dialogs: {
                    alert: function (text) {
                        return alert(text);
                    },
                    confirm: function (text, callback) {
                        confirm(text) ? callback() : null;
                    }
                },
                captions: {
                    button: "Choose Files",
                    feedback: "Choose files To Upload",
                    feedback2: "files were chosen",
                    drop: "Drop file here to Upload",
                    removeConfirmation: "Are you sure you want to remove this file?",
                    errors: {
                        filesLimit: "Only @{{fi-limit}} files are allowed to be uploaded.",
                        filesType: "Only Images are allowed to be uploaded.",
                        filesSize: "@{{fi-name}} is too large! Please upload file up to @{{fi-maxSize}} MB.",
                        filesSizeAll: "Files you've choosed are too large! Please upload files up to @{{fi-maxSize}} MB."
                    }
                }
            });
        })

    </script>
    <script src="{{url('js/video/video.js')}}"></script>

@endsection