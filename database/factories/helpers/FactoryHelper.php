<?php

class FactoryHelper
{
    /**
     * @param string $model
     * This function will get random ID from a database model
     */
    public static function getRandomModelId(string $model)
    {
        // Get model count
        $count = $model::query()->count();

        if($count === 0) {
            // Create a new record and retrieve record id
            $id = $model::factory()->create->id;
        } else {
            // Generate random Id between 1 and count
            $id = rand(1, $count);
        }
        return $id;
    }
}