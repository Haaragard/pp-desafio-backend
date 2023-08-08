<?php

namespace App\Http\Controllers;

use App\Actions\Person\StoreAction;
use App\Dtos\Person\StoreDto;
use App\Dtos\User\StoreDto as UserStoreDto;
use App\Http\Requests\Person\StoreRequest;
use Illuminate\Http\Response;

class PersonController extends Controller
{
    /**
     * @param StoreRequest $request
     * @param StoreAction $action
     * @return Response
     */
    public function store(StoreRequest $request, StoreAction $action): Response
    {
        $personDto = new StoreDto(
            $request->validated('cpf')
        );

        $userDto = new UserStoreDto(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('phone'),
            $request->validated('password')
        );

        $action->execute($personDto, $userDto);

        return response(status: Response::HTTP_CREATED);
    }
}