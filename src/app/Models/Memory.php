<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    //子ども別の思い出を抽出
    public static function childFilter($child_id)
    {
        $memories = self::query()
            ->whereHas('children', function($query) use($child_id){$query->where('memory_child.child_id', $child_id);})
            ->orderBy('created_at','desc');

        return $memories;
    }

    //年月別の思い出を抽出
    public static function monthFilter($month_year)
    {
        $arr_month_year = explode("-", $month_year);
        $year = $arr_month_year[0];
        $month = $arr_month_year[1];

        $memories = self::query()
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month )
            ->orderBy('created_at','desc');

        return $memories;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function comments():HasMany
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function children():BelongsToMany
    {
        return $this->BelongsToMany('App\Models\Child', 'memory_child')->withTimestamps();
    }

    public function family():BelongsTo
    {
        return $this->BelongsTo('App\Models\Family');
    }

}
