<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageUploader
{
    protected string $folder = 'images';

    /**
     * رفع صورة واحدة
     *
     * @param UploadedFile|string|null $image
     * @return string|null
     */
    public function upload(UploadedFile|string|null $image): ?string
    {
        if ($image instanceof UploadedFile) {
            // يرفع الصورة داخل storage/app/public/<folder>
            return $image->store($this->folder, 'public');
        }

        // إذا الصورة نص (رابط أو مسار موجود) يرجعها كما هي
        return $image ?: null;
    }

    /**
     * رفع عدة صور
     *
     * @param array $images
     * @return array
     */
    public function uploadMany(array $images): array
    {
        $result = [];

        foreach ($images as $image) {
            $result[] = $this->upload($image);
        }

        return $result;
    }

    /**
     * الحصول على رابط كامل للصورة
     *
     * @param string|null $path
     * @return string|null
     */
    public function getUrl(?string $imagePath): ?string
    {
        if ($imagePath) {
            return asset('storage/' . $imagePath);
        }

        return null;
    }

    /**
     * الحصول على رابط المنتج (يدعم http و https)
     *
     * @param string|null $imagePath
     * @return string|null
     */
    public function getProductUrl(?string $imagePath): ?string
    {
        if (!$imagePath) {
            return null;
        }

        // إذا الـ path يبدأ بـ http → رجعه زي ما هو
        if (Str::startsWith($imagePath, ['http://', 'https://'])) {
            return $imagePath;
        }

        // غير كده، اعتبره path نسبي وخليه asset
        return asset('storage/' . ltrim($imagePath, '/'));
    }
}
