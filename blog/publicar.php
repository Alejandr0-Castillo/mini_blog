<?php
include 'db.php';

header('Content-Type: application/json');

try {
    $titulo = trim($_POST['titulo'] ?? '');
    $contenido = trim($_POST['contenido'] ?? '');

    if ($titulo === '' || $contenido === '') {
        echo json_encode(['success' => false, 'message' => 'Campos vacíos']);
        exit;
    }

    $stmt = $conexion->prepare("INSERT INTO posts (titulo, contenido) VALUES (?, ?)");
    $stmt->bind_param("ss", $titulo, $contenido);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al insertar en la base de datos']);
    }

    $stmt->close();
    $conexion->close();

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Excepción: ' . $e->getMessage()]);
}
