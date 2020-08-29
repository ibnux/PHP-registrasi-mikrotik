<?php

/******************************************************************************\
                                ﷽
    Dengan menyebut nama Allah Yang Maha Pemurah lagi Maha Penyayang
    Ya Allah, Sayangilah Kode ini sebagaimana Hambamu menyayangi kode ini
 ******************************************************************************
 *                                                                            *
 * Copyright (C) 2020 by Ibnu Maksum                                          *
 ******************************************************************************
 * This source and program come as is, WITHOUT ANY WARRANTY and/or WITHOUT    *
 * ANY IMPLIED WARRANTY.                                                      *
\******************************************************************************/

session_start();

header('Access-Control-Allow-Origin: *');
date_default_timezone_set("Asia/Jakarta");

include "vendor/autoload.php";
include "config.php";
include "function.php";

if ($debug) {
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(E_ERROR | ~E_NOTICE);
}

$_host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
//Parsing URL
$_path = array_values(array_filter(explode("/", parse_url($_SERVER['REQUEST_URI'])['path'])));
$_jml = count($_path);

$tpl = new League\Plates\Engine('template');
if ($debug) {
    $tpl->addData(['db' => $db, 'debug' => $debug]);
}

//All Methods
$tpl->addData([
    '_warna' => ['primary', 'warning', 'success', 'info', 'danger'],
    '_host'  => $_host,
    '_user' => $_user,
    'max_upload' => getMaximumFileUploadSize()
]);

//foo/bar.php
if (file_exists($modul = "web/" . $_path[0] . "/" . $_path[1] . ".php")) {
    $tpl->addData(['crumbs' => $crumbs = [$_path[0], $_path[1]]]);
    unset($_path[0], $_path[1]);
    $_path = array_values($_path);
    $tpl->addData(['_path' => $_path]);
    include $modul;
    //foo/foo.php
} else if (file_exists($modul = "web/" . $_path[0] . "/" . $_path[0] . ".php")) {
    $tpl->addData(['crumbs' => $crumbs = [$_path[0]]]);
    unset($_path[0]);
    $_path = array_values($_path);
    $tpl->addData(['_path' => $_path]);
    include $modul;
    die();
    //foo.php
} else if (file_exists($modul = "web/" . $_path[0] . ".php")) {
    $tpl->addData(['crumbs' => $crumbs = [$_path[0]]]);
    unset($_path[0]);
    $_path = array_values($_path);
    $tpl->addData(['_path' => $_path]);
    include $modul;
    die();
} else {
    $tpl->addData(['crumbs' => [$_path[0]]]);
    $tpl->addData(['_path' => $_path]);
    include "web/home.php";
}
