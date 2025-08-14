<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppModelResource;
use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class AppModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AppModelResource::collection(AppModel::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:4096', // Allow larger images for photoshoots
        ]);

        $file = $request->file('image');
        $path = $file->store('models', 'public');

        // Get image dimensions
        [$width, $height] = getimagesize(storage_path('app/public/' . $path));

        $model = AppModel::create([
            'image' => $path,
            'width' => $width,
            'height' => $height,
        ]);

        return new AppModelResource($model);
    }

    /**
     * Display the specified resource.
     */
    public function show(AppModel $appModel)
    {
        return new AppModelResource($appModel);
    }


    /**
     * Update is not very common for images, but could be used to update alt text
     * or other metadata in the future. For now, it's empty.
     * The common pattern is to delete and re-upload.
     */
    public function update(Request $request, AppModel $appModel)
    {
        // Future logic for updating metadata could go here.
        return response()->json(['message' => 'Not implemented'], 501);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppModel $appModel)
    {
        // The model_product pivot table records are deleted automatically
        // due to the onDelete('cascade') constraint.

        // Check if image exists in storage before attempting to delete
        if ($appModel->image && Storage::disk('public')->exists($appModel->image)) {
            Storage::disk('public')->delete($appModel->image);
        }

        $appModel->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
