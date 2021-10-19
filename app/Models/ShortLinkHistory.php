<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortLinkHistory extends Model
{
    protected $table = "short_links_history";
    protected $fillable = ['code_id', 'ip_address'];
}
