<?php

namespace App\Models;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Type
 *
 * @property string $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyType query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyType whereName($value)
 * @mixin \Eloquent
 */
class PropertyType extends Model
{
    use HasFactory, Uuidable;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
