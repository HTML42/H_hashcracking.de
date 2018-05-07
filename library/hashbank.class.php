<?php

if (is_file('../xtreme/library/bootstrap.php')) {
    include_once '../xtreme/library/bootstrap.php';
}

class Hashbank {

    public static $bank_api = BASEURL . 'local_bank.php';
    
    public static function decode($input) {
        $return = null;
        if(is_string($input) && strlen($input) > 0) {
            $hashbank_response = Curl::get_json(self::$bank_api . '?input=' . urlencode($input));
            $return = $hashbank_response;
        }
        return $return;
    }

}

if (ENV != 'dev') {
    Hashbank::$bank_api = 'http://api.hashcracking.de/index.php';
}
