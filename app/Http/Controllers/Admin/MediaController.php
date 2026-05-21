<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function upload(Request $request, $modelClass, $id)
    {
        $request->validate([
            'file' => 'required|file|max:10240'
        ]);

        $model = $modelClass::findOrFail($id);

        $media = $model
            ->addMedia($request->file('file'))
            ->toMediaCollection($request->collection);

        return response()->json([
            'message' => 'File uploaded',
            'media' => $media
        ]);
    }

    public function delete($mediaId)
    {
        $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::findOrFail($mediaId);
        $media->delete();

        return response()->json(['message'=>'File deleted']);
    }
}
