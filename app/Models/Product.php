<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ["name", "sku", "description", "specifications", "freebie", "price", "discount_price", "stock", "category_id", "brand_id", "is_promotion", "is_popular", "installment_details"];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = self::generateUniqueCode();
            }
        });
    }

    private static function generateUniqueCode()
    {
        do {
            $code = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(10));
        } while (self::where('id', $code)->exists());
        return $code;
    }

    public static function generateSku($brandId = null, $categoryId = null)
    {
        $prefix = 'DD';
        if ($brandId) {
            $brand = Brand::find($brandId);
            if ($brand && !empty($brand->name)) {
                $clean = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $brand->name));
                $prefix = substr($clean, 0, 3) ?: 'DD';
            }
        }
        
        $catCode = 'IT';
        if ($categoryId) {
            $category = Category::find($categoryId);
            if ($category && !empty($category->name)) {
                $cleanCat = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $category->name));
                $catCode = substr($cleanCat, 0, 3) ?: 'IT';
            }
        }

        $year = date('Y');
        
        do {
            $random = strtoupper(\Illuminate\Support\Str::random(5));
            $sku = "{$prefix}-{$catCode}-{$year}-{$random}";
        } while (self::where('sku', $sku)->exists());

        return $sku;
    }

    public function getPrimaryImageUrlAttribute()
    {
        $primary = $this->images->first(function($img) {
            return (bool)$img->is_primary;
        }) ?? $this->images->first();

        if ($primary && !empty($primary->image_path)) {
            if (\Illuminate\Support\Str::startsWith($primary->image_path, 'http')) {
                return $primary->image_path;
            }
            $clean = ltrim(str_replace(['public/', 'storage/', 'media/'], '', $primary->image_path), '/');
            return '/media/' . $clean;
        }
        return null;
    }

    public function getEffectivePriceAttribute()
    {
        if (!empty($this->discount_price) && (float)$this->discount_price > 0) {
            return (float)$this->discount_price;
        }
        if (!empty($this->price) && (float)$this->price > 0) {
            return (float)$this->price;
        }
        return 0.0;
    }

    public function category() { return $this->belongsTo(Category::class); }
    public function brand() { return $this->belongsTo(Brand::class); }
    public function images() { return $this->hasMany(ProductImage::class); }
    public function reviews() { return $this->hasMany(Review::class); }

}
