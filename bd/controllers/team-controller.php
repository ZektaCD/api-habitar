<?php
require_once "db.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM team_members WHERE id = $id");
            echo json_encode($result->fetch_assoc());
        } else {
            $result = $conn->query("SELECT * FROM team_members");
            $members = [];
            while ($row = $result->fetch_assoc()) {
                $members[] = $row;
            }
            echo json_encode($members);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $photo = $conn->real_escape_string($data['image']);
        $team_mate = $conn->real_escape_string($data['name']);
        $position = $conn->real_escape_string($data['position']);
        $instagram = $conn->real_escape_string($data['instagram']);
        $linkedin = $conn->real_escape_string($data['linkedin']);

        $sql = "INSERT INTO team_members (photo, team_mate, position, instagram, linkedin) 
                VALUES ('$photo', '$team_mate', '$position', '$instagram', '$linkedin')";
        
        if ($conn->query($sql)) {
            echo json_encode(["success" => true, "id" => $conn->insert_id]);
        } else {
            echo json_encode(["success" => false, "error" => $conn->error]);
        }
        break;

    case 'PUT':
        if (!isset($_GET['id'])) { echo json_encode(["success" => false, "error" => "ID requerido"]); exit; }
        $id = intval($_GET['id']);
        $data = json_decode(file_get_contents("php://input"), true);
        $photo = $conn->real_escape_string($data['image']);
        $team_mate = $conn->real_escape_string($data['name']);
        $position = $conn->real_escape_string($data['position']);
        $instagram = $conn->real_escape_string($data['instagram']);
        $linkedin = $conn->real_escape_string($data['linkedin']);

        $sql = "UPDATE team_members SET 
                    photo='$photo', 
                    team_mate='$team_mate', 
                    position='$position', 
                    instagram='$instagram', 
                    linkedin='$linkedin'
                WHERE id=$id";

        if ($conn->query($sql)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $conn->error]);
        }
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) { echo json_encode(["success" => false, "error" => "ID requerido"]); exit; }
        $id = intval($_GET['id']);
        if ($conn->query("DELETE FROM team_members WHERE id=$id")) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $conn->error]);
        }
        break;

    default:
        echo json_encode(["success" => false, "error" => "Método no soportado"]);
        break;
}
?>
