<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    // Tambahkan ini karena nama tabel Anda tidak menggunakan standar plural (s)
    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'type',
        'description',
        'price_per_day',
        'stock',
        'image', // Tambahkan image ke fillable
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
