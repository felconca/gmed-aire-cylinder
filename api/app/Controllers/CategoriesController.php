<?php

namespace App\Controllers;

use Includes\Rest;
use Core\Database\Database;

class CategoriesController extends Rest
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
            $categories = $this->db->gmedaire()
                ->SELECT([
                    'id',
                    'tags',
                    'descriptions',
                    'items_total',
                    'deleted'
                ], 'cylinder_categories')
                ->WHERE(["deleted" => 0])
                ->get();

            return $response($categories, 200);
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => 'Failed to retrieve categories.',
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
                ->INSERT('cylinder_categories', $data);

            if ($id) {
                return $response([
                    "success" => true,
                    "message" => "Category added successfully.",
                    "categories_id" => $id
                ], 200);
            } else {
                return $response([
                    "error" => true,
                    "message" => "Failed to add category."
                ], 400);
            }
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to add category.',
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

            $updateData = [
                "tags" => $input["tags"],
                "descriptions" => $input["descriptions"]
            ];

            // Find and update the category by ID
            $update = $this->db->gmedaire()
                ->UPDATE('cylinder_categories', $updateData)
                ->WHERE(['id' => $input["id"]]);

            return $response([
                "success" => true,
                "message" => "Category updated successfully.",
                "update" => $update
            ], 200);
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to update category.',
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

            // Set deleted to 1 for the given category id
            $delete = $this->db->gmedaire()
                ->UPDATE('cylinder_categories', ['deleted' => 1])
                ->WHERE(['id' => $input["id"]]);

            if ($delete) {
                return $response([
                    "success" => true,
                    "message" => "Category deleted successfully."
                ], 200);
            } else {
                return $response([
                    "error" => true,
                    "message" => "Failed to delete category or category does not exist."
                ], 400);
            }
        } catch (\Throwable $th) {
            return $response([
                'error' => true,
                'message' => 'Failed to delete category.',
                'details' => $th->getMessage(),
            ], 500);
        }
    }
}
