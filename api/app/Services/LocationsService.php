<?php

namespace App\Services;

class LocationsService
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    /**
     * Retrieves the ID of the default cylinder location.
     *
     * This function queries the 'cylinder_locations' table for the first record
     * where 'default_1' is set to 1 (meaning it is the default location) and 'deleted' is 0
     * (meaning it is not deleted). If such a location exists, its ID is returned.
     * If no default location is found, 0 is returned.
     *
     * @return int The ID of the default cylinder location, or 0 if none exists.
     */
    public function getDefault()
    {
        $item = $this->conn->gmedaire()
            ->SELECT('id', 'cylinder_locations')
            ->WHERE(['default_1' => 1, 'deleted' => 0])
            ->first();

        return $item ? $item->id : 0;
    }

    /**
     * Unset all previous default cylinder locations.
     *
     * This will set default_1 to 0 for all cylinder_locations where default_1 is 1
     * and deleted is 0, ensuring only one default exists at a time.
     */
    public function unsetAllDefaults()
    {
        // Select all IDs of current default locations that are not deleted
        $existingDefaults = $this->conn->gmedaire()
            ->SELECT(['id'], 'cylinder_locations')
            ->WHERE(['default_1' => 1, 'deleted' => 0])
            ->get();

        // If there are any, unset them and set $default_1 to 1
        if (!empty($existingDefaults)) {
            foreach ($existingDefaults as $def) {
                $this->conn
                    ->UPDATE('cylinder_locations', ['default_1' => 0])
                    ->WHERE(['id' => $def->id]);
            }
            return 1;
        }

        // Otherwise, no default was previously set, so return 1 to set as default
        return 1;
    }
}
