<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Memory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'family_id',
        'body',
        'image_path',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function comment():HasMany
    {
        return $this->hasMany('App\Models\Comment');
    }
}
