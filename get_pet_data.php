<?php
require_once 'connect.php';
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $petId = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT name, age, sex, year_rescued, health, description FROM pet WHERE id = ?");
    $stmt->bind_param("i", $petId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pet = $result->fetch_assoc();
        echo json_encode(['success' => true, 'pet' => $pet]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Pet not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'No pet ID provided']);
}

$conn->close();
?>