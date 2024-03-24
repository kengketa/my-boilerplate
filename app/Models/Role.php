<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Role extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const MEDIA_COLLECTION_IMAGE = 'image';
    protected $fillable = ['name'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_IMAGE)->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('optimized')
                    ->fit(Manipulations::FIT_MAX, 800, 800)
                    ->optimize()
                    ->keepOriginalImageFormat();
            });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
