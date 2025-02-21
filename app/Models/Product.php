<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\Brand;
use App\Models\Variant;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name",
        "code",
        "type",
        "barcode_symbology",
        "brand_id",
        "category_id",
        "unit_id",
        "purchase_unit_id",
        "sale_unit_id",
        "cost",
        "price",
        "qty",
        "alert_quantity",
        "daily_sale_objective",
        "promotion",
        "promotion_price",
        "starting_date",
        "last_date",
        "tax_id",
        "tax_method",
        "model",
        "origin",
        "image",
        "file",
        "is_embeded",
        "is_batch",
        "is_variant",
        "is_diffPrice",
        "is_imei",
        "featured",
        "product_list",
        "variant_list",
        "qty_list",
        "price_list",
        "product_details",
        "variant_option",
        "variant_value",
        "is_active",
        "is_sync_disable",
        "woocommerce_product_id",
        "woocommerce_media_id"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function variant()
    {
        return $this->belongsToMany(Variant::class, 'product_variants')->withPivot('id', 'item_code', 'additional_cost', 'additional_price');
    }

    public function scopeActiveStandard($query)
    {
        return $query->where([
            ['is_active', true],
            ['type', 'standard']
        ]);
    }

    public function scopeActiveFeatured($query)
    {
        return $query->where([
            ['is_active', true],
            ['featured', 1]
        ]);
    }
}
