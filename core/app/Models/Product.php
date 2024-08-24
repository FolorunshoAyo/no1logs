<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory, GlobalStatus, Searchable;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'api_price',
        'image',
        'api_id',
        'api_provider_id',
        'api_stock',
        'name_api'
    ];

    protected $appends = ['in_stock'];
 
    public function category(){
        return $this->belongsTo(Category::class);
    } 

    public function user(){
        return $this->belongsTo(User::class);
    }  

    public function apiProvider(){
        return $this->belongsTo(ApiProvider::class, 'api_provider_id', 'id');
    }  
    
    public function productDetails(){
        return $this->hasMany(ProductDetail::class);
    }
    
    public function soldProductDetails(){
        return $this->hasMany(ProductDetail::class)->sold();
    }
    
    public function unsoldProductDetails(){
        return $this->hasMany(ProductDetail::class)->unsold();
    }
    
    public function inStock(): Attribute{
        return new Attribute(function(){
            return @$this->productDetails->where('is_sold', Status::NO)->count() ?? 0;
        });
    }
}
