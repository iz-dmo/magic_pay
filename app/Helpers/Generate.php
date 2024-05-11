<?php

namespace App\Helpers;
use App\Models\Wallet;

class Generate{

    public static function accountNumber()
    {
        $number = mt_rand(1000000000000000,9999999999999999);
        $exist_wallet = Wallet::where('account_number',$number)->first();
        if($exist_wallet){
            self::accountNumber();
        }
        return $number;
    }
}

?>