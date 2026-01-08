<?php

namespace App\Controllers;

use Includes\Rest;
use Core\Database\Database;

class AuthController extends Rest
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
        return $response(['message' => 'AuthController index'], 200);
    }
    public function login($request, $response, $params)
    {
        try {
            $input = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            $username = $input["username"];
            $password = $input["password"];

            $user = $this->db->gmedaire()
                ->SELECT("id, username, firstname, lastname, profile, password, contacts, email, user_type", "users")
                ->WHERE("email='$username' OR username='$username'")
                ->WHERE(["deleted" => 0])
                ->first();

            if ($user && password_verify($password, $user->password)) {
                session_name('GMED_INVENTORY_SESS');
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                session_unset();
                session_destroy();
                session_start(); // start fresh
                session_regenerate_id(true);

                // Store user info in session
                $_SESSION["user"] = [
                    "id" => $user->id,
                    "username" => $user->username,
                    "firstname" => $user->firstname,
                    "lastname" => $user->lastname,
                    "profile" => $user->profile,
                    "user_type" => $user->user_type
                ];

                $success = [
                    "message" => "Login successful",
                    "status"  => 200,
                    "user"    => $_SESSION["user"]
                ];
                $this->response($success, 200);
            } else {
                $this->response(["status" => 401, "error" => "Invalid username or password"], 401);
            }
        } catch (Exception $e) {
            return $response(["status" => 400, "error" => $e->getMessage()], 400);
        }
    }
    public function verify($request, $response, $params)
    {
        session_name($_ENV['AUTH_SESSION_NAME']); // unique, branded
        // Only start session if cookie exists
        if (!isset($_COOKIE[session_name()])) {
            return $response(["status" => 401, "error" => "No active session"], 401);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $timeout = 3600;          // 30 mins inactivity
        $absoluteLifetime = 3600; // 1 hour max

        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
            session_unset();
            session_destroy();
            setcookie(session_name(), '', time() - 3600, '/');
            return $response(["status" => 401, "error" => "Session expired (inactive)"], 401);
        }

        $_SESSION['LAST_ACTIVITY'] = time();

        if (!isset($_SESSION['CREATED'])) {
            $_SESSION['CREATED'] = time();
        } elseif (time() - $_SESSION['CREATED'] > $absoluteLifetime) {
            session_unset();
            session_destroy();
            setcookie(session_name(), '', time() - 3600, '/');
            return $response(["status" => 401, "error" => "Session expired (max lifetime)"], 401);
        }

        if (isset($_SESSION["user"])) {
            return $response([
                "status" => 200,
                "user" => $_SESSION["user"]
            ], 200);
        } else {
            return $response(["status" => 401, "error" => "Not logged in"], 401);
        }
    }
    public function profile($request, $response, $params)
    {
        // Define upload directory
        $uploadDir = __DIR__ . '/../../uploads/';

        // Allowed extensions to check
        $extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $filePath = null;
        $fileExt = null;

        // Try each extension
        foreach ($extensions as $ext) {
            $path = $uploadDir . $params['img'] . '.' . $ext;
            if (file_exists($path)) {
                $filePath = $path;
                $fileExt = $ext;
                break;
            }
        }

        // If not found, return placeholder or 404
        if (!$filePath) {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Profile image not found']);
            exit;
        }

        // Correct MIME type
        $ext = strtolower($fileExt);
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $mimeType = 'image/jpeg';
                break;
            case 'png':
                $mimeType = 'image/png';
                break;
            case 'gif':
                $mimeType = 'image/gif';
                break;
            case 'webp':
                $mimeType = 'image/webp';
                break;
            default:
                $mimeType = 'application/octet-stream';
        }

        // Output image
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
    public function logout($request, $response, $params)
    {

        session_name($_ENV['AUTH_SESSION_NAME']); // unique, branded
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Clear all session variables
        $_SESSION = [];

        // Destroy session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();


        $response(["status" => 200, "message" => "Logged out"], 200);
    }
}
