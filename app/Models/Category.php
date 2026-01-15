<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
    ];

    /**
     * Relasi ke tabel transactions.
     * Satu kategori memiliki banyak transaksi.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}