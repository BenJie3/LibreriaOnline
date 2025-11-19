<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=profile.php");
    exit;
}

// Database connection
include 'conexion.php';

// Fetch user details
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, email, first_name, last_name, address, phone FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle AJAX form submission for profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_profile'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);

    $response = ['success' => false, 'errors' => []];

    if (empty($first_name) || empty($last_name)) {
        $response['errors'][] = "El nombre y apellido son obligatorios.";
    } else {
        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, address = ?, phone = ? WHERE user_id = ?");
        $stmt->execute([$first_name, $last_name, $address, $phone, $user_id]);
        $response['success'] = true;
        $response['message'] = "Perfil actualizado con éxito.";
        $response['user'] = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'address' => $address,
            'phone' => $phone
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Fetch user orders
$stmt = $pdo->prepare("SELECT order_id, total_amount, status, shipping_address, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch order items for each order
$order_items = [];
foreach ($orders as $order) {
    $stmt = $pdo->prepare("
        SELECT oi.book_id, oi.quantity, oi.unit_price, b.title 
        FROM order_items oi 
        JOIN books b ON oi.book_id = b.book_id 
        WHERE oi.order_id = ?
    ");
    $stmt->execute([$order['order_id']]);
    $order_items[$order['order_id']] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - LibreriaOnline</title>
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script defer src="scripts/profile.js"></script>
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

    <section class="profile-section">
        <div class="container">
            <h2 class="section-title">Mi Perfil</h2>
            <div class="profile-details">
                <h3>Información Personal</h3>
                <div id="profile-messages"></div>
                <p><strong>Nombre de usuario:</strong> <span id="username"><?php echo htmlspecialchars($user['username']); ?></span></p>
                <p><strong>Email:</strong> <span id="email"><?php echo htmlspecialchars($user['email']); ?></span></p>
                <p><strong>Nombre:</strong> <span id="full-name"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></span></p>
                <p><strong>Dirección:</strong> <span id="address"><?php echo htmlspecialchars($user['address'] ?: 'No especificada'); ?></span></p>
                <p><strong>Teléfono:</strong> <span id="phone"><?php echo htmlspecialchars($user['phone'] ?: 'No especificado'); ?></span></p>
                <button class="btn edit-profile-btn" id="edit-profile-btn">Editar Perfil</button>
            </div>
            <div class="edit-profile" style="display: none;">
                <h3>Editar Perfil</h3>
                <form id="update-profile-form" class="update-profile-form">
                    <input type="hidden" name="save_profile" value="1">
                    <div class="form-group">
                        <label for="first_name">Nombre</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Apellido</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Dirección</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address'] ?: ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?: ''); ?>">
                    </div>
                    <button type="submit" class="submit-btn">Guardar Cambios</button>
                    <button type="button" class="btn cancel-edit" id="cancel-edit-btn">Cancelar</button>
                </form>
            </div>
            <div class="order-history">
                <h3>Historial de Pedidos</h3>
                <?php if (empty($orders)): ?>
                    <p>No tienes pedidos registrados.</p>
                <?php else: ?>
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Pedido #</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                    <td>€<?php echo number_format($order['total_amount'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                                    <td>
                                        <button class="btn view-details" data-order-id="<?php echo $order['order_id']; ?>">Ver Detalles</button>
                                    </td>
                                </tr>
                                <tr class="order-details" id="details-<?php echo $order['order_id']; ?>" style="display: none;">
                                    <td colspan="5">
                                        <strong>Dirección de envío:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?><br>
                                        <strong>Artículos:</strong>
                                        <ul>
                                            <?php foreach ($order_items[$order['order_id']] as $item): ?>
                                                <li>
                                                    <?php echo htmlspecialchars($item['title']); ?> 
                                                    (x<?php echo $item['quantity']; ?>) 
                                                    - €<?php echo number_format($item['unit_price'] * $item['quantity'], 2); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>
</html>