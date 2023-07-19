<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
	protected $table = 'product_category';

  protected $fillable = [
      'product_id','category','is_active','is_deleted'
  ];

  public function product()
  {
    return $this->belongsTo('App\Product');
  }
}
