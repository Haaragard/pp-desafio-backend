<?php

namespace App\Http\Controllers;

use App\Actions\User\LoginAction;
use App\Dtos\User\LoginDto;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function login(LoginRequest $request, LoginAction $action): Response
    {
        $loginDto = new LoginDto(
            $request->validated('email'),
            $request->validated('password')
        );

        $newUserToken = $action->execute($loginDto);

        return response(['token' => $newUserToken], Response::HTTP_CREATED);
    }
}