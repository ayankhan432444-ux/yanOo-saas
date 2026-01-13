<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\AuditLog; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->role === 'super_admin') {
            return File::latest()->get();
        }

        return File::where('company_id', $user->company_id)->latest()->get();
    }

    public function upload(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:5120', 
            ]);

            $user = $request->user();
            $company = $user->company;

            // 1. Quota Check based on Status
            if ($user->role !== 'super_admin') {
                $isPro = ($company->status === 'active' || $company->status === 'approved');
                $allowedLimit = $isPro ? 100 : 2; 

                $currentFilesCount = File::where('company_id', $user->company_id)->count();

                if ($currentFilesCount >= $allowedLimit) {
                    return response()->json([
                        'message' => "Quota Exhausted! Limit: {$allowedLimit} files.",
                        'hint' => "Upgrade to Pro for more storage."
                    ], 403);
                }
            }

            return DB::transaction(function () use ($request, $user) {
                $uploadedFile = $request->file('file');
                $filename = time() . '_' . $uploadedFile->getClientOriginalName();
                
                $path = $uploadedFile->storeAs('uploads', $filename, 'public');

                if (!$path) throw new \Exception("Disk Write Failed.");

                // 2. ✅ CRITICAL FIX: User ID Column Check
                // Agar DB mein user_id nahi hai, toh SQL error se bachne ke liye hum check laga rahe hain
                $fileData = [
                    'company_id' => $user->company_id,
                    'filename'   => $uploadedFile->getClientOriginalName(),
                    'path'       => $path,
                ];

                // Sirf tab add karein agar column table mein ho
                if (Schema::hasColumn('files', 'user_id')) {
                    $fileData['user_id'] = $user->id;
                }

                $fileRecord = File::create($fileData);

                // 3. Audit Logging (Using 'description' if 'details' fails)
                $this->logEvent($user, 'file_uploaded', 'Node Asset Sync: ' . $filename);

                return response()->json([
                    'message' => 'Asset successfully synchronized to Cloud Storage',
                    'data' => $fileRecord
                ]);
            });

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'System Breach/Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $file = File::findOrFail($id);
            Storage::disk('public')->delete($file->path);
            $file->delete();
            return response()->json(['message' => 'Asset Terminated']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    private function logEvent($user, $event, $details)
    {
        try {
            $logData = [
                'company_id' => $user->company_id,
                'user_id'    => $user->id,
                'event'      => $event,
            ];

            // Tinker check ke mutabiq 'description' ya 'details' handle karein
            if (Schema::hasColumn('audit_logs', 'description')) {
                $logData['description'] = $details;
            } else {
                $logData['details'] = $details;
            }

            AuditLog::create($logData);
        } catch (\Exception $e) {
            Log::error("Audit Protocol Failed: " . $e->getMessage());
        }
    }
}