<?php

namespace App\Controllers;

use App\Services\LocationsService;
use Includes\Rest;
use Core\Database\Database;

class LocationsController extends Rest
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
            $locations = $this->db->gmedaire()
                ->SELECT([
                    'id',
                    'tags',
                    'descriptions',
                    'default_1',
                    'items_total',
                    'deleted'
                ], 'cylinder_locations')
                ->WHERE(['deleted' => 0])
                ->get();

            return $response($locations, 200);
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => 'Failed to retrieve locations.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function add($request, $response, $params)
    {
        try {
            // Validate request data: tags and descriptions required, warehouse always 1
            $input = $request->validate([
                "tags" => "required|string",
                "descriptions" => "required|string"
            ]);

            $locationService = new LocationsService($this->db);
            $default_1 = $locationService->unsetAllDefaults();
            // Force warehouse to 1
            $data = [
                "tags" => $input["tags"],
                "descriptions" => $input["descriptions"],
                "warehouse" => 1,
                "default_1" => $default_1,
            ];

            $id = $this->db->gmedaire()
                ->INSERT('cylinder_locations', $data);

            if ($id) {
                return $response([
                    "success" => true,
                    "message" => "Location added successfully.",
                    'location_id' => $id
                ], 200);
            } else {
                return $response([
                    "error" => true,
                    "message" => "Failed to add location."
                ], 400);
            }
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to add location.',
                'details' => $th->getMessage(),
            ], 500);
        }
    }
    public function update($request, $response, $params)
    {
        try {
            // Validate input: id, tags, and descriptions are required
            $input = $request->validate([
                "id" => "required|int|min:1",
                "tags" => "required|string",
                "descriptions" => "required|string"
            ]);


            $locationService = new LocationsService($this->db);
            $default_1 = $locationService->unsetAllDefaults();

            $updateData = [
                "tags" => $input["tags"],
                "descriptions" => $input["descriptions"],
                "default_1" => $default_1,
            ];

            // Find and update the location by ID
            $update = $this->db->gmedaire()
                ->UPDATE('cylinder_locations', $updateData)
                ->WHERE(['id' => $input["id"]]);

            return $response([
                "success" => true,
                "message" => "Location updated successfully.",
                "updated" => $update
            ], 200);
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to update location.',
                'details' => $th->getMessage(),
            ], 500);
        }
    }
    public function delete($request, $response, $params)
    {
        try {
            // Validate input: id is required
            $input = $request->validate([
                "id" => "required|int|min:1"
            ]);

            // Set deleted to 1 for the given location id
            $delete = $this->db->gmedaire()
                ->UPDATE('cylinder_locations', ['deleted' => 1])
                ->WHERE(['id' => $input["id"]]);

            if ($delete) {
                return $response([
                    "success" => true,
                    "message" => "Location deleted successfully."
                ], 200);
            } else {
                return $response([
                    "error" => true,
                    "message" => "Failed to delete location or location does not exist."
                ], 400);
            }
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to delete location.',
                'details' => $th->getMessage(),
            ], 500);
        }
    }
}
