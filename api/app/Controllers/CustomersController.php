<?php

namespace App\Controllers;

use Includes\Rest;
use Core\Database\Database;

class CustomersController extends Rest
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
            $input = $request->validate(["status" => "required|string"]);
            $customers = $this->db->gmedaire()
                ->SELECT([
                    'id',
                    'tags',
                    'descriptions',
                    'contact_person',
                    'contact_no',
                    'email',
                    'address',
                    'city',
                    'state',
                    'zipcode',
                    'country',
                    'taxid',
                    'tin_id',
                    'status',
                    'is_what',
                    'deleted'
                ], 'partners')
                ->WHERE(['is_what' => "customer", 'deleted' => 0, 'status' => $input['status']])
                ->get();

            return $response($customers, 200);
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => 'Failed to retrieve customers.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
    public function add($request, $response, $params)
    {
        try {
            // Validate incoming data
            $input = $request->validate([
                'descriptions'   => 'required|string',
                'contact_person' => 'required|string',
                'contact_no'     => 'required|string',
                'address'        => 'required|string',
                'city'           => 'required|string',
                'state'          => 'required|string',
                'zipcode'        => 'required|string',
                'is_what'        => 'required|string'
            ]);
            $row = $this->db->gmedaire()
                ->SELECT(["MAX(CAST(SUBSTRING(tags, 4) AS UNSIGNED)) AS max_num"], 'partners')
                ->WHERE(['is_what' => 'customer'])
                ->first();

            $nextId = ($row->max_num ?? 0) + 1;
            $autoTag = "CUS" . $nextId;
            $data = [
                'tags'           => $autoTag ?? null,
                'descriptions'   => $input['descriptions'],
                'contact_person' => $input['contact_person'] ?? null,
                'contact_no'     => $input['contact_no'] ?? null,
                'email'          => $input['email'] ?? null,
                'address'        => $input['address'] ?? null,
                'city'           => $input['city'] ?? null,
                'state'          => $input['state'] ?? null,
                'zipcode'        => $input['zipcode'] ?? null,
                'is_what'        => $input['is_what'],
            ];

            $id = $this->db->gmedaire()
                ->INSERT('partners', $data);

            if ($id) {
                return $response([
                    'success' => true,
                    'message' => 'Customer added successfully.',
                    'customer_id' => $id
                ], 201);
            }
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => 'Failed to add customer.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    public function update($request, $response)
    {
        try {
            // Validate request data
            $input = $request->validate([
                'id'             => 'required|integer',
                'descriptions'   => 'required|string',
                'contact_person' => 'required|string',
                'contact_no'     => 'required',
                'address'        => 'required|string',
                'city'           => 'required|string',
                'state'          => 'required|string',
                'zipcode'        => 'required',
            ]);

            $id = $input['id'];

            $data = [
                'descriptions'   => $input['descriptions'],
                'contact_person' => $input['contact_person'],
                'contact_no'     => $input['contact_no'],
                'address'        => $input['address'],
                'city'           => $input['city'],
                'state'          => $input['state'],
                'zipcode'        => $input['zipcode'],
            ];

            // Optionally update email if set (as create supports nullable)
            if (isset($input['email'])) {
                $data['email'] = $input['email'];
            }

            $affectedRows = $this->db->gmedaire()
                ->UPDATE('partners', $data)
                ->WHERE(['id' => $id, 'is_what' => 'customer']);
            return $response([
                'success' => true,
                'message' => 'Customer updated successfully.'
            ], 200);
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => 'Failed to update customer.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    public function delete($request, $response)
    {
        try {
            $input = $request->validate([
                'id' => 'required|integer'
            ]);
            $id = $input['id'];
            $affectedRows = $this->db->gmedaire()
                ->UPDATE('partners', ['deleted' => 1])
                ->WHERE(['id' => $id, 'is_what' => 'customer']);

            if ($affectedRows) {
                return $response([
                    'success' => true,
                    'message' => 'Customer deleted successfully.'
                ], 200);
            } else {
                return $response([
                    'error' => true,
                    'message' => 'Customer not found or already deleted.'
                ], 404);
            }
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => 'Failed to delete customer.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function contacts($request, $response)
    {
        try {
            $input = $request->validate([
                'id' => 'required|integer'
            ]);
            $partnerId = $input['id'];

            $rows = $this->db->gmedaire()
                ->SELECT(
                    ['id, partner_id, address, contact_no, contact_person, email, deleted'],
                    'partners_locations'
                )
                ->WHERE(['partner_id' => $partnerId, 'deleted' => 0])
                ->get();

            return $response($rows, 200);
        } catch (\Exception $e) {
            return $response([
                "status" => 400,
                "error"  => $e->getMessage()
            ], 400);
        }
    }
    public function save_contacts($request, $response)
    {
        try {
            $input = $request;
            $db = $this->db->gmedaire();

            foreach ($input as $row) {
                $partner_id     = intval($row["partner_id"]);
                $id             = intval($row["id"] ?? 0);
                $contact_person = $row["contact_person"] ?? "";
                $contact_no     = $row["contact_no"] ?? "";
                $email          = $row["email"] ?? "";
                $address        = $row["address"] ?? "";
                $deleted        = intval($row["deleted"] ?? 0);

                if ($id > 0) {
                    if ($deleted == 1) {
                        // SOFT DELETE using QueryBuilder
                        $db->UPDATE('partners_locations', ['deleted' => 1])
                            ->WHERE(['id' => $id]);
                    } else {
                        // UPDATE existing row using QueryBuilder
                        $db->UPDATE('partners_locations', [
                            'contact_person' => $contact_person,
                            'contact_no'     => $contact_no,
                            'email'          => $email,
                            'address'        => $address,
                            'deleted'        => 0
                        ])
                            ->WHERE(['id' => $id]);
                    }
                } else {
                    // INSERT new (always with deleted = 0) using QueryBuilder
                    $db->INSERT('partners_locations', [
                        'partner_id'     => $partner_id,
                        'contact_person' => $contact_person,
                        'contact_no'     => $contact_no,
                        'email'          => $email,
                        'address'        => $address,
                        'deleted'        => 0
                    ]);
                }
            }

            $this->response(["status" => 200, "message" => "Contacts saved"], 200);
        } catch (\Exception $e) {
            $this->response(["status" => 400, "error" => $e->getMessage()], 400);
        }
    }
}
