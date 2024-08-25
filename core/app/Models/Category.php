<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GlobalStatus;
use App\Traits\Searchable;

class Category extends Model
{
    use HasFactory, GlobalStatus, Searchable;

    protected $fillable = [
        'name',
        'api_id',
        'api_provider_id',
        'status',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function apiProvider(){
        return $this->belongsTo(ApiProvider::class, 'api_provider_id', 'id');
    }  
    
}
