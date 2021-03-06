<?php


namespace App\Actions\User;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginAction
{
    public function __invoke(Request $request): array
    {
        $requestData = $request->only(['login', 'password']);
        $login = $request->input('login');
        $password = $request->input('password');
        $validator = validator(
            $requestData, ['login' => 'required|min:4', 'password' => 'required|min:8']
        );

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            return [['message' => $validator->errors()], 400];
        }

        if (! $user = User::where('login', $login)->first()) {
            return [['message' => trans('error.user.cant.find.login')], 400];
        }

        if (! Hash::check($password, $user->password)) {
            return [['message' => trans('error.user.invalid.password')], 400];
        }

        $user->api_token = $user->refreshToken();

        return [['message' => trans('success.user.successfully.login'), 'user' => $user], 200];
    }
}
