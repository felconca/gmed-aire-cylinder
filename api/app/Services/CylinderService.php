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
    public function serialExists($serial)
    {
        $item = $this->conn->gmedaire()
            ->SELECT('id', 'cylinders')
            ->WHERE(['serial_no' => $serial, 'deleted' => 0])
            ->first();

        return $item ? true : false;
    }

    /**
     * Check if a cylinder barcode already exists.
     * 
     * @param string $barcode The barcode to check.
     * @return bool True if barcode exists, false otherwise.
     */
    public function barcodeExists($barcode)
    {
        $item = $this->conn->gmedaire()
            ->SELECT('id', 'cylinders')
            ->WHERE(['barcode' => $barcode, 'deleted' => 0])
            ->first();

        return $item ? true : false;
    }
}
