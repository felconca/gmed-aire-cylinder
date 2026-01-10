<?php

namespace App\Controllers;

use App\Services\CylinderService;
use Includes\Rest;
use Core\Database\Database;

class DeliveryController extends Rest
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

    public function index($request, $response)
    {
        // WHY IT RETURNS EMPTY ARRAY?

        // 1. Input Validation: Check the input values (customer, from, to, status)
        //    Are they being set as expected? Is the frontend passing correct values?

        try {
            $input = $request->validate([
                "customer" => "required|numeric",
                "from" => "required|date",
                "to" => "required|date",
                "status" => "string",

            ]);

            // Debug: capture and log what input is received
            // file_put_contents('/tmp/delivery_debug.txt', print_r($input, true), FILE_APPEND);

            $qb = $this->db->gmedaire();

            $results = $qb->SELECT(
                [
                    'cd.id',
                    'cd.delivery_no',
                    'cd.delivered_date',
                    'cd.delivery_date',
                    'cd.request_date',
                    'cd.customer_id',
                    'cd.status',
                    'cd.items_total',
                    'cd.customer_address',
                    // partners
                    'p.descriptions',
                    'p.contact_person as partner_contact_person',
                    'p.contact_no as partner_contact_no',
                    'p.email as partner_email',
                    'p.address as partner_address',
                    'p.city as partner_city',
                    'p.state as partner_state',
                    'p.zipcode as partner_zipcode',
                    "CONCAT(p.address, ', ', IFNULL(p.city, ''), ', ', IFNULL(p.state, ''), ', ', IFNULL(p.zipcode, '')) as location_full_address",
                    // partners_locations
                    'pl.address as location_address',
                    'pl.contact_no as location_contact_no',
                    'pl.contact_person as location_contact_person',
                    'pl.email as location_email',
                ],
                'cylinder_delivery cd'
            )
                ->LEFTJOIN('partners p', 'p.id = cd.customer_id')
                ->LEFTJOIN('partners_locations pl', 'pl.id = cd.customer_address')
                ->WHERE("cd.deleted = 0");

            // 2. Debug what WHERE conditions are being applied
            //    If any of the WHEREs below are too restrictive, you will get empty results

            // a. Status filter
            if ($input["status"] !== 'all') {
                $results->WHERE(["cd.status" => $input['status']]);
                // Debug: file_put_contents('/tmp/delivery_debug.txt', "STATUS={$input['status']}\n", FILE_APPEND);
            }

            // b. Customer filter
            //    Make sure `customer` is numeric and not string "0"
            if ((int)$input["customer"] !== 0) {
                $results->WHERE(["cd.customer_id" => $input['customer']]);
                // Debug: file_put_contents('/tmp/delivery_debug.txt', "CUSTOMER={$input['customer']}\n", FILE_APPEND);
            }

            // c. Date Range filter
            //    If from/to are empty or date range is wrong, will return empty
            if (!empty($input["from"]) && !empty($input["to"])) {
                // Ensure correct date format for SQL: 'YYYY-MM-DD'
                $from = date('Y-m-d', strtotime($input["from"]));
                $to = date('Y-m-d', strtotime($input["to"]));
                $results->WHERE_BETWEEN("cd.delivery_date", $from, $to);
                // Debug: file_put_contents('/tmp/delivery_debug.txt', "FROM=$from TO=$to\n", FILE_APPEND);
            }

            // 3. Try running the generated SQL directly in database to see if it returns rows!
            // 4. Try removing all WHEREs except cd.deleted = 0. If it still returns empty, table is empty.

            $data = $results->get();

            // Debug: file_put_contents('/tmp/delivery_debug.txt', var_export($data, true), FILE_APPEND);

            $response($data, 200);
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function list_mobile($request, $response)
    {
        // WHY IT RETURNS EMPTY ARRAY?

        // 1. Input Validation: Check the input values (customer, from, to, status)
        //    Are they being set as expected? Is the frontend passing correct values?

        try {
            $input = $request->validate([
                "customer" => "required|numeric",
                "from" => "required|date",
                "to" => "required|date",
                "status" => "string",

            ]);

            // Debug: capture and log what input is received
            // file_put_contents('/tmp/delivery_debug.txt', print_r($input, true), FILE_APPEND);

            $qb = $this->db->gmedaire();

            $results = $qb->SELECT(
                [
                    'cd.id',
                    'cd.delivery_no',
                    'cd.delivered_date',
                    'cd.delivery_date',
                    'cd.request_date',
                    'cd.customer_id',
                    'cd.status',
                    'cd.items_total',
                    'cd.customer_address',
                    // partners
                    'p.descriptions',
                    'p.contact_person as partner_contact_person',
                    'p.contact_no as partner_contact_no',
                    'p.email as partner_email',
                    'p.address as partner_address',
                    'p.city as partner_city',
                    'p.state as partner_state',
                    'p.zipcode as partner_zipcode',
                    "CONCAT(p.address, ', ', IFNULL(p.city, ''), ', ', IFNULL(p.state, ''), ', ', IFNULL(p.zipcode, '')) as location_full_address",
                    // partners_locations
                    'pl.address as location_address',
                    'pl.contact_no as location_contact_no',
                    'pl.contact_person as location_contact_person',
                    'pl.email as location_email',
                ],
                'cylinder_delivery cd'
            )
                ->LEFTJOIN('partners p', 'p.id = cd.customer_id')
                ->LEFTJOIN('partners_locations pl', 'pl.id = cd.customer_address')
                ->WHERE("cd.deleted = 0");

            // 2. Debug what WHERE conditions are being applied
            //    If any of the WHEREs below are too restrictive, you will get empty results

            // a. Status filter
            if ($input["status"] !== 'all') {
                $results->WHERE(["cd.status" => $input['status']]);
                // Debug: file_put_contents('/tmp/delivery_debug.txt', "STATUS={$input['status']}\n", FILE_APPEND);
            }

            // b. Customer filter
            //    Make sure `customer` is numeric and not string "0"
            if ((int)$input["customer"] !== 0) {
                $results->WHERE(["cd.customer_id" => $input['customer']]);
                // Debug: file_put_contents('/tmp/delivery_debug.txt', "CUSTOMER={$input['customer']}\n", FILE_APPEND);
            }

            // c. Date Range filter
            //    If from/to are empty or date range is wrong, will return empty
            if (!empty($input["from"]) && !empty($input["to"])) {
                // Ensure correct date format for SQL: 'YYYY-MM-DD'
                $from = date('Y-m-d', strtotime($input["from"]));
                $to = date('Y-m-d', strtotime($input["to"]));
                $results->WHERE_BETWEEN("cd.delivery_date", $from, $to);
                // Debug: file_put_contents('/tmp/delivery_debug.txt', "FROM=$from TO=$to\n", FILE_APPEND);
            }

            // 3. Try running the generated SQL directly in database to see if it returns rows!
            // 4. Try removing all WHEREs except cd.deleted = 0. If it still returns empty, table is empty.

            $data = $results->get();

            // Debug: file_put_contents('/tmp/delivery_debug.txt', var_export($data, true), FILE_APPEND);

            $response($data, 200);
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function add($request, $response)
    {
        try {
            // Validate input
            $input = $request->validate([
                'customer_id'      => 'required|int|min:1',
                'customer_address' => 'numeric',
                'delivery_date'    => 'required|date',
                'request_date'     => 'required|date',
                'notes'            => 'string',
                "created_by"        => "required|int|min:1"
            ]);

            // Set default location_id
            $location_id = 1;

            // Generate delivery_no
            $delivery_no = $this->generateDeliveryNo();

            // Prepare insert data
            $data = [
                'delivery_no'      => $delivery_no,
                'location_id'      => $location_id,
                'customer_id'      => $input['customer_id'],
                'customer_address' => $input['customer_address'],
                'delivery_date'    => $input['delivery_date'],
                'request_date'     => $input['request_date'],
                'notes'            => $input['notes'],
                'created_by'       => $input['created_by'],
            ];

            // Insert into cylinder_delivery
            $qb = $this->db->gmedaire();
            $delivery_id = $qb->insert('cylinder_delivery', $data);

            return $response(['success' => true, 'id' => $delivery_id, 'delivery_no' => $delivery_no], 200);
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function edit($request, $response)
    {
        try {
            // Validate and get the ID from the request
            $input = $request->validate([
                'id' => 'required|int|min:1'
            ]);
            $id = $input['id'];

            $qb = $this->db->gmedaire();
            $result = $qb
                ->SELECT([
                    'cd.id',
                    'cd.delivery_no',
                    'cd.location_id',
                    'cd.customer_id',
                    'cd.customer_address ',
                    'cd.status',
                    'cd.items_total',
                    'cd.delivery_date',
                    'cd.request_date',
                    'cd.delivered_date',
                    'cd.notes',
                    'cd.created_by',
                    'cd.deleted',
                    'cd.created_at',
                    'cl.descriptions AS location_name',
                    'p.descriptions AS customer_name',
                    "CONCAT(u.lastname,', ' ,u.firstname) AS users"
                ], 'cylinder_delivery cd')
                ->LEFTJOIN('cylinder_locations cl', 'cd.location_id = cl.id')
                ->LEFTJOIN('partners p', 'cd.customer_id = p.id')
                ->LEFTJOIN('partners_locations pl', 'cd.customer_address = pl.id')
                ->LEFTJOIN('users u', 'cd.created_by = u.id')
                ->WHERE(['cd.id' => $id])
                ->first();

            // $items = $this->delivery_items($id);
            return $response($result, 200);
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function update($request, $reponse)
    {
        try {
            // Validate and get input fields
            $input = $request->validate([
                'id'               => 'required|int|min:1',
                'customer_id'      => 'required|int|min:1',
                'customer_address' => 'numeric',
                'delivery_date'    => 'required|date',
                'request_date'     => 'required|date',
                'notes'            => 'string'
            ]);

            $id = $input['id'];
            $cylinderService = new CylinderService($this->db);
            $updateFields = [
                'customer_id'      => $input['customer_id'],
                'customer_address' => $input['customer_address'],
                'delivery_date'    => $input['delivery_date'],
                'request_date'     => $input['request_date'],
                'notes'            => $input['notes'],
            ];

            $qb = $this->db->gmedaire();

            $updateResult = $qb->UPDATE('cylinder_delivery', $updateFields)
                ->WHERE(['id' => $id]);
            // $reutns = $cylinderService->updateItemsTotal($id);
            return $reponse([
                'success' => true,
                'message' => 'Delivery updated successfully',
                'result'  => $updateResult
            ], 200);
        } catch (\Exception $e) {
            return $reponse([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function update_status($request, $response)
    {
        try {
            // Validate input: delivery id and new status
            $input = $request->validate([
                'id'     => 'required|int|min:1',
                'status' => 'required|string',
                'cylinders_ids' => 'array|min:1',
            ]);
            $id = $input['id'];
            $status = $input['status'];

            $qb = $this->db->gmedaire();
            $updateResult = $qb->UPDATE('cylinder_delivery', ['status' => $status])
                ->WHERE(['id' => $id]);

            if ($updateResult) {
                return $response([
                    'success' => true,
                    'message' => 'Delivery status updated successfully',
                    'result' => $updateResult
                ], 200);
            } else {
                return $response([
                    'success' => false,
                    'message' => 'Failed to update delivery status'
                ], 400);
            }
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function delete($request, $response)
    {
        try {
            // Validate and get the ID from the request
            $input = $request->validate([
                'id' => 'required|int|min:1'
            ]);
            $id = $input['id'];

            $qb = $this->db->gmedaire();
            $updateResult = $qb->UPDATE('cylinder_delivery', ['deleted' => 1])
                ->WHERE(['id' => $id]);

            if ($updateResult) {
                return $response([
                    'success' => true,
                    'message' => 'Delivery record deleted successfully',
                    'result' => $updateResult
                ], 200);
            } else {
                return $response([
                    'success' => false,
                    'message' => 'Failed to delete delivery record',
                ], 400);
            }
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function delivery_items($request, $response)
    {
        try {
            // Validate and get the delivery_id from the request
            $input = $request->validate([
                'id' => 'required|int|min:1'
            ]);
            $id = $input['id'];

            $qb = $this->db->gmedaire();

            $results = $qb
                ->SELECT([
                    'cdi.id',
                    'cdi.delivery_id',
                    'cdi.cylinder_id',
                    'cylinders.serial_no',
                    'cylinders.barcode',
                    'cylinders.capacity',
                    'units.tags AS units',
                    'categories.descriptions AS categories',
                    'types.descriptions AS types',
                ], 'cylinder_delivery_items cdi')
                ->LEFTJOIN('cylinders', 'cdi.cylinder_id = cylinders.id')
                ->LEFTJOIN('cylinder_categories categories', 'cylinders.category_id = categories.id')
                ->LEFTJOIN('cylinder_types types', 'cylinders.types = types.id')
                ->LEFTJOIN('cylinder_units units', 'cylinders.unit_id = units.id')
                ->WHERE(['cdi.delivery_id' => $id])
                ->get();

            return $response($results, 200);
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function add_items($request, $response)
    {
        try {
            // Expecting 'data' as an array of associative arrays with 'delivery_id' and 'cylinder_id'
            $input = $request->validate([
                'data' => 'required|array|min:1',
                'data.*.delivery_id' => 'required|int|min:1',
                'data.*.cylinder_id' => 'required|int|min:1',
                'data.*.userid' => 'required|int|min:1',
                'data.*.status' => 'required|string',
            ]);
            $items = $input['data'];
            $qb = $this->db->gmedaire();
            $inserted = 0;
            $cylinderService = new CylinderService($this->db);

            $affectedDeliveryIds = [];
            foreach ($items as $item) {
                $res = $qb->INSERT('cylinder_delivery_items', [
                    'delivery_id' => $item['delivery_id'],
                    'cylinder_id' => $item['cylinder_id'],
                ]);
                if ($res) {
                    $inserted++;
                    // Log and change status to 'reserved'
                    $userId = isset($item['userid']) ? $item['userid'] : null;
                    if ($userId) {
                        $cylinderService->insertLog(
                            $item['cylinder_id'],
                            'reserved',
                            'Cylinder reserved for delivery',
                            $userId
                        );
                    }
                    $cylinderService->changeStatus($item['cylinder_id'], 'reserved');
                    $affectedDeliveryIds[] = $item['delivery_id'];
                }
            }
            // Call updateItemsTotal ONCE per unique delivery ID
            foreach (array_unique($affectedDeliveryIds) as $deliveryId) {
                $cylinderService->updateItemsTotal($deliveryId);
            }

            return $response([
                'success' => true,
                'inserted' => $inserted,
                'message' => $inserted > 0 ? "$inserted item(s) added successfully." : "No items were added."
            ], 201);
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function delete_items($request, $response)
    {
        try {
            // Expecting 'ids' to be an array of IDs in the POST body
            $input = $request->validate([
                'data' => 'required|array|min:1',
                'data.*.id' => 'required|int|min:1',
                'data.*.cylinder_id' => 'required|int|min:1',
                'data.*.delivery_id' => 'required|int|min:1',
            ]);
            $ids = $input['data'];
            $qb = $this->db->gmedaire();
            $deletedCount = 0;
            $cylinderService = new CylinderService($this->db);
            $affectedDeliveryIds = [];
            foreach ($ids as $items) {
                $deleted = $qb->DELETE('cylinder_delivery_items')
                    ->WHERE(['id' => $items["id"]]);
                if ($deleted) {
                    $deletedCount += $deleted;
                    $cylinderService->changeStatus($items['cylinder_id'], 'available');
                    // Collect affected delivery_id for updating items_total later
                    $affectedDeliveryIds[] = $items['delivery_id'];
                }
            }
            // Make sure to call updateItemsTotal once per unique delivery_id
            foreach (array_unique($affectedDeliveryIds) as $deliveryId) {
                $cylinderService->updateItemsTotal($deliveryId);
            }
            return $response([
                'success' => true,
                'deleted' => $deletedCount,
                'message' => $deletedCount > 0 ?
                    "$deletedCount item(s) deleted successfully." :
                    "No items were deleted."
            ], 200);
        } catch (\Exception $e) {
            return $response([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function cylinders($request, $response)
    {
        try {
            $input = $request->validate([
                "status"        => "string",
                "types"         => "number",
                "category"      => "number",
            ]);
            $status       = isset($input["status"]) ? $input["status"] : "all";
            $types        = isset($input["types"]) ? intval($input["types"]) : 0;
            $category     = isset($input["category"]) ? intval($input["category"]) : 0;

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
                    'cc.descriptions AS categories',
                    'ct.descriptions AS types',
                    'cu.tags AS units'
                ], 'cylinders c')
                ->LEFTJOIN("cylinder_categories cc", "cc.id = c.category_id")
                ->LEFTJOIN("cylinder_types ct", "ct.id = c.types")
                ->LEFTJOIN("cylinder_units cu", "cu.id = c.unit_id")
                ->WHERE(['c.deleted' => 0]);

            // Status filter: 'all' means any status
            if ($status && $status !== 'all') {
                $query->WHERE(['c.status' => $status]);
            }
            // Types filter: 0 means all types
            if ($types !== 0) {
                $query->WHERE(['c.types' => $types]);
            }

            // Category filter: 0 means all categories
            if ($category !== 0) {
                $query->WHERE(['c.category_id' => $category]);
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

    /**
     * Generates a unique delivery number based on the current count in the cylinder_delivery table.
     * Format: "DLV-YYYYMMDD-XXXXXX"
     *   - DLV: prefix
     *   - YYYYMMDD: current date
     *   - XXXXXX: serial is (current count + 1), zero-padded to 6 digits
     *
     * @param array $options Allowed keys: prefix (default DLV), length (default 6), date (default today)
     * @return string Delivery number, e.g. "DLV-20240608-000101"
     */
    private function generateDeliveryNo($options = array())
    {
        $prefix = isset($options['prefix']) ? $options['prefix'] : 'DLV';
        $length = isset($options['length']) ? intval($options['length']) : 6;
        if (isset($options['date'])) {
            $now = is_string($options['date']) ? strtotime($options['date']) : $options['date'];
            if (!$now) {
                $now = time();
            }
        } else {
            $now = time();
        }

        $year = date('Y', $now);
        $month = date('m', $now);
        $day = date('d', $now);
        $datePart = $year . $month . $day;

        // Use QueryBuilder to get count of existing deliveries where deleted = 0
        $qb = $this->db->gmedaire();
        $row = $qb->SELECT('COUNT(*) as cnt', 'cylinder_delivery')
            ->WHERE(['deleted' => 0])
            ->first();
        $count = $row && isset($row->cnt) ? intval($row->cnt) : 0;
        $serial = str_pad($count + 1, $length, '0', STR_PAD_LEFT);

        return $prefix . '-' . $datePart . '-' . $serial;
    }
}
