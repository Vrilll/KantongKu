<?php
header('Content-Type: application/json'); // Beritahu browser bahwa responsnya adalah JSON
require 'db.php'; // Hubungkan ke database

$action = $_GET['action'] ?? ''; // Ambil aksi dari URL

switch ($action) {
    case 'get':
        $category = $_GET['category'] ?? 'all';
        $date = $_GET['date'] ?? '';
        
        $sql = "SELECT * FROM transactions";
        $conditions = [];
        $params = [];
        $types = '';

        if ($category !== 'all') {
            if (in_array($category, ['income', 'expense'])) {
                $conditions[] = "type = ?";
            } else {
                $conditions[] = "category = ?";
            }
            $params[] = $category;
            $types .= 's';
        }
        
        if (!empty($date)) {
            $conditions[] = "date = ?";
            $params[] = $date;
            $types .= 's';
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY date DESC, id DESC";

        $stmt = $conn->prepare($sql);
        if ($types) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $transactions = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($transactions);
        break;

    case 'add':
        $stmt = $conn->prepare("INSERT INTO transactions (description, amount, type, category, date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsss", $_POST['description'], $_POST['amount'], $_POST['type'], $_POST['category'], $_POST['date']);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        break;

    case 'update':
        $stmt = $conn->prepare("UPDATE transactions SET description = ?, amount = ?, type = ?, category = ?, date = ? WHERE id = ?");
        $stmt->bind_param("sdsssi", $_POST['description'], $_POST['amount'], $_POST['type'], $_POST['category'], $_POST['date'], $_POST['id']);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        break;

    case 'delete':
        $stmt = $conn->prepare("DELETE FROM transactions WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Aksi tidak valid']);
        break;
}

$conn->close();
?>