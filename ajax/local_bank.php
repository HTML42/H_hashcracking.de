<?php

if (is_file('../xtreme/library/bootstrap.php')) {
    include_once '../xtreme/library/bootstrap.php';
}
define('HASHBANK', PROJECT_ROOT . '_hashbank/');

$input = trim(strip_tags(stripcslashes($_GET['input'])));
$result = null;
$alghorithm = null;

foreach (array(HASHBANK, HASHBANK . 'md5', HASHBANK . 'sha1') as $folder_to_check) {
    if (!is_dir($folder_to_check)) {
        File::_create_folder($folder_to_check);
    }
}

$is_md5 = strlen($input) == 32;
$is_sha1 = strlen($input) == 40;

if ($is_md5 || $is_sha1) {
    $input_p1 = substr($input, 0, 3);
    $input_p2 = substr($input, 3, 3);
    $_alghorithm = ($is_md5 ? 'md5' : ($is_sha1 ? 'sha1' : ''));
    $folder_1 = HASHBANK . $_alghorithm . '/';
    $folder_2 = $folder_1 . $input_p1 . '/';
    $folder_3 = $folder_2 . $input_p2 . '/';
    $hashfile = $folder_3 . $input;
    if(is_dir($folder_1) && is_dir($folder_2) && is_dir($folder_3) && is_file($hashfile)) {
        $result = file_get_contents($hashfile);
        $alghorithm = $_alghorithm;
    }
}



echo json_encode(array(
    'result' => $result,
    'alghorithm' => $alghorithm
));
die;
