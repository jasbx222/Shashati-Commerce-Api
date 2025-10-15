<?php

namespace App\Http\Controllers\Api\Admin\AccountStatements;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\account_statement\AccountStatementRequest;
use App\Http\Service\Admin\AccountStatements\AccountStatementService;
use App\Models\AccountStatement;

class AccountStatementController extends Controller
{


    private $account_statement;

    public function __construct(AccountStatementService $account_statement)
    {
        $this->account_statement = $account_statement;
    }
    public function index()
    {

        return $this->account_statement->index();
    }

    public function store(AccountStatementRequest $request)
    {

        return $this->account_statement->store($request->validated());
    }
    public function update(AccountStatementRequest $request, AccountStatement $account_statement)
    {
        return $this->account_statement->update($request->validated(), $account_statement);
    }
    public function destroy(AccountStatement $account_statement)
    {
        return $this->account_statement->destroy($account_statement);
    }
}
