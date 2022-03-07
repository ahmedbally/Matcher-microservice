<?php

namespace App\Models;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Property
 *
 * @property string $id
 * @property string $name
 * @property string $address
 * @property float|null $area
 * @property int|null $year_of_construction
 * @property int|null $rooms
 * @property string|null $heating_type
 * @property bool|null $parking
 * @property float|null $return_actual
 * @property float|null $price
 * @property string $type_id
 * @property-read \App\Models\PropertyType $type
 * @method static \Database\Factories\PropertyFactory factory(...$parameters)
 * @method static Builder|Property filter(\App\Models\SearchProfile $searchProfile)
 * @method static Builder|Property newModelQuery()
 * @method static Builder|Property newQuery()
 * @method static Builder|Property query()
 * @method static Builder|Property whereAddress($value)
 * @method static Builder|Property whereArea($value)
 * @method static Builder|Property whereHeatingType($value)
 * @method static Builder|Property whereId($value)
 * @method static Builder|Property whereName($value)
 * @method static Builder|Property whereParking($value)
 * @method static Builder|Property wherePrice($value)
 * @method static Builder|Property whereReturnActual($value)
 * @method static Builder|Property whereRooms($value)
 * @method static Builder|Property whereTypeId($value)
 * @method static Builder|Property whereYearOfConstruction($value)
 * @mixin \Eloquent
 * @property mixed $fields
 * @method static Builder|Property whereFields($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PropertyField[] $propertyFields
 * @property-read int|null $property_fields_count
 * @property-read \App\Models\PropertyType|null $propertyType
 * @property string $property_type_id
 * @method static Builder|Property wherePropertyTypeId($value)
 */
class Property extends Model
{
    use HasFactory, Uuidable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'address',
    ];

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function propertyFields()
    {
        return $this->hasMany(PropertyField::class);
    }
}
