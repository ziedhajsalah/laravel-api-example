<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
   public $fillable = ['product_id', 'body'];

   public function product ()
   {
   		return $this->belongsTo(Product::class);
   }

   public function scopeOfproduct($query, $productId)
   {
        return $query->where('product_id', $productId);
   }
}
