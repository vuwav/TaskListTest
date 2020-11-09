<?php


namespace App\Traits;


use Illuminate\Support\Facades\Hash;

trait HasToken
{
    static function createToken() {
        return base64_encode(Hash::make(mt_rand() . time()));
    }

    public function refreshToken() {
        $token = static::createToken();
        $this->api_token = $token;
        $this->save();
        return $token;
    }
}
