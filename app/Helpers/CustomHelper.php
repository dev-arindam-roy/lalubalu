<?php
namespace App\Helpers;

class CustomHelper {

    public static function uniqueCardNumber($uinqueId)
    {
        $codeAlphabets = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $cardNumber = '';
        for ($i = 0; $i < 4; $i++) {
            $cardNumber .= $codeAlphabets[rand(0, (strlen($codeAlphabets) - 1))];
        }
        $cardNumber .= rand(rand(121212, 999999), rand(121212, 999999));
        for ($i = 0; $i < 2; $i++) {
            $cardNumber .= $codeAlphabets[rand(0, (strlen($codeAlphabets) - 1))];
        }
        return strtoupper($cardNumber);
    }
}