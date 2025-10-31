<?php
require_once "db.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM projects WHERE id = $id");
            echo json_encode($result->fetch_assoc());
        } else {
            $result = $conn->query("SELECT * FROM projects");
            $projects = [];
            while ($row = $result->fetch_assoc()) {
                // $row['galery'] = json_decode($row['galery'], true);
                $projects[] = $row;
            }
            echo json_encode($projects);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $id_title = $conn->real_escape_string($data['id_title']);
        $title = $conn->real_escape_string($data['title']);
        $storytext = isset($data['storytext']) ? $conn->real_escape_string($data['storytext']) : null;
        $img_main = $conn->real_escape_string($data['img_main']);
        $galery = isset($data['galery']) ? ($data['galery'] ? 1 : 0) : 0;
        $structural_calc = $conn->real_escape_string($data['data']['structural_calc']);
        $ubication = $conn->real_escape_string($data['data']['ubication']);
        $surface = $conn->real_escape_string($data['data']['surface']);
        $studio = $conn->real_escape_string($data['data']['studio']);
        $system_build = $conn->real_escape_string($data['data']['system_build']);
        $duration = isset($data['data']['duration']) ? intval($data['data']['duration']) : 'NULL';
        $instagram = isset($data['data']['instagram']) ? $conn->real_escape_string($data['data']['instagram']) : null;
        $year_build = $conn->real_escape_string($data['data']['year']);
        $status_p = $conn->real_escape_string($data['status']);
        $position_grid = $conn->real_escape_string($data['position_grid']);


        $sql = "INSERT INTO projects (id_title, title, storytext, img_main, galery, structural_calc, ubication, surface, studio, system_build, duration, instagram, year_build, status_p, position_grid) 
                VALUES ('$id_title', '$title', " . ($storytext ? "'$storytext'" : "NULL") . ", '$img_main', '$galery', '$structural_calc', '$ubication', '$surface', '$studio', '$system_build', " . ($duration ?: "NULL") . ", " . ($instagram ? "'$instagram'" : "NULL") . ", '$year_build', '$status_p', '$position_grid')";
        
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
        $title = $conn->real_escape_string($data['title']);
        $storytext = isset($data['desc']) ? $conn->real_escape_string($data['desc']) : null;
        $img_main = $conn->real_escape_string($data['img_main']);
        $galery = isset($data['galery']) ? ($data['galery'] ? 1 : 0) : 0;
        $structural_calc = $conn->real_escape_string($data['data']['structural_calc']);
        $ubication = $conn->real_escape_string($data['data']['ubication']);
        $surface = $conn->real_escape_string($data['data']['surface']);
        $studio = $conn->real_escape_string($data['data']['studio']);
        $system_build = $conn->real_escape_string($data['data']['system_build']);
        $duration = isset($data['data']['duration']) ? intval($data['data']['duration']) : 'NULL';
        $instagram = isset($data['data']['instagram']) ? $conn->real_escape_string($data['data']['instagram']) : null;
        $year_build = $conn->real_escape_string($data['data']['year']);
        $status = $conn->real_escape_string($data['status']);
        $position_grid = $conn->real_escape_string($data['position_grid']);


        $sql = "UPDATE projects SET 
                    title='$title', 
                    storytext=" . ($storytext ? "'$storytext'" : "NULL") . ", 
                    img_main='$img_main', 
                    galery='$galery', 
                    structural_calc='$structural_calc', 
                    ubication='$ubication', 
                    surface='$surface', 
                    studio='$studio', 
                    system_build='$system_build', 
                    duration=" . ($duration ?: "NULL") . ",
                    instagram=" . ($instagram ? "'$instagram'" : "NULL") . ",
                    status=" . ($status). "
                    position_grid=" . ($position_grid). "
                    year_build='$year_build'
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
        if ($conn->query("DELETE FROM projects WHERE id=$id")) {
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
