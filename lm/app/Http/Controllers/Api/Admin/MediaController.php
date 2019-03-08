<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Api\Admin\Media\UploadImageRequest;
use App\Http\Resources\Api\Admin\MediaResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller
{

    public function uploadImages(UploadImageRequest $request, $uuid, $type) {
        $modelName = 'App\Models\Client\\' . ucfirst(camel_case($request->assetType));

        $model = $modelName::getByUuid($uuid);

        if(!is_object($model)){
            return response('Entity not found', 404);
        }

        if(is_array($request->image)) {
            foreach ($request->image as $image) {
                $model->addMedia($image)->toMediaCollection($type);
            }
        } else {
            $model->addMedia($request->image)->toMediaCollection($type);
        }

        $model->save();


        return response('media.uploaded', 200);
    }

    public function getImagesByType(Request $request, $assetType, $uuid, $type) {

        $modelName = 'App\Models\Client\\' . ucfirst(camel_case($assetType));
        $model = $modelName::getByUuid($uuid);

        if(!is_object($model)){
            return response('Template not found', 404);
        }

        return MediaResource::collection($model->getMedia($type));
    }

    public function delete($id) {

        $media = Media::where('id', $id)->first();
        // to delete Media record in DB as well as file
        $media->model->deleteMedia($media->id);

        $media->model->save();

        return response('media.deleted', 200);

    }

    public function getByUuid($uuid) {
        $media = Media::where('uuid', $uuid)->first();

        return new MediaResource($media);
    }
}
