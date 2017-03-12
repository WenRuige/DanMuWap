var video = {
    sub: function () {
        var dataObj = {};


        dataObj['name'] = $("#name").val();
        if (dataObj['name'] == '') {
            alert('视频名称不许为空');
            return false;
        }
        dataObj['content'] = $("#content").val();
        if (dataObj['content'] == '') {
            alert('视频间接不可为空!');
            return false;
        }
        dataObj['video'] = $("#hash").val();
        if(dataObj['video'] == ''){
            alert('视频不可为空啊!');
        }
        //封面
        dataObj['picture'] = $("#img").val();
        $.post("uploadVideoInformation", dataObj, function (ret) {

        });

    },//上传图片
    uploadPicture: function () {
        var img = document.getElementById('picture').files[0];
        var reader = new FileReader();
        reader.readAsDataURL(img);
        reader.onload = function (e) { // reader onload start
            // ajax 上传图片
            $.post("uploadPicture", {img: e.target.result}, function (ret) {
                if (ret.img != '') {
                    alert('上传成功!');
                    $("#img").val(ret.img);
                    //  $('#showimg').html('<img src="' + ret.img + '">');
                } else {
                    alert('上传失败!');
                }
            }, 'json');
        } // reader onload end
    }
}