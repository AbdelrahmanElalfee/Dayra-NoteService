<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'id',
        'name'
    ];

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }
}
