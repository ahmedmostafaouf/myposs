<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements TranslatableContract
{
    use Translatable;
    public $guarded = [];
    public $translatedAttributes = ['name','description'];
    protected $appends=['purchase_price'];
    public function getProfitPercentAttribute(){
        $profit=$this->sale_price - $this->purchase_price;
        $profit_percent=$profit * 100 /$this->purchase_price;
        return number_format($profit_percent,2);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function orders(){
        return $this->belongsToMany(Order::class,'product_order');
    }
}
