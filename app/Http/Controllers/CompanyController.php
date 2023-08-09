<?php

namespace App\Http\Controllers;

use App\Actions\Company\StoreAction;
use App\Dtos\Company\StoreDto;
use App\Dtos\User\StoreDto as UserStoreDto;
use App\Http\Requests\Company\StoreRequest;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * @param StoreRequest $request
     * @param StoreAction $action
     * @return Response
     */
    public function store(StoreRequest $request, StoreAction $action): Response
    {
        $companyDto = new StoreDto(
            $request->validated('cnpj')
        );

        $userDto = new UserStoreDto(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('phone'),
            $request->validated('password')
        );

        $action->execute($companyDto, $userDto);

        return response(status: Response::HTTP_CREATED);
    }
}