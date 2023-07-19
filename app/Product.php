<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $table = 'products';

  protected $fillable = [
    'is_popular','sku_code','product_name','product_slug','feature_image','product_stock','short_desc','long_desc','aditional_info','usd_price','usd_offer_price','meta_title','meta_keywords','meta_description','is_active','is_deleted'
  ];

  public function productcategory()
	{
	  return $this->hasMany('App\ProductCategory');
	}
}
