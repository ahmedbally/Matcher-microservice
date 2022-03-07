<?php

namespace App\Services;

use App\Enums\SearchProfileFieldType;
use App\Models\Property;
use App\Models\SearchProfile;

class ScoreService
{
    private Property $property;

    public SearchProfile $searchProfile;

    public function __construct(Property $property, SearchProfile $searchProfile)
    {
        $this->property = $property;
        $this->searchProfile = $searchProfile;
    }

    public function handle()
    {
        $looseMatch = 0;
        $strictMatch = 0;
        $propertyFields = $this->property->propertyFields->filter(function ($item) {
            return ! is_null($item->value);
        });
        $searchProfileFields = $this->searchProfile->searchProfileFields->filter(function ($item) {
            return ! is_null($item->value) || ! is_null($item->max_value);
        });
        foreach ($propertyFields as $propertyField) {
            $field = $searchProfileFields->where('name', $propertyField->name)->first();
            if ($field->type == SearchProfileFieldType::Range) {
                if (isset($field->value) && isset($field->max_value)) {
                    $minDeviated = $field->value - ($field->value * .25);
                    $maxDeviated = $field->max_value + ($field->max_value * .25);
                    if ($field->value <= $propertyField->value && $field->max_value >= $propertyField->value) {
                        $strictMatch++;
                    } elseif ($minDeviated <= $propertyField->value && $maxDeviated >= $propertyField->value) {
                        $looseMatch++;
                    }
                } elseif (isset($field->value) && ! isset($field->max_value)) {
                    $minDeviated = $field->value - ($field->value * .25);
                    if ($field->value <= $propertyField->value) {
                        $strictMatch++;
                    } elseif ($minDeviated <= $propertyField->value) {
                        $looseMatch++;
                    }
                } elseif (! isset($field->value) && isset($field->max_value)) {
                    $maxDeviated = $field->max_value + ($field->max_value * .25);
                    if ($field->max_value >= $propertyField->value) {
                        $strictMatch++;
                    } elseif ($maxDeviated >= $propertyField->value) {
                        $looseMatch++;
                    }
                }
            } else {
                if ($field->value == $propertyField->value) {
                    $strictMatch++;
                }
            }
        }
        $this->searchProfile->strict_match = $strictMatch;
        $this->searchProfile->loose_match = $looseMatch;
        $this->searchProfile->score = ($strictMatch * 10) + $looseMatch;

        return $this->searchProfile;
    }
}
