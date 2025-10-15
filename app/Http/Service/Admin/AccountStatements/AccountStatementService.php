<?php

namespace App\Http\Service\Admin\AccountStatements;

use App\Http\Resources\AccountStatement\AccountStatementResource;
use App\Models\AccountStatement;
use Illuminate\Support\Facades\Storage;

class AccountStatementService
{
    public function index()
    {
        $client = auth()->user();
        $accountStatements = AccountStatement::where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return AccountStatementResource::collection($accountStatements);
    }

    public function store(array $data)
    {
        if (isset($data['pdf'])) {
            $path = $data['pdf']->store('account_statements', 'public');
            $data['file'] = $path;
            unset($data['pdf']);
        }

        AccountStatement::create($data);
        return response()->json('تم الانشاء بنجاح', 201);
    }

    public function update(array $data, $account_statement)
    {
        if (isset($data['pdf'])) {
            // حذف القديم لو موجود
            if ($account_statement->file && Storage::disk('public')->exists($account_statement->file)) {
                Storage::disk('public')->delete($account_statement->file);
            }

            $path = $data['pdf']->store('account_statements', 'public');
            $data['file'] = $path;
            unset($data['pdf']);
        }

        $account_statement->update($data);
        return response()->json('تم التعديل بنجاح', 200);
    }

    public function destroy($account_statement)
    {
        if ($account_statement->file && Storage::disk('public')->exists($account_statement->file)) {
            Storage::disk('public')->delete($account_statement->file);
        }

        $account_statement->delete();
        return response()->json('تم الحذف بنجاح', 200);
    }
}
