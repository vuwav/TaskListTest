<?php


namespace App\Traits;


use Illuminate\Support\Facades\Hash;

trait HasToken
{
    public string $api_token;

    static function createToken()
    {
        return base64_encode(Hash::make(mt_rand() . time()));
    }

    public function refreshToken()
    {
        $token = static::createToken();
        $this->update(['api_token' => $token]);
        return $token;
    }
}
