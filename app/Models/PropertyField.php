<?php

namespace App\Models;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PropertyField
 *
 * @property string $field_id
 * @property string $property_id
 * @property string|null $value
 * @property-read \App\Models\Property|null $property
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyField query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyField whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyField wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyField whereValue($value)
 * @mixin \Eloquent
 * @property string $id
 * @property string $name
 * @method static \Database\Factories\PropertyFieldFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyField whereName($value)
 */
class PropertyField extends Model
{
    use HasFactory, Uuidable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'value',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
