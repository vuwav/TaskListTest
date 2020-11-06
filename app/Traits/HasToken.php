<?php


namespace App\Traits;


use Illuminate\Support\Facades\Hash;

trait HasToken
{
    static function createToken($login) {
        return base64_encode(Hash::make($login . rand() . time()));
    }
}
