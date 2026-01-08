<?php

namespace App\Controllers;

use Includes\Rest;
use Core\Database\Database;

class TypesController extends Rest
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
            $types = $this->db->gmedaire()
                ->SELECT([
                    'id',
                    'tags',
                    'descriptions',
                    'deleted'
                ], 'cylinder_types')
                ->WHERE(['deleted' => 0])
                ->get();

            return $response($types, 200);
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => 'Failed to retrieve types.',
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
                ->INSERT('cylinder_types', $data);

            if ($id) {
                return $response([
                    "success" => true,
                    "message" => "Type added successfully.",
                    "type_id" => $id
                ], 200);
            } else {
                return $response([
                    "error" => true,
                    "message" => "Failed to add type."
                ], 400);
            }
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to add type.',
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
                ->UPDATE('cylinder_types', $updateData)
                ->WHERE(['id' => $input["id"]]);


            return $response([
                "success" => true,
                "message" => "Type updated successfully."
            ], 200);
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to update type.',
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

            // Set deleted to 1 for the given type id
            $delete = $this->db->gmedaire()
                ->UPDATE('cylinder_types', ['deleted' => 1])
                ->WHERE(['id' => $input["id"]]);

            if ($delete) {
                return $response([
                    "success" => true,
                    "message" => "Type deleted successfully."
                ], 200);
            } else {
                return $response([
                    "error" => true,
                    "message" => "Failed to delete type or type does not exist."
                ], 400);
            }
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to delete type.',
                'details' => $th->getMessage(),
            ], 500);
        }
    }
}
