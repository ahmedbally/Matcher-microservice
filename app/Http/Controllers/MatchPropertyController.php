<?php

namespace App\Http\Controllers;

use App\Http\Resources\SearchProfileResource;
use App\Models\Property;
use App\Models\SearchProfile;
use App\Services\ScoreService;
use Illuminate\Http\Request;

class MatchPropertyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Property $property, Request $request)
    {
        $property->load('propertyFields');
        $searchProfiles = SearchProfile::filter($property)
            ->get()
            ->map(function ($searchProfile) use ($property) {
                return (new ScoreService($property, $searchProfile))->handle();
            })->sortByDesc(function ($searchProfile) {
                return $searchProfile->score;
            });

        return SearchProfileResource::collection($searchProfiles)->response();
    }
}
