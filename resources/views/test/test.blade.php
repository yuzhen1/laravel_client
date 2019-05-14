<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h4>ajax请求</h4>
<script src="/jquery-3.1.1.min.js"></script>
<script>
    $.ajax({
        type: 'GET',
        url: 'http://api.1809a.com/test/test',    //规定连同请求发送到服务器的数据；
        dataType: 'jsonp',
        jsonp: "jsonpCallback",//服务端用于接收callback调用的function名的参数
        success: function(res) {
            console.log(res);
        }     //请求成功时执行的回调函数；
    })
</script>
</body>
</html>