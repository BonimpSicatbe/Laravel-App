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
            $attachments = $request->file('attachments');


            $folder = uniqid() . '_' . now()->timestamp;

//            dd($attachments, $folder);
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

//            \Log::info('');

            return response()->json(['folder' => $folder], 200);
        }

        return response()->json(['error' => 'Attachments not uploaded'], 400);
    }

    public function revert(Request $request)
    {
        $folder = $request->getContent();

        $temporaryFile = TemporaryFile::where('folder', $folder)->first();

        if ($temporaryFile) {
            Storage::delete("uploads/tmp/{$temporaryFile->folder}/{$temporaryFile->filename}");
            Storage::deleteDirectory("uploads/tmp/{$temporaryFile->folder}");
            $temporaryFile->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function restore(Request $request)
    {
        $folder = $request->get('folder');

        // Logic to restore the file using temporary folder details.
        // You may use TemporaryFile model to restore data if needed

        return response()->json(['fileId' => 'restored-file-id']);
    }

    public function load(Request $request)
    {
        $folder = $request->get('folder');

        // Logic to load the file information based on the temporary folder
        $file = TemporaryFile::where('folder', $folder)->first();

        if ($file) {
            return response()->json([
                'fileId' => $file->filename,
                'filePath' => Storage::url("uploads/tmp/{$folder}/{$file->filename}"),
            ]);
        }

        return response()->json(['error' => 'File not found'], 404);
    }

}
