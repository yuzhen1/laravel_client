<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller{
    //注册
    public function reg(){
        return view('reg/reg');
    }
    //注册执行
    public function reg_do(request $request){
        $user_name = $request->input('user_name');
        $user_email = $request->input('user_email');
        $password = $request->input('password');
        $password2 = $request->input('password2');
        $data = [
            'user_name'=>$user_name,
            'user_email'=>$user_email,
            'password'=>$password,
            'password2'=>$password2
        ];
        $str = json_encode($data);//发送的数据
        //私钥加密
       $pri_key = openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
       openssl_private_encrypt($str,$en_data,$pri_key);
       $after_str = base64_encode($en_data);
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, "http://api.1809a.com/login/register");
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch,CURLOPT_POST,1);
       curl_setopt($ch,CURLOPT_POSTFIELDS,$after_str);
       $output = curl_exec($ch);
       print_r($output);
       curl_close($ch);
    }

    //登录
    public function login(){
        return view('reg/login');
    }
    //登录执行
    public function login_do(request $request){
        $data = [
            'user_name'=>$request->input('user_name'),
            'user_email'=>$request->input('user_email'),
            'password'=>$request->input('password'),
            'password2'=> $request->input('password2')
        ];
        $str = json_encode($data);//发送的数据
        //私钥加密
        $pri_key = openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
        openssl_private_encrypt($str,$en_data,$pri_key);
        $after_str = base64_encode($en_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.1809a.com/login/login");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$after_str);
        $output = curl_exec($ch);
        print_r($output);
        curl_close($ch);
    }
}
