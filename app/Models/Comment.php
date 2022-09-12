<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function newIdeaStatus()
    {
        return $this->belongsTo(Status::class);
    }

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }
}
