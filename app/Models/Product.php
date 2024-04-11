<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\App;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const MEDIA_COLLECTION_PHOTOS = 'product_photos';

    protected $fillable = [
        'name',
        'description',
        'price',
        'price_in_cents'
    ];

    protected $casts = [
        'price_in_cents' => 'int',
        'price' => 'float'
    ];

    public function getPriceAttribute(): float
    {
        return round($this->attributes['price_in_cents'] / 100, 2);
    }

    public function getFormattedPriceAttribute(): string
    {
        return (new \NumberFormatter(App::getLocale(), \NumberFormatter::CURRENCY))
            ->formatCurrency($this->price, strtoupper(config('app.currency', 'USD')));
    }

    public function defaultCollectionName(): string
    {
        return self::MEDIA_COLLECTION_PHOTOS;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection($this->defaultCollectionName())
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')->width(254);
            });

        $this->addMediaCollection(self::MEDIA_COLLECTION_PHOTOS)
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')->width(254);
            });
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Media::class, 'model')
            ->where('collection_name', $this->defaultCollectionName())
            ->orderBy('order_column');
    }
}
