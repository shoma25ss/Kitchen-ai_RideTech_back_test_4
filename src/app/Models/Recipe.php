<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'description', 'genre',
        'cooking_time', 'calories', 'difficulty',
        'is_public', 'is_reviewed',
    ];

    protected $casts = [
        'is_public'   => 'boolean',
        'is_reviewed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class)->orderBy('sort_order');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(RecipeStep::class)->orderBy('step_number');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(CookingHistory::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(RecipeLike::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function chatLogs(): HasMany
    {
        return $this->hasMany(ChatLog::class);
    }
}
