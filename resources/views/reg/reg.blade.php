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
<form action="/login/reg_do" method="post">
    <table>
        <tr>
            <td>姓名</td>
            <td><input type="text" name="user_name"></td>
        </tr>
        <tr>
            <td>邮箱</td>
            <td><input type="text" name="user_email"></td>
        </tr>
        <tr>
            <td>密码</td>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <td>确认密码</td>
            <td><input type="password" name="password2"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="注册"></td>
        </tr>
    </table>

</form>
</body>
</html>