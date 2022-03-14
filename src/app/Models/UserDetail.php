<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'family_id',
        'relation_to_child',
        'icon_path',
    ];

    public function user():BelongsTo
    {
        return $this->BelongsTo('App\Models\User');
    }

    public function family():BelongsTo
    {
        return $this->BelongsTo('App\Models\Family');
    }
}


