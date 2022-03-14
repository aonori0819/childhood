<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function children():HasMany
    {
        return $this->HasMany('App\Models\Child');
    }

    public function user_details():HasMany
    {
        return $this->HasMany('App\Models\UserDetail');
    }
}
