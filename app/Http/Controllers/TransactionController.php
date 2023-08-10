<?php

namespace App\Http\Controllers;

use App\Actions\Transaction\StoreAction;
use App\Dtos\Transaction\StoreDto;
use App\Http\Requests\Transaction\StoreRequest;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    /**
     * @param StoreRequest $request
     * @param StoreAction $action
     * @return Response
     */
    public function store(StoreRequest $request, StoreAction $action): Response
    {
        $storeDto = new StoreDto(
            $request->validated('payee'),
            $request->validated('amount')
        );

        $action->execute($storeDto);

        return response(status: Response::HTTP_CREATED);
    }
}