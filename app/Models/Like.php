<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }
    // protected $fillable = ['like_type', 'user_id', 'idea_id'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
