<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Note
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Note newModelQuery()
 * @method static Builder|Note newQuery()
 * @method static Builder|Note query()
 * @method static Builder|Note whereContent($value)
 * @method static Builder|Note whereCreatedAt($value)
 * @method static Builder|Note whereId($value)
 * @method static Builder|Note whereTitle($value)
 * @method static Builder|Note whereUpdatedAt($value)
 * @method static Builder|Note whereUserId($value)
 * @mixin Eloquent
 */
class Note extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];
}
