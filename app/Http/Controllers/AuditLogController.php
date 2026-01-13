<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        // Show logs only for THIS company, newest first
        $logs = AuditLog::where('company_id', $request->user()->company_id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json($logs);
    }
}