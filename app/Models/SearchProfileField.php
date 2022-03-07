<?php

namespace App\Models;

use App\Enums\SearchProfileFieldType;
use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SearchProfileField
 *
 * @property string $field_id
 * @property string $property_id
 * @property mixed $type
 * @property string|null $value
 * @property string|null $min_value
 * @property string|null $max_value
 * @property-read \App\Models\Property|null $property
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfileField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfileField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfileField query()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfileField whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfileField whereMaxValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfileField whereMinValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfileField wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfileField whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfileField whereValue($value)
 * @mixin \Eloquent
 * @property string $id
 * @property string $name
 * @property string $search_profile_id
 * @method static \Database\Factories\SearchProfileFieldFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfileField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfileField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfileField whereSearchProfileId($value)
 */
class SearchProfileField extends Model
{
    use HasFactory, Uuidable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'value',
        'max_value',
    ];

    protected $casts = [
        'type' => SearchProfileFieldType::class,
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
