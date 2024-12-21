<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('attachments')) {
            $attachments = $request->attachments;
            $folder = uniqid() . '_' . now()->timestamp;

            foreach ($attachments as $attachment) {
                $filename = $attachment->getClientOriginalName();
                $path = $attachment->storeAs("uploads/tmp/{$folder}", $filename);

                TemporaryFile::create([
                    'folder' => $folder,
                    'filename' => $filename,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            \Log::info('Attachments stored in the local folder.');

            return ['folder' => $folder];
        }

        if ($request->hasFile('userFileUpload')) {
            $userFileUpload = $request->userFileUpload;
            $folder = uniqid() . '_' . now()->timestamp;

            foreach ($userFileUpload as $fileUpload) {
                $filename = $fileUpload->getClientOriginalName();
                $path = $fileUpload->storeAs("uploads/tmp/{$folder}", $filename);

                TemporaryFile::create([
                    'folder' => $folder,
                    'filename' => $filename,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            \Log::info('Attachments stored in the local folder.');

            return ['folder' => $folder];
        }

        return response()->json(['error' => 'Attachments not uploaded'], 400);
    }

    public function revert(Request $request)
    {
        $folder = json_decode($request->getContent());

        $temporaryFile = TemporaryFile::where('folder', $folder->folder)->first();

        if ($temporaryFile) {
            Storage::delete("uploads/tmp/{$temporaryFile->folder}/{$temporaryFile->filename}");
            Storage::deleteDirectory("uploads/tmp/{$temporaryFile->folder}");
            $temporaryFile->delete();

            \Log::info('Attachments reverted in the local folder.');

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
