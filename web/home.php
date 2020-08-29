<?php

if($_POST['update']=='password'){
    $nohp = phone($_POST['nohp']);
    $pass = $_POST['newpass'];
    $oldpass = $_POST['oldpass'];
    if (strlen(trim($nohp)) < 8) {
        die($tpl->render("alert", [
            "msgType" => 'danger',
            "url" => '/',
            'msg' => 'Nomor HP tidak valid'
        ]));
    }
    if (empty(trim($pass))) {
        die($tpl->render("alert", [
            "msgType" => 'danger',
            "url" => '/',
            'msg' => 'Password kosong'
        ]));
    }
    if (empty(trim($oldpass))) {
        die($tpl->render("alert", [
            "msgType" => 'danger',
            "url" => '/',
            'msg' => 'Password lama kosong'
        ]));
    }
    if (!file_exists("./data/registered/$nohp.json")){
        die($tpl->render("alert", [
            "msgType" => 'danger',
            "url" => '/',
            'msg' => 'Nomor tidak terdaftar'
        ]));
    }
    $data = json_decode(file_get_contents("./data/registered/$nohp.json"),true);
    if($data['password']==$oldpass){
        $data['password'] = $pass;
        file_put_contents("./data/registered/$nohp.json",json_encode($data));
        updatePass($nohp,$pass);
        die($tpl->render("alert", [
            "msgType" => 'danger',
            "url" => $server,
            'msg' => 'Update password sukses'
        ]));
    }else{
        die($tpl->render("alert", [
            "msgType" => 'danger',
            "url" => '/',
            'msg' => 'Password lama salah'
        ]));
    }
}

echo $tpl->render("home");