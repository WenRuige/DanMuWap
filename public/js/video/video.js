var user = new Vue({
    el: "#app",
    data: {
        images: [],
        file: ''
    },
    created: function () {
        //创建的时候首先跑一遍接口
        console.log('123');
    }, methods: {
        onFileChange: function (e) {
            // Reference to the DOM input element
            var files = e.target.files || e.dataTransfer.files;
            xhr.open("POST", uri, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle response.
                    alert(xhr.responseText); // handle response.
                }
            };
            fd.append('myFile', file);
            // Initiate a multipart/form-data upload
            xhr.send(fd);
        }, sub: function () {

            this.$http.post('/uploadVideo',
                {
                    params: {'file': this.images}
                }
            ).then(response => {

            }, response => {
                console.log(response);
            });

        }
    }
})