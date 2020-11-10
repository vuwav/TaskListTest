<?php


namespace App\Actions\User;

use App\Models\User;
use Illuminate\Http\Request;

class ShowAction
{
    public function __invoke(Request $request): array
    {
       $data = ['user' => $request->user()];
       if($request->user()->role === User::ROLE_MANAGER){
           $data['workers'] = $request->user()->workers()->get(['id','name'])->map(fn($worker) => ['text' => $worker['name'], 'value' => $worker['id']] );
       }
       return [$data, 200];
    }
}
