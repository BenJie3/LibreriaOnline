<?php
session_start();

// Database connection
include 'conexion.php';

header('Content-Type: application/json');

$response = ['success' => false, 'cart' => [], 'message' => ''];

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
        $book_id = (int)$_POST['book_id'];
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        // Initialize cart if not exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $stmt = $pdo->prepare("SELECT book_id, title, price, stock, image_url FROM books WHERE book_id = ?");
        $stmt->execute([$book_id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($book) {
            // Comprobar si hay stock suficiente
            if ($book['stock'] >= $quantity) {
                if (isset($_SESSION['cart'][$book_id])) {
                    // Si el libro ya está en el carrito, incrementar cantidad
                    $_SESSION['cart'][$book_id]['quantity'] = $quantity;
                } else {
                    // Si el libro no está en el carrito, añadirlo
                    $_SESSION['cart'][$book_id] = [
                        'title' => $book['title'],
                        'price' => floatval($book['price']),
                        'quantity' => $quantity,
                        'image_url' => $book['image_url']
                    ];
                }
                
                $response['success'] = true;
                $response['cart'] = $_SESSION['cart'];
                $response['message'] = "Producto añadido correctamente";
                error_log("Artículo añadido al carrito: book_id=$book_id, title={$book['title']}, quantity=$quantity");
            } else {
                $response['message'] = "No hay suficiente stock disponible";
                error_log("Error al añadir artículo: book_id=$book_id, stock insuficiente");
            }
        } else {
            $response['message'] = "Libro no encontrado";
            error_log("Error al añadir artículo: book_id=$book_id no encontrado en la base de datos");
        }
    } else {
        $response['message'] = "Solicitud inválida";
        error_log("Solicitud POST inválida en add_to_cart.php");
    }
} catch (Exception $e) {
    $response['message'] = "Error interno: " . $e->getMessage();
    error_log("Excepción en add_to_cart.php: " . $e->getMessage());
}

echo json_encode($response);
exit;
?>