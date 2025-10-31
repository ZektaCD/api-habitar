<?php
header("Content-Type: application/json; charset=UTF-8");

$targetDir = __DIR__ . "/uploads/"; 
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['file']['name'])) {
        $fileName = time() . "_" . basename($_FILES['file']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
            echo json_encode([
                "success" => true, 
                "message" => "Archivo subido correctamente", 
                "file_path" => "uploads/" . $fileName
            ]);
        } else {
            echo json_encode(["success" => false, "error" => "Error al subir el archivo"]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "No se recibió archivo"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Método no soportado"]);
}
?>
