<?php
session_start();

// Database connection
include 'conexion.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$response = ['success' => false];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_to_cart'])) {
        $book_id = (int)$_POST['book_id'];
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        // Fetch book details
        $stmt = $pdo->prepare("SELECT book_id, title, price, stock FROM books WHERE book_id = ?");
        $stmt->execute([$book_id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($book && $book['stock'] >= $quantity) {
            if (isset($_SESSION['cart'][$book_id])) {
                $_SESSION['cart'][$book_id]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$book_id] = [
                    'title' => $book['title'],
                    'price' => $book['price'],
                    'quantity' => $quantity
                ];
            }
            $response['success'] = true;
        }
    } elseif (isset($_POST['book_id']) && isset($_POST['quantity']) && isset($_POST['action'])) {
        $book_id = (int)$_POST['book_id'];
        $quantity = (int)$_POST['quantity'];
        $action = $_POST['action'];

        if ($action === 'update' && $quantity > 0) {
            if (isset($_SESSION['cart'][$book_id])) {
                $_SESSION['cart'][$book_id]['quantity'] = $quantity;
                $response['success'] = true;
            }
        } elseif ($action === 'remove') {
            if (isset($_SESSION['cart'][$book_id])) {
                unset($_SESSION['cart'][$book_id]);
                $response['success'] = true;
            }
        }
    }

    // Calculate cart totals
    $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));
    $cartTotal = 0;
    foreach ($_SESSION['cart'] as $item) {
        $cartTotal += $item['price'] * $item['quantity'];
    }

    $response['cartCount'] = $cartCount;
    $response['cartTotal'] = $cartTotal;

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Handle get_cart action to refresh cart items
if (isset($_GET['action']) && $_GET['action'] === 'get_cart') {
    if (empty($_SESSION['cart'])) {
        echo '<p>Tu carrito está vacío.</p>';
    } else {
        $total = 0;
        foreach ($_SESSION['cart'] as $book_id => $item) {
            echo '<div class="cart-item" data-book-id="' . $book_id . '">';
            echo '<span class="cart-item-title">' . htmlspecialchars($item['title']) . '</span>';
            echo '<span class="cart-item-price">€' . number_format($item['price'], 2) . '</span>';
            echo '<input type="number" class="cart-item-quantity" value="' . $item['quantity'] . '" min="1">';
            echo '<span class="cart-item-subtotal">€' . number_format($item['price'] * $item['quantity'], 2) . '</span>';
            echo '<button class="remove-item">Eliminar</button>';
            echo '</div>';
            $total += $item['price'] * $item['quantity'];
        }
    }
    exit;
}
?>