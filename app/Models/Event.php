<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'items' => 'array',
        'date' => 'datetime'
    ];

    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }

    /**
     * Mutator: normalize items array when setting.
     */
    public function setItemsAttribute($value)
    {
        if (!is_array($value)) {
            $value = [];
        }

        $normalized = [];
        $seen = [];

        foreach ($value as $item) {
            // trim and collapse multiple spaces
            $s = trim(preg_replace('/\s+/', ' ', (string) $item));
            if ($s === '') {
                continue;
            }
            // normalize case to Title Case using multibyte-safe functions
            $s = mb_convert_case(mb_strtolower($s, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
            $key = mb_strtolower($s, 'UTF-8');
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $normalized[] = $s;
            }
        }

        $this->attributes['items'] = json_encode(array_values($normalized));
    }
}
