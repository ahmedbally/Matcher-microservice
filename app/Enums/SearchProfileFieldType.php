<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Direct()
 * @method static static Range()
 */
final class SearchProfileFieldType extends Enum
{
    const Direct = 'direct';

    const Range = 'range';
}
