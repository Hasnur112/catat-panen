<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Panen extends Model
{
    protected $table = 'panen';

    protected $fillable = [
        'user_id',
        'jenis_padi',
        'volume',
        'tanggal',
        'keterangan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'volume'  => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
