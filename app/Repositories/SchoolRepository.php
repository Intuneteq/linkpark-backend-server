<?php

namespace App\Repositories;

use App\Exceptions\CreateApiException;
use App\Models\School;

class SchoolRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        $school = School::query()->create([
            'name' => data_get($attributes, 'name'),
            'address' => data_get($attributes, 'address'),
            'city' => data_get($attributes, 'city'),
            'state' => data_get($attributes, 'state'),
            'country' => data_get($attributes, 'country'),
            'email' => data_get($attributes, 'email')
        ]);
        return $school;
    }

    public function update($school, array $attributes)
    {
        $updated = $school->update([
            'name' => data_get($attributes, 'name', $school->title),
            'address' => data_get($attributes, 'address', $school->address),
            'city' => data_get($attributes, 'city', $school->city),
            'state' => data_get($attributes, 'state', $school->state),
            'country' => data_get($attributes, 'country', $school->country),
            'email' => data_get($attributes, 'email', $school->email),
        ]);

        if (!$updated) {
            throw new CreateApiException('School not updated', 400);
        }
        return $school;
    }

    public function forceDelete($school)
    {
        $deleted = $school->forceDelete();

        if (!$deleted) {
            throw new CreateApiException('could not delete resource', 400);
        }

        return $deleted;
    }
}
