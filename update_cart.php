// update_cart.php
<?php
session_start();

header('Content-Type: application/json');
$response = ['success' => false, 'cart' => [], 'message' => ''];

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_cart'])) {
        $book_id = (int)$_POST['book_id'];
        $quantity = (int)$_POST['quantity'];
        
        // Asegurarse de que el carrito existe
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Actualizar cantidad en el carrito
        if (isset($_SESSION['cart'][$book_id])) {
            $_SESSION['cart'][$book_id]['quantity'] = $quantity;
            $response['success'] = true;
            $response['cart'] = $_SESSION['cart'];
            $response['message'] = "Cantidad actualizada";
        } else {
            $response['message'] = "El producto no existe en el carrito";
        }
    } else {
        $response['message'] = "Solicitud inválida";
    }
} catch (Exception $e) {
    $response['message'] = "Error: " . $e->getMessage();
}

echo json_encode($response);
exit;