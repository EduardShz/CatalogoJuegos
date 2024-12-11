<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'published_year',
        'rating',
        'creator_id',
        'platform_id',
        'genre_id',
    ];

    public function creators()
    {
        return $this->belongsToMany(Creator::class);
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
