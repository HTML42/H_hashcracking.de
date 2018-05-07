<?php

if ($_POST['secret'] != '7sd8f32jkMA!') {
    die();
}

$input_exists = isset($_POST['input']) && is_string($_POST['input']) && strlen($_POST['input']) > 0;
$from_own_page = (strstr($_SERVER['HTTP_REFERER'], 'HTML42-hashcracking.de') && strstr($_SERVER['HTTP_REFERER'], 'localhost')) ||
        (strstr($_SERVER['HTTP_REFERER'], 'hashcracking.de') && !strstr($_SERVER['HTTP_REFERER'], 'localhost'));

$answer_found = false;

if ($input_exists && $from_own_page) {
    include '../library/hashbank.class.php';
    $input = trim(strip_tags(stripcslashes($_POST['input'])));
    $base64_try = base64_decode($input);
    //
    $should_not_be_base64 = (strlen($input) == 32 || strlen($input) == 40) && substr($input, -1) != '=';
    //
    if (!$answer_found && $base64_try && !$should_not_be_base64) {
        $answer_found = array(
            'algorithm' => 'base64',
            'plain' => $base64_try
        );
    }
    //Try own inner DB
    if (!$answer_found) {
        $input_p1 = substr($input, 0, 3);
        $input_p2 = substr($input, 3, 3);
        foreach (array('md5', 'sha1') as $_alghorithm) {
            $folder_1 = PROJECT_ROOT . '_hashbank/' . $_alghorithm . '/';
            $folder_2 = $folder_1 . $input_p1 . '/';
            $folder_3 = $folder_2 . $input_p2 . '/';
            $hashfile = $folder_3 . $input;
            if (is_dir($folder_1) && is_dir($folder_2) && is_dir($folder_3) && is_file($hashfile)) {
                $answer_found = array(
                    'algorithm' => $_alghorithm,
                    'plain' => trim(file_get_contents($hashfile))
                );
            }
        }
    }
    //Try harder (md5 / sha1)
    if (!$answer_found) {
        $hashbank = Hashbank::decode($input);
        //
        if ($hashbank['result'] && $hashbank['alghorithm']) {
            Hashbank::save($hashbank['result']);
            $answer_found = array(
                'algorithm' => $hashbank['alghorithm'],
                'plain' => $hashbank['result']
            );
        }
    }
}
if ($answer_found) {
    echo json_encode($answer_found);
}
die;
