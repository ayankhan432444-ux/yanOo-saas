<?php

namespace App\Http\Controllers;

abstract class Controller
{// Helper function to create an Audit Log entry
    protected function logAudit($request, $event, $description)
    {
        \App\Models\AuditLog::create([
            'company_id' => $request->user()->company_id,
            'user_id' => $request->user()->id,
            'event' => $event,
            'description' => $description,
            'ip_address' => $request->ip()
        ]);
    }
}
