<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Idea extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ],
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function votes()
    {
        return $this->belongsToMany(User::class, 'votes');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votedBy(?User $user): bool
    {
        if (!isset($user)) {
            return false;
        }

        return Vote::where('user_id', $user->id)
            ->where('idea_id', $this->id)
            ->exists();
    }

    public function vote(?User $user): bool
    {
        if (!isset($user) || $this->votedBy($user)) {
            return false;
        }

        Vote::create([
            'idea_id' => $this->id,
            'user_id' => $user->id,
        ]);
        return true;
    }

    public function unvote(?User $user): bool
    {
        if (!isset($user)) {
            return false;
        }

        Vote::where('idea_id', $this->id)
            ->where('user_id', $user->id)
            ->delete();
        return true;
    }

    public static function getCountsByStatuses(): array
    {
        $ideasCountByStatus = DB::table('statuses')
            ->selectRaw('statuses.name AS status_name')
            ->selectRaw('COUNT(ideas.id) AS count')
            ->leftJoin('ideas', 'ideas.status_id', '=', 'statuses.id')
            ->groupBy('statuses.name')
            ->get()
            ->pluck('count', 'status_name');

        $ideasCountByStatus['all'] = $ideasCountByStatus->reduce(
            fn ($totalCount, $statusCount) => $totalCount + $statusCount,
            initial: 0,
        );

        return $ideasCountByStatus->toArray();
    }
}
