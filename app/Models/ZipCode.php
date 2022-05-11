<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['zip_code', 'locality', 'municipality_id', 'federal_entity_key'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'zip_code';

     /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;


    protected $hidden = ['municipality_id', 'federal_entity_key'];

    /**
     * Cast for locality
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function locality(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => mb_strtoupper($value),
        );
    }

    /**
     * Cast for locality
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function zipCode(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_pad($value, 5, "0", STR_PAD_LEFT),
        );
    }

    /**
     * Settlements of zip code
     *
     * @return HasMany
     */
    public function settlements()
    {
        return $this->hasMany(Settlement::class, 'zip_code', 'zip_code');
    }


    /**
     * Municipality of zip code
     *
     * @return BelongTo
     */
    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Federal entity of zip code
     *
     * @return void
     */
    public function federalEntity()
    {
        return $this->belongsTo(FederalEntity::class, 'federal_entity_key', 'key');
    }
}
