<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Area()
 * @method static static YearOfConstruction()
 * @method static static Rooms()
 * @method static static HeatingType()
 * @method static static Parking()
 * @method static static ReturnActual()
 * @method static static Price()
 */
final class SearchProfileFieldName extends Enum
{
    const Area = 'area';

    const YearOfConstruction = 'year_of_construction';

    const Rooms = 'rooms';

    const HeatingType = 'heating_type';

    const Parking = 'parking';

    const ReturnActual = 'return_actual';

    const ReturnPotential = 'return_potential';

    const Price = 'price';
}
