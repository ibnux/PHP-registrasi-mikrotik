<?php

use \RouterOS\Client;
use \RouterOS\Query;

function sendSMS($to, $msg){
    $server_output = kirimWa($to, $msg);
    if(strpos($server_output,'success')===false){
        checkHealth();
        $server_output = kirimWa($to, $msg);
        if(strpos($server_output,'success')===false){
            checkHealth();
            $server_output = kirimWa($to, $msg);
            if(strpos($server_output,'success')===false){
                loginWa();
                kirimWa($to, $msg);
            }
        }
    }
    sendTelegram("$to\n$server_output");
    return $server_output;
}

function kirimWa($to, $msg){
    global $jwt_whatsapp,$server_whatsapp;
    $to = phone62($to);
    if(strlen(trim($to))<8){
        return;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $server_whatsapp.'/wa/send/text');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('msisdn' => $to.'@s.whatsapp.net','message' => $msg)));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/x-www-form-urlencoded',
        "X-JWT-Claims: $jwt_whatsapp",
        "Authorization: Bearer $jwt_whatsapp"
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close ($ch);
    return strtolower($server_output);
}

function checkHealth(){
    global $server_whatsapp;
    file_get_contents($server_whatsapp."/wa/health");
}

function loginWa(){
    global $jwt_whatsapp,$server_whatsapp;

    $n = 0;
    // tempat mengulang
    ulang:

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$server_whatsapp.'/wa/login');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('output' => 'json')));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/x-www-form-urlencoded',
        "X-JWT-Claims: $jwt_whatsapp",
        "Authorization: Bearer $jwt_whatsapp"
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close ($ch);

    $hasil = json_decode($server_output,true);
    // jika masih ada result data, berarti masih harus login
    if(empty($hasil['data'])){
        return $server_output;
    }else{
        $n++;
        // belum  5x? ulang terus
        if($n>5){
            return $server_output;
        }else{
            goto ulang;
        }
    }
    return $server_output;
}

function sendTelegram($txt){
    global $server_telegram;
    file_get_contents($server_telegram.urlencode($txt."\n\n".$_SERVER['HTTP_USER_AGENT']."\n".$_SERVER['REMOTE_ADDR']));
}



function showAlert($msg, $type){
    ?><div class="alert alert-<?=$type?> alert-dismissible fade show" role="alert"><?=$msg?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div><?php
}


function alphanumeric($str){
    return trim(preg_replace("/[^a-zA-Z0-9 ]+/", "", $str));
}


function alphanumericNoSpace($str){
    return trim(preg_replace("/[^a-zA-Z0-9]+/", "", $str));
}

function numeric($str){
    return trim(preg_replace("/[^0-9]+/", "", $str));
}

function phone($hp){
    $hp = numeric($hp);
    if(strlen($hp)>2){
        if(substr($hp,0,2)=='62'){
            $hp = '0'.substr($hp,2);
        }
    }
    return $hp;
}

function phone62($hp){
    $hp = numeric($hp);
    if(strlen($hp)>2){
        if(substr($hp,0,1)=='0'){
            $hp = '62'.substr($hp,1);
        }
    }
    return $hp;
}

function register($nohp,$email,$pass,$perusahan,$nama){
    global $mikrotik_ip,$mikrotik_user,$mikrotik_pass,$mikrotik_port;

    $client = new Client([
        'host' => $mikrotik_ip,
        'user' => $mikrotik_user,
        'pass' => $mikrotik_pass,
        'port' => $mikrotik_port
    ]);
    $query = new Query('/ip/hotspot/user/add');
    $query
        ->equal('name',$nohp)
        ->equal('password',$pass)
        ->equal('email',$email)
        ->equal('profile','userb3')
        ->equal('comment',$nama.' '.$perusahan);

    return $client->query($query)->read();
}


function updatePass($nohp,$pass){
    global $mikrotik_ip,$mikrotik_user,$mikrotik_pass,$mikrotik_port;

    $client = new Client([
        'host' => $mikrotik_ip,
        'user' => $mikrotik_user,
        'pass' => $mikrotik_pass,
        'port' => $mikrotik_port
    ]);
    $query = (new Query('/ip/hotspot/user/print'))
        ->where('name', $nohp);
    $user = $client->query($query)->read();

    $query = (new Query('/ip/hotspot/user/set'))
        ->equal('.id',$user[0]['.id'])
        ->equal('password',$pass);

    return $client->query($query)->read();
}