<?php

namespace App\Controllers;

use App\Services\CylinderService;
use App\Services\LocationsService;
use Includes\Rest;
use Core\Database\Database;

class CylindersController extends Rest
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Manila');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
        header("Access-Control-Allow-Credentials: true");

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        parent::__construct();

        $this->db = new Database();
    }

    public function index($request, $response, $params)
    {
        try {
            // Collect and validate all input filter parameters with defaults (add location, types, category)
            $input = $request->validate([
                "customer_id"   => "required|number",
                "status"        => "string",
                "location"      => "number",
                "types"         => "number",
                "category"      => "number",
                "expiry_from"   => "string",
                "expiry_to"     => "string",
                "manu_from"     => "string",
                "manu_to"       => "string",
            ]);

            // Extract input with sane defaults
            $customer_id  = isset($input["customer_id"]) ? intval($input["customer_id"]) : 0;
            $status       = isset($input["status"]) ? $input["status"] : "all";
            $location     = isset($input["location"]) ? intval($input["location"]) : 0;
            $types        = isset($input["types"]) ? intval($input["types"]) : 0;
            $category     = isset($input["category"]) ? intval($input["category"]) : 0;
            $expiry_from  = isset($input["expiry_from"]) ? trim($input["expiry_from"]) : "";
            $expiry_to    = isset($input["expiry_to"]) ? trim($input["expiry_to"]) : "";
            $manu_from    = isset($input["manu_from"]) ? trim($input["manu_from"]) : "";
            $manu_to      = isset($input["manu_to"]) ? trim($input["manu_to"]) : "";

            $query = $this->db->gmedaire()
                ->SELECT([
                    'c.id AS id',
                    'c.serial_no AS serial',
                    'c.barcode AS barcode',
                    'c.types AS types_id',
                    'c.capacity AS capacity',
                    'c.customer_id AS customer_id',
                    'c.category_id AS category_id',
                    'c.unit_id AS unit_id',
                    'c.manufacture_date AS manufacture_date',
                    'c.expiry_date AS expiry_date',
                    'c.inspection_date AS inspection_date',
                    'c.hydrotest_date AS hydrotest_date',
                    'c.location_id AS location_id',
                    'c.status AS status',
                    'c.deleted AS deleted',
                    'p.descriptions AS customers',
                    'cl.descriptions AS locations',
                    'cc.descriptions AS categories',
                    'ct.descriptions AS types',
                    'cu.tags AS units'
                ], 'cylinders c')
                ->LEFTJOIN("partners p", "p.id = c.customer_id")
                ->LEFTJOIN("cylinder_locations cl", "cl.id = c.location_id")
                ->LEFTJOIN("cylinder_categories cc", "cc.id = c.category_id")
                ->LEFTJOIN("cylinder_types ct", "ct.id = c.types")
                ->LEFTJOIN("cylinder_units cu", "cu.id = c.unit_id")
                ->WHERE(['c.deleted' => 0]);

            // Customer filter: 0 means all customers
            if ($customer_id !== 0) {
                $query->WHERE(['c.customer_id' => $customer_id]);
            }

            // Status filter: 'all' means any status
            if ($status && $status !== 'all') {
                $query->WHERE(['c.status' => $status]);
            }

            // Location filter: 0 means all locations
            if ($location !== 0) {
                $query->WHERE(['c.location_id' => $location]);
            }

            // Types filter: 0 means all types
            if ($types !== 0) {
                $query->WHERE(['c.types' => $types]);
            }

            // Category filter: 0 means all categories
            if ($category !== 0) {
                $query->WHERE(['c.category_id' => $category]);
            }

            // Expiry date filter (if both from and to are set)
            if ($expiry_from !== "" && $expiry_to !== "") {
                $query->WHERE_BETWEEN('c.expiry_date', $expiry_from, $expiry_to);
            } else if ($expiry_from !== "") {
                $query->WHERE('c.expiry_date >= ?', [$expiry_from]);
            } else if ($expiry_to !== "") {
                $query->WHERE('c.expiry_date <= ?', [$expiry_to]);
            }

            // Manufacture date filter (if both from and to are set)
            if ($manu_from !== "" && $manu_to !== "") {
                $query->WHERE_BETWEEN('c.manufacture_date', $manu_from, $manu_to);
            } else if ($manu_from !== "") {
                $query->WHERE('c.manufacture_date >= ?', [$manu_from]);
            } else if ($manu_to !== "") {
                $query->WHERE('c.manufacture_date <= ?', [$manu_to]);
            }

            $cylinders = $query->get();

            return $response($cylinders, 200);
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to retrieve data.',
                'details' => $th->getMessage(),
            ], 500);
        }
    }

    public function add($request, $response, $params)
    {
        try {
            // Validate input
            $input = $request->validate([
                "barcode" => "required|string",
                "serial" => "required|string",
                "types" => "required|int|min:1",
                "capacity" => "required|float|min:1",
                "units" => "required|int|min:1",
                "categories" => "required|int|min:1",
                "manufacture_date" => "required|date",
                "expiry_date" => "required|date"
            ]);

            $locationService = new LocationsService($this->db);
            $cylinderService = new CylinderService($this->db);

            // Aggregate duplicate errors
            $errors = [];
            if ($cylinderService->serialExists($input['serial'])) {
                $errors[] = 'Serial number already exists.';
            }
            if ($cylinderService->barcodeExists($input['barcode'])) {
                $errors[] = 'Barcode already exists.';
            }
            if (!empty($errors)) {
                throw new \Exception(implode(' ', $errors), 400);
            }
            $location = $locationService->getDefault();
            // Prepare insert data
            $data = [
                "barcode"            => $input["barcode"],
                "serial_no"          => $input["serial"],
                "types"              => $input["types"],
                "capacity"           => $input["capacity"],
                "unit_id"            => $input["units"],
                "category_id"        => $input["categories"],
                "manufacture_date"   => $input["manufacture_date"],
                "expiry_date"        => $input["expiry_date"],
                "location_id"        => $location
            ];

            $id = $this->db->gmedaire()->INSERT('cylinders', $data);

            if ($id) {
                return $response([
                    "success" => true,
                    "message" => "Cylinder added successfully.",
                    "cylinder_id" => $id,
                ], 200);
            }

            return $response([
                "error" => true,
                "message" => "Failed to add cylinder."
            ], 400);
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to retrieve data.',
                'details' => $th->getMessage(),
            ], 500);
        }
    }
    public function update($request, $response, $params)
    {
        try {
            // Validate input: require id (int), barcode, serial, types, capacity, units, categories, manufacture_date, expiry_date, location_id
            $input = $request->validate([
                "id"               => "required|int|min:1",
                "barcode"          => "required|string",
                "serial"           => "required|string",
                "types"            => "required|int|min:1",
                "capacity"         => "required|float",
                "units"            => "required|int|min:1",
                "categories"       => "required|int|min:1",
                "manufacture_date" => "required|date",
                "expiry_date"      => "required|date",
            ]);

            $cylinderService = new CylinderService($this->db);

            // Aggregate duplicate errors, ignore current record
            $errors = [];
            // Aggregate duplicate errors
            $errors = [];
            if ($cylinderService->serialExists($input['serial'])) {
                $errors[] = 'Serial number already exists.';
            }
            if ($cylinderService->barcodeExists($input['barcode'])) {
                $errors[] = 'Barcode already exists.';
            }

            if (!empty($errors)) {
                throw new \Exception(implode(' ', $errors), 400);
            }

            $updateData = [
                "barcode"            => $input["barcode"],
                "serial_no"          => $input["serial"],
                "types"              => $input["types"],
                "capacity"           => $input["capacity"],
                "unit_id"            => $input["units"],
                "category_id"        => $input["categories"],
                "manufacture_date"   => $input["manufacture_date"],
                "expiry_date"        => $input["expiry_date"],
            ];

            $updated = $this->db->gmedaire()
                ->UPDATE('cylinders', $updateData)
                ->WHERE(['id' => $input["id"]]);

            if ($updated) {
                return $response([
                    "success" => true,
                    "message" => "Cylinder updated successfully.",
                    "updated" => $updated,
                ], 200);
            } else {
                return $response([
                    "error" => true,
                    "message" => "Failed to update cylinder or no changes."
                ], 400);
            }
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to update cylinder.',
                'details' => $th->getMessage(),
            ], 500);
        }
    }

    public function delete($request, $response, $params)
    {
        try {
            $input = $request->validate([
                "id" => "required|int|min:1"
            ]);

            $result = $this->db->gmedaire()
                ->UPDATE('cylinders', ['deleted' => 1])
                ->WHERE(['id' => $input['id']]);

            if ($result) {
                return $response(['message' => "Cylinder deleted successfully."], 200);
            } else {
                return $response(['error' => true, 'message' => 'Cylinder not found or could not be deleted.'], 404);
            }
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to delete data.',
                'details' => $th->getMessage(),
            ], 500);
        }
    }

    public function barcodeExists($barcode)
    {
        $item = $this->db->gmedaire()
            ->SELECT('id', 'cylinders')
            ->WHERE(['barcode' => $barcode, 'deleted' => 0])
            ->first();

        return $item ? true : false;
    }
}
