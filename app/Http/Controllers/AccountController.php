<?php

namespace App\Http\Controllers;

use App\Actions\Account\DepositAction;
use App\Actions\Account\WithdrawAction;
use App\Dtos\Account\DepositDto;
use App\Dtos\Account\WithdrawDto;
use App\Http\Requests\Account\DepositRequest;
use App\Http\Requests\Account\WithdrawRequest;
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

    /**
     * @param WithdrawRequest $request
     * @param WithdrawAction $action
     * @return Response
     */
    public function withdraw(WithdrawRequest $request, WithdrawAction $action): Response
    {
        $withdrawDto = new WithdrawDto($request->validated('amount'));

        $successOnWithdraw = $action->execute($withdrawDto);

        $statusResponse = ($successOnWithdraw)
            ? Response::HTTP_CREATED
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        return response(status: $statusResponse);
    }
}