<?php
require_once "db.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        // si viene ?roles=1 -> todos los usuarios y roles
        if (isset($_GET['roles'])) {
            $sql = "SELECT username, id_rol FROM users";
            $result = $conn->query($sql);
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            echo json_encode($users);
        } else {
            // trae todos los usuarios (sin filtrar)
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            echo json_encode($users);
        }
        break;

    case 'POST':
        // leer datos enviados desde Angular
        $data = json_decode(file_get_contents("php://input"), true);
        $username = $conn->real_escape_string($data['data_user']);
        $password = $conn->real_escape_string($data['data_pass']);

        // buscar usuario en la base
        $sql = "SELECT username, passwordtoken FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if ($user['username'] === $username) {
                if (password_verify($password, $user['passwordtoken'])) {
                // 100 - ambos coinciden
                echo json_encode(["code" => "100"]);
                exit;
                } else {
                // 102 - usuario coincide, pass no
                echo json_encode(["code" => "102"]);
                exit;
                }   
            } 
        } 
        else {
            // 101 - usuario no coincide
            echo json_encode(["code" => "101"]);
            exit;
        }
        
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}

$conn->close();
?>
