<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Status extends Model
{
    use HasFactory;

    public static function default()
    {
        return self::where('name', '=', 'open')->first();
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }
}
