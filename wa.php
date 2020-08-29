<?php
include "config.php";
include "function.php";

if(isset($_REQUEST['to']) && $_REQUEST['txt']){
    echo sendWA(phone62($_REQUEST['to']), $_REQUEST['txt']);
}else{
    echo '<pre>';
    $json = json_decode(loginWa(),true);
    if(!empty($json['data']['qrcode'])){
        echo '<img src="'.$json['data']['qrcode'].'">';
    }else{
        print_r($json);
    }
}