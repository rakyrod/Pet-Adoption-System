<?php
require_once 'connect2.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = $_POST['petName'];
        $imageUrl = $_POST['petImage'];
        $age = $_POST['petAge'];
        $type = $_POST['petType'];
        $gender = $_POST['petGender'];
        $yearRescued = $_POST['petYearRescued'];
        $health = $_POST['petHealth'];
        $description = $_POST['petDescription'];

        $sql = "INSERT INTO pet (Name, ImageURL, Age, Type, Gender, Year_Rescued, Health, Description, Adoption_Status) 
                VALUES (:name, :imageUrl, :age, :type, :gender, :yearRescued, :health, :description, 'Available')";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':name' => $name,
            ':imageUrl' => $imageUrl,
            ':age' => $age,
            ':type' => $type,
            ':gender' => $gender,
            ':yearRescued' => $yearRescued,
            ':health' => $health,
            ':description' => $description
        ]);

        if ($result) {
            $petId = $pdo->lastInsertId();
            $newPetData = [
                'Pet_ID' => $petId,
                'Name' => $name,
                'ImageURL' => $imageUrl,
                'Age' => $age,
                'Type' => $type,
                'Gender' => $gender,
                'Year_Rescued' => $yearRescued,
                'Health' => $health,
                'Description' => $description,
                'Adoption_Status' => 'Available'
            ];
            echo json_encode(['success' => true, 'message' => 'Pet added successfully', 'petData' => $newPetData]);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(['success' => false, 'message' => 'Failed to add pet', 'error' => $errorInfo[2]]);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error', 'error' => $e->getMessage()]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'General error', 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}