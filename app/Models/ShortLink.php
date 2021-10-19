<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class ShortLink extends Model
{
    protected $fillable = ['code', 'link'];

    public function history()
    {
        return $this->hasMany(ShortLinkHistory::class,'code_id','id');
    }

    public static function forgetCaches($prefix)
    {
        // Increase loop if you need, the loop will stop when key not found
        for ($i=1; $i < 1000; $i++) {
            $key = $prefix . $i;
            if (Cache::has($key)) {
                Cache::forget($key);
            } else {
                break;
            }
        }
    }

}
