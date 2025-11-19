// remove_from_cart.php
<?php
session_start();

header('Content-Type: application/json');
$response = ['success' => false, 'cart' => [], 'message' => ''];

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_from_cart'])) {
        $book_id = (int)$_POST['book_id'];
        
        // Asegurarse de que el carrito existe
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Eliminar el producto del carrito
        if (isset($_SESSION['cart'][$book_id])) {
            unset($_SESSION['cart'][$book_id]);
            $response['success'] = true;
            $response['cart'] = $_SESSION['cart'];
            $response['message'] = "Producto eliminado del carrito";
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