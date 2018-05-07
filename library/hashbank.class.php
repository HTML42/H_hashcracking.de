<?php

if (is_file('../xtreme/library/bootstrap.php')) {
    include_once '../xtreme/library/bootstrap.php';
}

class Hashbank {

    public static $bank_api = BASEURL . 'local_bank.php';
    public static $local_bank = PROJECT_ROOT . '_hashbank/';

    public static function decode($input) {
        $return = null;
        if (is_string($input) && strlen($input) > 0) {
            $hashbank_response = Curl::get_json(self::$bank_api . '?input=' . urlencode($input));
            $return = $hashbank_response;
        }
        return $return;
    }

    public static function save($input) {
        $md5 = md5($input);
        $sha1 = sha1($input);
        foreach (array('md5', 'sha1') as $alghorithm) {
            $input_p1 = substr($$alghorithm, 0, 3);
            $input_p2 = substr($$alghorithm, 3, 3);
            $folder_1 = self::$local_bank . $alghorithm . '/';
            $folder_2 = $folder_1 . $input_p1 . '/';
            $folder_3 = $folder_2 . $input_p2 . '/';
            $hashfile = $folder_3 . $$alghorithm;
            Utilities::ensure_structure($folder_3);
            file_put_contents($hashfile, $input);
        }
    }

}

if (ENV != 'dev') {
    Hashbank::$bank_api = 'http://api.hashcracking.de/index.php';
}
