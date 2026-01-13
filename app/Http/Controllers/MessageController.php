<?php



namespace App\Http\Controllers;
use App\Models\Message; // Message Model ko use karne ke liye
use Illuminate\Http\Request; // Request 
use Illuminate\Support\Facades\Auth; 
class MessageController extends Controller
{
    // 1. View Chat History
   // app/Http/Controllers/Api/MessageController.php
public function index()
{
    // Ab 'user' relationship kaam karega
    return Message::where('company_id', auth()->user()->company_id)
                  ->with('user:id,name') 
                  ->oldest()
                  ->get();
}

public function store(Request $request) {
    $request->validate(['message' => 'required|string']);

    // Message creation with tenant ID
    $message = Message::create([
        'company_id' => auth()->user()->company_id,
        'user_id' => auth()->id(),
        'message' => $request->message
    ]);

    // Audit log for messaging
    // logAudit('message_sent', 'User sent a support message');

    return response()->json($message, 201);
}
}