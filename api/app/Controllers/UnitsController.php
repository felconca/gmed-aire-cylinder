<?php

namespace App\Controllers;

use Includes\Rest;
use Core\Database\Database;

class UnitsController extends Rest
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
            $units = $this->db->gmedaire()
                ->SELECT([
                    'id',
                    'tags',
                    'descriptions',
                    'deleted'
                ], 'cylinder_units')
                ->WHERE(['deleted' => 0])
                ->get();

            return $response($units, 200);
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => 'Failed to retrieve units.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
    public function add($request, $response, $params)
    {
        try {
            // Validate request data: tags and descriptions required
            $input = $request->validate([
                "tags" => "required|string",
                "descriptions" => "required|string"
            ]);

            $data = [
                "tags" => $input["tags"],
                "descriptions" => $input["descriptions"]
            ];

            $id = $this->db->gmedaire()
                ->INSERT('cylinder_units', $data);

            if ($id) {
                return $response([
                    "success" => true,
                    "message" => "Units added successfully.",
                    "unit_id" => $id
                ], 200);
            } else {
                return $response([
                    "error" => true,
                    "message" => "Failed to add units."
                ], 400);
            }
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to add units.',
                'details' => $th->getMessage(),
            ], 500);
        }
    }
    public function update($request, $response, $params)
    {
        try {
            // Validate request data: id required, and at least one updatable field
            $input = $request->validate([
                "id" => "required|int|min:1",
                "tags" => "string",
                "descriptions" => "string"
            ]);
            $updateData = [
                "tags" => $input["tags"],
                "descriptions" => $input["descriptions"]
            ];

            // Find and update the category by ID
            $update = $this->db->gmedaire()
                ->UPDATE('cylinder_units', $updateData)
                ->WHERE(['id' => $input["id"]]);


            return $response([
                "success" => true,
                "message" => "Unit updated successfully.",
                "update" => $update
            ], 200);
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to update units.',
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

            // Set deleted to 1 for the given units id
            $delete = $this->db->gmedaire()
                ->UPDATE('cylinder_units', ['deleted' => 1])
                ->WHERE(['id' => $input["id"]]);

            if ($delete) {
                return $response([
                    "success" => true,
                    "message" => "Unit deleted successfully."
                ], 200);
            } else {
                return $response([
                    "error" => true,
                    "message" => "Failed to delete units or units does not exist."
                ], 400);
            }
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to delete units.',
                'details' => $th->getMessage(),
            ], 500);
        }
    }
}
