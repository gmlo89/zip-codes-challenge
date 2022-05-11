<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['key', 'zone_type', 'zip_code', 'settlement_type_id', 'name'];

    protected $hidden = ['id', 'zip_code', 'settlement_type_id'];

    /**
     * Cast for name
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }


    /**
     * Cast for zone_type
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function zoneType(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }

    /**
     * Settlement type
     *
     * @return BelongTo
     */
    public function settlementType()
    {
        return $this->belongsTo(SettlementType::class);
    }
}
