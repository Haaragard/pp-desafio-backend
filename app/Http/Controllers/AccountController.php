<?php

namespace App\Http\Controllers;

use App\Actions\Account\DepositAction;
use App\Dtos\Account\DepositDto;
use App\Http\Requests\Account\DepositRequest;
use Illuminate\Http\Response;

class AccountController extends Controller
{
    /**
     * @param DepositRequest $request
     * @param DepositAction $action
     * @return Response
     */
    public function deposit(DepositRequest $request, DepositAction $action): Response
    {
        $depositDto = new DepositDto($request->validated('amount'));

        $successOnDeposit = $action->execute($depositDto);

        $statusResponse = ($successOnDeposit)
            ? Response::HTTP_CREATED
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        return response(status: $statusResponse);
    }

}