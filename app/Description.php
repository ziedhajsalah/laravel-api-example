<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
   public function product ()
   {
   		return $this->belongsTo(Product::class);
   }

   public function scopeOfproduct($query, $productId)
   {
        return $query->where('product_id', $productId);
   }
}
