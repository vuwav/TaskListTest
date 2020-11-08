<?php


namespace App\Actions\User;


use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterAction
{
    public function __invoke(Request $request): array
    {
        $validator = validator(
            $request->all(),
            [
                'login' => 'required|unique:users,login|min:4',
                'password' => 'required|confirmed|min:8',
                'name' => 'required',
                'family' => 'required',
                'surname' => 'required',
                'role' => 'numeric|gt:-1',
            ]
        );


        try {
            $validData = $validator->validate();
        } catch (ValidationException $e) {
            return [['message' => [$validator->errors()]], 400];
        }

        $api_token = User::createToken($validData['login']);

        $validData['password'] = Hash::make($validData['password']);
        $validData['api_token'] = $api_token;

        try {
            $user = User::create($validData);
        } catch (Exception $e) {
            return [['message' => trans('error.user.when.creating'), 'api_token' => $api_token], 201];
        }

        return [['message' => trans('success.user.created'), 'user' => $user], 201];
    }
}
