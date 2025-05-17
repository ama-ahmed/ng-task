<?php

namespace Modules\Product\Models;

use core\Models\BaseModel;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\LogOptions;
use Modules\Category\Models\Category;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BaseModel
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'description', 'price', 'category_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function registerMediaCollection(array $collections): void
    {
        try {
            foreach ($collections as $collectionName) {
                $this->addMediaFromRequest($collectionName)->toMediaCollection('image');
            }
        } catch (\Exception $e) {
            Log::error('Error registering media collection: ' . $e->getMessage(), request()->all());
        }
    }

    public function getFirstMediaUrl(string $collectionName = 'image', string $conversionName = ''): string
    {
        $getMedia = $this->getMedia($collectionName)->first()?->getUrl();
        if ($getMedia) {
            return $getMedia;
        }

        return '';
    }
}
