<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MdController extends Controller
{
    //加密
    const IV = "d89fb057f6d4f03g";//加密向量，16个字节
    const KEY = 'e9c8e878ee8e2658';//密钥，16个字节

    public function curl(Request $request){

        $user_name=$request->input('user_name');
        $data = $this->encrypt($user_name);
        var_dump($data);
        $str = json_encode($data,JSON_UNESCAPED_UNICODE);
        // create curl resource
        $ch = curl_init();
        // set url
        curl_setopt($ch, CURLOPT_URL, "http://api.1809a.com/deal");
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //使用post方式请求
        curl_setopt($ch,CURLOPT_POST,1);
        //请求携带的参数
        curl_setopt($ch,CURLOPT_POSTFIELDS,$str);

        // 获取信息
        $output = curl_exec($ch);
        print_r($output);
        // close curl resource to free up system resources
        curl_close($ch);
    }

    //对称加密
    public static function encrypt($strContent,$key = self::KEY,$iv = self::IV)
    {
        $strEncrypted = openssl_encrypt($strContent, "AES-128-CBC", $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($strEncrypted);
    }

    //凯撒加密
    public function kai_encode($string = 'hello',$n=2){
        $pass='';
        $strCount = strlen($string);
        for($i=0;$i<$strCount;$i++){
            $ascii = ord($string[$i])+$n;
            $pass .= chr($ascii);
        }
        return $pass;
    }

    //凯撒解密
    public function kai_decode($pass,$n){
        $dis='';
        $passCount = strlen($pass);
        for($i=0;$i<$passCount;$i++){
            $ascii = ord($pass[$i]);
            $dis .= chr($ascii-$n);
        }
        return $dis;
    }

    //openssl_encode
    public function opssl_encode(){
//        $before_str = 'hello world';
        $data=[
            'username'=>'zhangsan',
            'useremail'=>'zhangsan@qq.com'
        ];
        $post_str = json_encode($data);
        $method = 'AES-256-CBC';
        $key = 'abcdefg';
        $options = OPENSSL_RAW_DATA;
        $iv = 'd89fb057f6d44r5z';
        $enc_str = openssl_encrypt($post_str,$method,$key,$options,$iv);
        $after_str = base64_encode($enc_str);
//        echo "原文：".$before_str;echo "<br>";
//        echo "密文：".$enc_str;echo "<br>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.1809a.com/deal/opssl_decode");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$after_str);
        $output = curl_exec($ch);
        print_r($output);
        // close curl resource to free up system resources
        curl_close($ch);
    }

    //非对称加密  私钥加密
    public function private_encode(){
        $data = [
            'user_name'=>'zhangsan',
            'user_email'=>'zhangsan@qq.com'
        ];
        //加密数据
        $str = json_encode($data);
        $priv_key = openssl_pkey_get_private('file://'.storage_path('/app/keys/private.pem'));
        openssl_private_encrypt($str,$en_data,$priv_key);
        $after_str = base64_encode($en_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.1809a.com/deal/male_decode");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$after_str);
        $output = curl_exec($ch);
        print_r($output);
        curl_close($ch);
    }

    //公钥加密
    public function male_encode(){
        $data = [
            'user_name'=>'lisi',
            'age'=>18
        ];
        $str = json_encode($data);
        $pub_key = openssl_pkey_get_public('file://'.storage_path('/app/keys/public.pem'));
        openssl_public_encrypt($str,$en_data,$pub_key);
        $after_str = base64_encode($en_data);
//        var_dump($en_data);echo "<hr>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.1809a.com/deal/private_decode");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$after_str);
        $output = curl_exec($ch);
        print_r($output);
        curl_close($ch);
    }

    //签名
    public function signature(){
        $data = [
            'user_id'=>12,
            'user_name'=>'jennifer',
            'amount'=>2000,
            'title'=>"测试"
        ];
        $str = json_encode($data);  //要发送的数据
        $private_key = openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
        openssl_sign($str,$sign_data,$private_key);
        $base_data = base64_encode($sign_data);
//        var_dump($base_data);
        $url = "http://api.1809a.com/deal/sign_verify?sign=".urlencode($base_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$str);
        $output = curl_exec($ch);
        print_r($output);
        curl_close($ch);
    }
}
