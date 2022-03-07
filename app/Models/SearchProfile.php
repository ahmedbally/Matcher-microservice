<?php

namespace App\Models;

use App\Enums\SearchProfileFieldType;
use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Kirschbaum\PowerJoins\PowerJoinClause;
use Kirschbaum\PowerJoins\PowerJoins;

/**
 * App\Models\SearchProfile
 *
 * @property string $id
 * @property string $name
 * @property mixed $fields
 * @property string $type_id
 * @property-read \App\Models\PropertyType $type
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfile whereFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchProfile whereTypeId($value)
 * @mixin \Eloquent
 * @method static Builder|SearchProfile filter(\App\Models\Property $property)
 * @method static \Database\Factories\SearchProfileFactory factory(...$parameters)
 * @property string $property_type_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SearchProfileField[] $searchProfileFields
 * @property-read int|null $search_profile_fields_count
 * @method static Builder|SearchProfile wherePropertyTypeId($value)
 */
class SearchProfile extends Model
{
    use HasFactory, Uuidable, PowerJoins;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function type()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function searchProfileFields()
    {
        return $this->hasMany(SearchProfileField::class);
    }

    public function scopeFilter(Builder $builder, Property $property)
    {
        $property->loadMissing('propertyFields');
        $propertyFields = $property->propertyFields->filter(function ($item) {
            return ! is_null($item->value);
        });

        $builder->where('property_type_id', $property->property_type_id);
        $builder->powerJoinWhereHas('searchProfileFields', function (PowerJoinClause $builder) use ($propertyFields) {
            $builder->where(function (QueryBuilder $builder) use ($propertyFields) {
                foreach ($propertyFields as $propertyField) {
                    $builder->orWhere(function (QueryBuilder $builder) use ($propertyField) {
                        $builder->where('search_profile_fields.name', '=', $propertyField->name);
                        $builder->where(function (QueryBuilder $builder) use ($propertyField) {
                            $builder->where(function (QueryBuilder $builder) use ($propertyField) {
                                $builder->where('search_profile_fields.type', SearchProfileFieldType::Direct)
                                    ->where('search_profile_fields.value', $propertyField->value);
                            })
                                ->orWhere(function (QueryBuilder $builder) use ($propertyField) {
                                    $builder->where('search_profile_fields.type', '=', SearchProfileFieldType::Range)
                                        ->where(function (QueryBuilder $builder) use ($propertyField) {
                                            $builder->where(function (QueryBuilder $builder) use ($propertyField) {
                                                $builder->whereNotNull('search_profile_fields.value')
                                                    ->whereNotNull('search_profile_fields.max_value')
                                                    ->where(function (QueryBuilder $builder) use ($propertyField) {
                                                        $builder->where(function (QueryBuilder $builder) use ($propertyField) {
                                                            $builder->where('search_profile_fields.value', '<=', $propertyField->value)
                                                                ->where('search_profile_fields.max_value', '>=', $propertyField->value);
                                                        })
                                                            ->orWhere(function (QueryBuilder $builder) use ($propertyField) {
                                                                $builder->whereRaw('(search_profile_fields.value - (search_profile_fields.value * .25)) <= ?', [$propertyField->value])
                                                                    ->whereRaw('(search_profile_fields.max_value + (search_profile_fields.max_value * .25)) >= ?', [$propertyField->value]);
                                                            });
                                                    });
                                            })
                                                ->orWhere(function (QueryBuilder $builder) use ($propertyField) {
                                                    $builder->whereNotNull('search_profile_fields.value')
                                                        ->whereNull('search_profile_fields.max_value')
                                                        ->where(function (QueryBuilder $builder) use ($propertyField) {
                                                            $builder->where('search_profile_fields.value', '<=', $propertyField->value)
                                                                ->orWhereRaw('(search_profile_fields.value - (search_profile_fields.value * .25)) <= ?', [$propertyField->value]);
                                                        });
                                                })
                                                ->orWhere(function (QueryBuilder $builder) use ($propertyField) {
                                                    $builder->whereNull('search_profile_fields.value')
                                                        ->whereNotNull('search_profile_fields.max_value')
                                                        ->where(function (QueryBuilder $builder) use ($propertyField) {
                                                            $builder->where('search_profile_fields.max_value', '>=', $propertyField->value)
                                                                ->orWhereRaw('(search_profile_fields.max_value + (search_profile_fields.max_value * .25)) >= ?', [$propertyField->value]);
                                                        });
                                                });
                                        });
                                });
                        });
                    });
                }
            });
        }, '=', count($propertyFields));
    }
}
