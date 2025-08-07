<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image'];
    protected $appends = ['image_url','is_default_img'];
    public function getImageUrlAttribute() {
        if($this->image == ''){
            return "";
        }
        return asset('/uploads/products/small/'.$this->image);
    }

    public function getIsDefaultImgAttribute() {
        return $this->image === optional($this->product)->image;
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
