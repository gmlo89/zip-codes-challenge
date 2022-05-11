<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['key', 'name', 'federal_entity_key'];

    protected $hidden = ['id', 'federal_entity_key', 'federal_entity'];


    public function zipcodes()
    {
        return $this->hasMany(ZipCode::class);
    }

    public function federalEntity()
    {
        return $this->belongsTo(FederalEntity::class, 'federal_entity_key', 'key');
    }


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

}
