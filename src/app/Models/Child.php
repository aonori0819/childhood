<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'name',
        'icon_path',
        'birthday',
    ];

    public function family():BelongsTo
    {
        return $this->BelongsTo('App\Models\Family');
    }
    public function memories():BelongsToMany
    {
        return $this->BelongsToMany('App\Models\Memory','memory_child')->withTimestamps();
    }
}
