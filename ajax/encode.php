<?php

if ($_POST['secret'] != '7sd8f32jkMA!') {
    die();
}

$input_exists = isset($_POST['input']) && is_string($_POST['input']) && strlen($_POST['input']) > 0;
$from_own_page = (strstr($_SERVER['HTTP_REFERER'], 'HTML42-hashcracking.de') && strstr($_SERVER['HTTP_REFERER'], 'localhost')) ||
        (strstr($_SERVER['HTTP_REFERER'], 'hashcracking.de') && !strstr($_SERVER['HTTP_REFERER'], 'localhost'));

if ($input_exists && $from_own_page) {
    $input = $_POST['input'];
    $hashes = array(
        "base64" => base64_encode($input),
        "md5" => md5($input),
        "sha1" => sha1($input)
    );
    echo json_encode($hashes);
}
die;
