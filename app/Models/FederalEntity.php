<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalEntity extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['key', 'name', 'code'];


    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'federal_entity_key', 'key');
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
