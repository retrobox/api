<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Game extends Model
{
	protected $table = 'games';

	protected $keyType = 'string';

	public $incrementing = false;

	protected $dates = ['released_at'];

	public function platform()
	{
		return $this->belongsTo(GamePlatform::class);
	}

	public function editor()
	{
		return $this->belongsTo(GameEditor::class);
	}

    public function medias(): HasMany
    {
        return $this->hasMany(GameMedia::class, 'game_id', 'id');
    }

	public function tags(): BelongsToMany
	{
		return $this->belongsToMany(GameTag::class,'game_tags_games', 'tag_id', 'game_id', 'id', 'id', GameTag::class);
	}
}