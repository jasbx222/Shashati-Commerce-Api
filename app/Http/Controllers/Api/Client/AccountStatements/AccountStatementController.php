<?php

namespace App\Http\Controllers\Api\Client\AccountStatements;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountStatement\AccountStatementResource;
use App\Models\AccountStatement;
use Barryvdh\DomPDF\Facade\Pdf; // استدعاء الـ PDF

class AccountStatementController extends Controller
{
    public function index()
    {
        $client = auth()->user();
        $accountStatements = AccountStatement::where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->filter()
            ->get();

        return AccountStatementResource::collection($accountStatements);
    }

   public function downloadPdf($statementId = null)
{
    $client = auth()->user();

    if ($statementId) {
        // تنزيل بيان محدد
        $accountStatements = AccountStatement::where('client_id', $client->id)
            ->where('id', $statementId)
            ->get();
    } else {
        $accountStatements = AccountStatement::where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    if ($accountStatements->isEmpty()) {
        return response()->json(['message' => 'No account statement found'], 404);
    }

    $pdf = Pdf::loadView('pdf.account_statements', compact('accountStatements', 'client'));

    return $pdf->download($statementId ? "account_statement_{$statementId}.pdf" : 'account_statements.pdf');
}

}
