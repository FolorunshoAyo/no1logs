<?php

namespace App\Models;

use App\Traits\Searchable;
use App\Traits\UserNotify;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiProvider extends Model
{
    use Searchable, GlobalStatus, UserNotify, HasFactory;

    protected $table = 'api_providers';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $fillable = [
        'type',
        'domain',
        'username',
        'password',
        'token',
        'base_currency',
        'balance',
        'status',
        'auto_rename_api',
        'ck_connect_api',
        'status_update_ck',
    ];

    protected $casts = [
        'status' => 'integer',
        'auto_rename_api' => 'integer',
        'ck_connect_api' => 'float',
        'status_update_ck' => 'integer',
    ];

    public function categories(){
        return $this->hasMany(Category::class, 'api_provider_id', 'id');
    }

    public function products(){
        return $this->hasMany(Product::class, 'api_provider_id', 'id');
    }

    public function trxHistory(){
        return $this->hasMany(WalletHistory::class, 'api_provider_id', 'id');
    }
}
