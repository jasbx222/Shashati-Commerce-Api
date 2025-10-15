<?php

namespace App\Http\Service\Admin\ads;

use App\Helpers\ImageUploader;
use App\Helpers\ImageUploaderAds;
use App\Http\Resources\Admin\ads\AdsResource;
use App\Models\Ads;

class AdsService
{
    // عرض قائمة الإعلانات مع دعم الـ pagination
    public function index()
    {
        $ads = Ads::with('product')->paginate(15);

        return response()->json([
            'ads' => AdsResource::collection($ads),
            'meta' => [
                'current_page' => $ads->currentPage(),
                'last_page' => $ads->lastPage(),
                'per_page' => $ads->perPage(),
                'total' => $ads->total(),
            ]
        ]);
    }

    // عرض إعلان واحد حسب الـ id
    public function show( $ad)
    {
        return new AdsResource($ad);
    }

 public function store(array $data)
{
    $uploader = new ImageUploader();

    if (isset($data['image'])) {
        $data['image'] = $uploader->upload($data['image']);
    }

    $ad = Ads::create($data);

    // لتحصل على رابط كامل للصورة قبل الإرجاع
    $ad->image = $uploader->getUrl($ad->image);

    return response()->json([
        'message' => 'Ad created successfully',
        'ad' => $ad
    ], 201);
}




  public function update(array $data, $ad)
{
   
    $uploader = new ImageUploader();
    if (isset($data['image']) && $data['image']) {
        $data['image'] = $uploader->upload($data['image']);
    } else {
        unset($data['image']);
    }
    $ad->update($data);
    return response()->json([
        'message' => 'Ad updated successfully',
        'ad' => $ad
    ], 200);
}






    // حذف إعلان
    public function destroy( $ad)
    {
        $ad->delete();
        return response()->json([
            'message' => 'ads deleted successfully'
        ], 200);
    }
}
