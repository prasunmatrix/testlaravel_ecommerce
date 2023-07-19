<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
      'category_name','category_slug','category_photo','is_active','is_deleted'
    ]; 
}
