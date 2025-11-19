<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=checkout.php");
    exit;
}

// Database connection
include 'conexion.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Manejar la eliminación de un producto del carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_from_cart'])) {
    $book_id = intval($_POST['book_id']);
    if (isset($_SESSION['cart'][$book_id])) {
        unset($_SESSION['cart'][$book_id]); // Eliminar el producto de la sesión
        // Si el carrito está vacío, eliminar la variable de sesión
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }
    // Redirigir a la misma página para actualizar la vista
    header("Location: checkout.php");
    exit;
}

// Fetch user details for pre-filling shipping address
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT first_name, last_name, address, phone FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['remove_from_cart'])) {
    $shipping_address = htmlspecialchars(trim($_POST['shipping_address']));
    $card_number = htmlspecialchars(trim($_POST['card_number']));
    $card_expiry = htmlspecialchars(trim($_POST['card_expiry']));
    $card_cvc = htmlspecialchars(trim($_POST['card_cvc']));

    // Validate inputs
    if (empty($shipping_address)) {
        $errors[] = "La dirección de envío es obligatoria";
    }
    if (empty($card_number) || !preg_match('/^\d{16}$/', $card_number)) {
        $errors[] = "El número de tarjeta debe tener 16 dígitos";
    }
    if (empty($card_expiry) || !preg_match('/^\d{2}\/\d{2}$/', $card_expiry)) {
        $errors[] = "La fecha de expiración debe ser en formato MM/AA";
    }
    if (empty($card_cvc) || !preg_match('/^\d{3}$/', $card_cvc)) {
        $errors[] = "El CVC debe tener 3 dígitos";
    }

    // Validate cart
    if (empty($_SESSION['cart'])) {
        $errors[] = "El carrito está vacío";
    } else {
        foreach ($_SESSION['cart'] as $book_id => $item) {
            $stmt = $pdo->prepare("SELECT stock FROM books WHERE book_id = ?");
            $stmt->execute([$book_id]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$book || $book['stock'] < $item['quantity']) {
                $errors[] = "El libro '{$item['title']}' no está disponible en la cantidad solicitada";
            }
        }
    }

    // Process order if no errors
    if (empty($errors)) {
        $pdo->beginTransaction();
        try {
            // Calculate total
            $total_amount = 0;
            foreach ($_SESSION['cart'] as $item) {
                $total_amount += $item['price'] * $item['quantity'];
            }

            // Insert order
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, status, shipping_address) VALUES (?, ?, 'pending', ?)");
            $stmt->execute([$user_id, $total_amount, $shipping_address]);
            $order_id = $pdo->lastInsertId();

            // Insert order items and update stock
            foreach ($_SESSION['cart'] as $book_id => $item) {
                $stmt = $pdo->prepare("INSERT INTO order_items (order_id, book_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
                $stmt->execute([$order_id, $book_id, $item['quantity'], $item['price']]);

                // Update stock
                $stmt = $pdo->prepare("UPDATE books SET stock = stock - ? WHERE book_id = ?");
                $stmt->execute([$item['quantity'], $book_id]);
            }

            $pdo->commit();

            // Generar el PDF con FPDF
            require('fpdf.php'); // Asegúrate de que la ruta sea correcta
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'Recibo de Compra - LibreriaOnline', 0, 1, 'C');
            $pdf->Ln(10);

            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, 'Numero de Pedido: #' . $order_id, 0, 1);
            $pdf->Cell(0, 10, 'Fecha: ' . date('d/m/Y H:i:s'), 0, 1);
            $pdf->Cell(0, 10, 'Cliente: ' . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']), 0, 1);
            $pdf->Cell(0, 10, 'Direccion de Envio: ' . htmlspecialchars($shipping_address), 0, 1);
            $pdf->Ln(10);

            // Detalles de los productos
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(80, 10, 'Producto', 1);
            $pdf->Cell(30, 10, 'Cantidad', 1);
            $pdf->Cell(40, 10, 'Precio Unitario', 1);
            $pdf->Cell(40, 10, 'Subtotal', 1);
            $pdf->Ln();

            $pdf->SetFont('Arial', '', 12);
            foreach ($_SESSION['cart'] as $item) {
                $pdf->Cell(80, 10, htmlspecialchars($item['title']), 1);
                $pdf->Cell(30, 10, $item['quantity'], 1);
                $pdf->Cell(40, 10, 'EUR' . number_format($item['price'], 2), 1);
                $pdf->Cell(40, 10, 'EUR' . number_format($item['price'] * $item['quantity'], 2), 1);
                $pdf->Ln();
            }

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, 'Total: EUR' . number_format($total_amount, 2), 0, 1, 'R');

            // Enviar el PDF al navegador para descarga
            $pdf_file = 'recibo_' . $order_id . '.pdf';
            $pdf->Output('D', $pdf_file);

            $_SESSION['cart'] = []; // Clear cart
            $success = "¡Pedido realizado con éxito! Tu número de pedido es #$order_id. El recibo se ha descargado.";
        } catch (Exception $e) {
            $pdo->rollBack();
            $errors[] = "Error al procesar el pedido: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra - LibreriaOnline</title>
    <link rel="stylesheet" href="styles/checkout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script defer src="../scripts/checkout.js"></script>
    <style>
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .order-table th,
        .order-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .order-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .order-table td {
            vertical-align: middle;
        }
        .quantity-input {
            width: 60px;
            padding: 5px;
            text-align: center;
        }
        .subtotal {
            font-weight: bold;
        }
        .order-total {
            text-align: right;
            margin-top: 10px;
            font-size: 18px;
        }
        .btn.delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn.delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-container">
            <div class="logo">
                <i class="fas fa-book"></i>
                <span>LibreriaOnline</span>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="catalogo.php">Catálogo</a></li>
                    <li><a href="profile.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="checkout-section">
        <div class="container">
            <h2 class="section-title">Finalizar Compra</h2>
            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success-message">
                    <p><?php echo htmlspecialchars($success); ?></p>
                    <a href="profile.php" class="btn">Ver Mis Pedidos</a>
                </div>
            <?php else: ?>
                <div class="checkout-container">
                    <!-- Order Summary -->
                    <div class="order-summary">
                        <h3>Resumen del Pedido</h3>
                        <?php if (empty($_SESSION['cart'])): ?>
                            <p>Tu carrito está vacío.</p>
                        <?php else: ?>
                            <table class="order-table">
                                <thead>
                                    <tr>
                                        <th>Libro</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; ?>
                                    <?php foreach ($_SESSION['cart'] as $book_id => $item): ?>
                                        <tr data-book-id="<?php echo $book_id; ?>">
                                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                                            <td>€<?php echo number_format($item['price'], 2); ?></td>
                                            <td>
                                                <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1" data-price="<?php echo $item['price']; ?>">
                                            </td>
                                            <td class="subtotal">€<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                            <td>
                                                <form method="POST" action="checkout.php" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este producto del carrito?');">
                                                    <input type="hidden" name="remove_from_cart" value="1">
                                                    <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                                                    <button type="submit" class="btn delete-btn">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php $total += $item['price'] * $item['quantity']; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="order-total">
                                <strong>Total:</strong>
                                <span id="order-total">€<?php echo number_format($total, 2); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Checkout Form -->
                    <div class="checkout-form">
                        <h3>Detalles de Envío y Pago</h3>
                        <form id="checkout-form" method="POST" action="checkout.php">
                            <div class="form-group">
                                <label for="shipping_address">Dirección de Envío</label>
                                <textarea id="shipping_address" name="shipping_address" required><?php echo htmlspecialchars($user['address'] ?: ''); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="card_number">Número de Tarjeta</label>
                                <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>
                            </div>
                            <div class="form-group card-details">
                                <div>
                                    <label for="card_expiry">Expiración</label>
                                    <input type="text" id="card_expiry" name="card_expiry" placeholder="MM/AA" required>
                                </div>
                                <div>
                                    <label for="card_cvc">CVC</label>
                                    <input type="text" id="card_cvc" name="card_cvc" placeholder="123" required>
                                </div>
                            </div>
                            <button type="submit" class="btn submit-btn">Confirmar Pedido</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>