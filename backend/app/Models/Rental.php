<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $equipment_id
 * @property string $rent_date
 * @property string $return_date
 * @property string|null $actual_return_date
 * @property float $total_price
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Equipment $equipment
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereActualReturnDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereEquipmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereRentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereReturnDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rental whereUserId($value)
 * @mixin \Eloquent
 */
class Rental extends Model
{
    protected $fillable = [
        'user_id',
        'equipment_id',
        'rent_date',
        'return_date',
        'actual_return_date',
        'total_price',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
