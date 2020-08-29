<?php

$nohp = phone($_POST['nohp']);
if (empty($nohp)) {
    $nohp = $_SESSION['nohp'];
}

if (strlen(trim($nohp)) < 8) {
    die($tpl->render("alert", [
        "msgType" => 'danger',
        "url" => '/',
        'msg' => 'Nomor HP tidak valid'
    ]));
}

if ($_POST['validasi'] == 'otp') {
    if (file_exists("./data/waiting/$nohp.json") && file_exists("./data/otp/$nohp.otp")) {
        $otp = file_get_contents("./data/otp/$nohp.otp");
        if ($_POST['otp'] == $otp) {
            $data = file_get_contents("./data/waiting/$nohp.json");
            $data = json_decode($data, true);
            unlink("./data/waiting/$nohp.json");
            unlink("./data/otp/$nohp.otp");
            $hasil = register($nohp, $data['email'], $data['password'], $data['perusahaan'], $data['nama']);

            file_put_contents("./data/registered/$nohp.json", json_encode($data));
            die($tpl->render("alert", [
                "msgType" => 'danger',
                "url" => $server,
                'msg' => 'Registrasi sukses'
            ]));
        } else {
            die($tpl->render("alert", [
                "msgType" => 'danger',
                "url" => '/requestOTP',
                'msg' => 'OTP tidak valid'
            ]));
        }
    } else {
        die($tpl->render("alert", [
            "msgType" => 'danger',
            "url" => '/',
            'msg' => 'data tidak ditemukan'
        ]));
    }
}

if ($_POST['request'] == 'otp') {
    $data = $_POST;
    if (file_exists("./data/waiting/$nohp.json") && file_exists("./data/otp/$nohp.otp")) {
        if (time() - filemtime("./data/otp/$nohp.otp") > 300) {
            $otp = file_get_contents("./data/otp/$nohp.otp");
            sendSMS(phone62($nohp), "OTP Internet B3 *$otp*");
        } else {
            $otp = rand(1000, 9999);
            file_put_contents("./data/otp/$nohp.otp", $otp);
            sendSMS(phone62($nohp), "OTP Internet B3 *$otp*");
        }
    } else {
        file_put_contents("./data/waiting/$nohp.json", json_encode($_POST));
        $otp = rand(1000, 9999);
        file_put_contents("./data/otp/$nohp.otp", $otp);
        sendSMS(phone62($nohp), "OTP Internet B3 *$otp*");
    }
}
$_SESSION['nohp'] = $nohp;
echo $tpl->render("otp", ['hp' => $nohp]);
