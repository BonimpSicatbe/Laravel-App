<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Attachment $attachment)
    {
        $filePath = storage_path("app/{$attachment->file_path}");

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->file($filePath);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attachment $attachment)
    {
        $filePath = storage_path($attachment->file_path);

        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file from the filesystem
        }

        $attachment->delete(); // Remove the record from the database

        return back()->with('success', 'Attachment deleted successfully.');
    }

    public function downloadAttachment(Attachment $attachment)
    {
        $filePath = $attachment->file_path;

        if (Storage::exists($filePath)) {
            return Storage::download($filePath, $attachment->file_name);
        }

        return back()->with('error', 'File not found.');
    }

}
