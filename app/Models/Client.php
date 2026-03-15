<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'name',
        'address',
        'phone',
        'keyword_count',
        'remaining_keywords',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function setPasswordAttribute($value): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $this->attributes['password'] = Crypt::encryptString($value);
    }

    public function getPasswordAttribute($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Throwable $e) {
            return $value;
        }
    }

    public function quotas(): HasMany
    {
        return $this->hasMany(Quota::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
