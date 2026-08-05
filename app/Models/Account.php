<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    protected $fillable = [
        'user_id',
        'account_number',
        'account_type',
        'balance',
        'status',
        'pin',
    ];

    protected $hidden = [
        'pin',
    ];

    public $timestamps = true;

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function getAcnoAttribute(): ?string
    {
        return $this->attributes['account_number'] ?? null;
    }

    public function setAcnoAttribute($value): void
    {
        $this->attributes['account_number'] = $value;
    }

    public function getTypeAttribute(): ?string
    {
        return $this->attributes['account_type'] ?? null;
    }

    public function setTypeAttribute($value): void
    {
        $this->attributes['account_type'] = $value;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
