<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('attachments')) {
            $attachment = $request->file('attachments');
            $filename = $attachment->getClientOriginalName();
            $folder = uniqid() . '_' . now()->timestamp;
            $attachment->storeAs('attachments/tmp/' . $folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);

            return $folder;
        }
        return '';
    }

    public function revert(Request $request)
    {
        $folder = $request->getContent();
        $temporaryFile = TemporaryFile::where('folder', $folder)->first();


    }
}
