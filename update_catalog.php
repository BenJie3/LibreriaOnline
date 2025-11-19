<?php
header('Content-Type: application/json');

session_start();

$host = 'localhost';
$dbname = 'libreriaonline';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT book_id, title, author, price, category, image_url, stock FROM books");
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'books' => $books]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>