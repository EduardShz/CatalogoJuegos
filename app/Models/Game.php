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

    public function creator()
    {
        return $this->belongsTo(Creator::class);
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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relación con los likes
    public function likes()
    {
        return $this->hasMany(GameUser::class);
    }

    // Verificar si un usuario específico le ha dado like al juego
    public function likedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
