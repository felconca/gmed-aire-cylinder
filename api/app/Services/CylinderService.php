<?php

namespace App\Services;

class CylinderService
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Check if a cylinder serial already exists.
     * 
     * @param string $serial The serial number to check.
     * @return bool True if serial exists, false otherwise.
     */
    /**
     * Check if a cylinder serial already exists. Optionally exclude a specific cylinder id (for updates).
     * 
     * @param string $serial The serial number to check.
     * @param int|null $excludeId Optional ID to exclude from the check (for updates).
     * @return bool True if serial exists, false otherwise.
     */
    public function serialExists($serial, $excludeId = null)
    {
        $query = $this->conn->gmedaire()
            ->SELECT('id', 'cylinders')
            ->WHERE(['serial_no' => $serial, 'deleted' => 0]);
        if ($excludeId !== null) {
            $query->WHERE("id != $excludeId");
        }
        $item = $query->first();

        return $item ? true : false;
    }

    /**
     * Check if a cylinder barcode already exists. Optionally exclude a specific cylinder id (for updates).
     * 
     * @param string $barcode The barcode to check.
     * @param int|null $excludeId Optional ID to exclude from the check (for updates).
     * @return bool True if barcode exists, false otherwise.
     */
    public function barcodeExists($barcode, $excludeId = null)
    {
        $query = $this->conn->gmedaire()
            ->SELECT('id', 'cylinders')
            ->WHERE(['barcode' => $barcode, 'deleted' => 0]);
        if ($excludeId !== null) {
            $query->WHERE("id != $excludeId");
        }
        $item = $query->first();

        return $item ? true : false;
    }

    /**
     * Change the status of a cylinder.
     *
     * @param int $id The cylinder ID.
     * @param string $status The new status ('available', 'in used', etc).
     * @return int|false Number of affected rows, or false on failure.
     */
    public function changeStatus($id, $status = 'available')
    {
        try {
            return $this->conn
                ->gmedaire()
                ->UPDATE('cylinders', ['status' => $status])
                ->WHERE(['id' => $id]);
        } catch (\Exception $e) {
            // Optional: log error if logger exists
            return false;
        }
    }

    /**
     * Insert a log entry into the cylinder_logs table.
     *
     * @param int $cylinderId The ID of the cylinder.
     * @param string $actions The action performed.
     * @param string $descriptions The description of the action.
     * @param int $userId The user ID who performed the action.
     * @return bool True if log inserted successfully, false otherwise.
     */
    public function insertLog($cylinderId, $actions, $descriptions, $userId)
    {
        try {
            $qb = $this->conn->gmedaire();
            $insert = $qb->INSERT('cylinder_logs', [
                'cylinder_id'  => $cylinderId,
                'actions'      => $actions,
                'descriptions' => $descriptions,
                'created_by'      => $userId,
            ]);
            return $insert ? true : false;
        } catch (\Exception $e) {
            // Optional: log error if needed
            return false;
        }
    }
    /**
     * Update the items_total column in the specified delivery record
     * by counting the number of items in cylinder_delivery_items for that delivery.
     *
     * @param int $deliveryId The ID of the cylinder_delivery record.
     * @return bool True on success, false on failure.
     */
    public function updateItemsTotal($deliveryId)
    {
        try {
            // Create TWO separate QB instances: one for select, one for update!
            $selectQb = $this->conn->gmedaire();
            $countRes = $selectQb
                ->SELECT('COUNT(*) AS total', 'cylinder_delivery_items')
                ->WHERE(['delivery_id' => $deliveryId])
                ->first();

            if ($countRes) {
                $total = $countRes->total;
                $updateQb = $this->conn->gmedaire();
                return $updateQb
                    ->UPDATE('cylinder_delivery', ['items_total' => $total])
                    ->WHERE(['id' => $deliveryId]);
            }
        } catch (\Exception $e) {
            // Optional: log error if necessary
            return $e;
        }
    }
}
