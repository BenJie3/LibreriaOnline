<?php
session_start();

// Database connection
include 'conexion.php';

// Fetch featured books (e.g., limit to 6 for homepage)
$stmt = $pdo->query("SELECT book_id, title, author, price, category, image_url, stock FROM books LIMIT 6");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
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
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibreriaOnline - Catálogo</title>
    <link rel="stylesheet" href="styles/index.css">
    <script defer src="scripts/catalogo.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
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
                <li><a href="#about">Sobre Nosotros</a></li>
                <li><a href="#contact">Contacto</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <!-- Mostrar solo opciones relevantes para el administrador -->
                        <li><a href="admin.php">Panel de Administrador</a></li>
                        <li><a href="profile.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                        <li><a href="logout.php">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <!-- Opciones para usuarios normales -->
                        <li>
                            <a href="#" class="cart-icon" id="cart-btn">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="cart-count"><?php echo array_sum(array_column($_SESSION['cart'] ?? [], 'quantity')); ?></span>
                            </a>
                        </li>
                        <li><a href="profile.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                        <li><a href="logout.php">Cerrar Sesión</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- Opciones para usuarios no logueados -->
                    <li><a href="login.php">Iniciar Sesión</a></li>
                    <li><a href="register.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

    <!-- Catálogo de Libros -->
    <section id="catalog" class="catalog">
        <div class="container">
            <h2 class="section-title">Nuestro Catálogo</h2>
            <div class="filters">
                <button class="filter-btn active" data-filter="all">Todos</button>
                <button class="filter-btn" data-filter="fiction">Ficción</button>
                <button class="filter-btn" data-filter="non-fiction">No Ficción</button>
                <button class="filter-btn" data-filter="digital">Digitales</button>
                <button class="filter-btn" data-filter="physical">Físicos</button>
            </div>
            <div class="books-grid" id="books-container">
                <?php foreach ($books as $book): ?>
    <div class="book-card" data-category="<?php echo htmlspecialchars($book['category']); ?>">
        <img src="<?php echo htmlspecialchars($book['image_url']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
        <h3><?php echo htmlspecialchars($book['title']); ?></h3>
        <p class="author"><?php echo htmlspecialchars($book['author']); ?></p>
        <p class="price">€<?php echo number_format($book['price'], 2); ?></p>
        <?php if ($book['stock'] > 0): ?>
            <!-- Eliminar el atributo method="POST" para que no envíe el formulario por POST -->
            <form class="add-to-cart-form" data-book-id="<?php echo $book['book_id']; ?>">
                <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $book['stock']; ?>" class="quantity-input">
                <button type="submit" name="add_to_cart" class="btn add-to-cart">Añadir al Carrito</button>
            </form>
        <?php else: ?>
            <p class="out-of-stock">Agotado</p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Carrito de Compras -->
    <div class="overlay" id="overlay"></div>
    <div class="cart-modal" id="cart-modal">
        <div class="cart-header">
            <h3>Tu Carrito</h3>
            <button class="close-cart" id="close-cart">×</button>
        </div>
        <div class="cart-items" id="cart-items">
            <?php if (empty($_SESSION['cart'])): ?>
                <p>Tu carrito está vacío.</p>
            <?php else: ?>
                <?php $total = 0; ?>
                <?php foreach ($_SESSION['cart'] as $book_id => $item): ?>
                    <div class="cart-item" data-book-id="<?php echo $book_id; ?>">
                        <span class="cart-item-title"><?php echo htmlspecialchars($item['title']); ?></span>
                        <span class="cart-item-price">€<?php echo number_format($item['price'], 2); ?></span>
                        <input type="number" class="cart-item-quantity" value="<?php echo $item['quantity']; ?>" min="1">
                        <span class="cart-item-subtotal">€<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                        <button class="remove-item">Eliminar</button>
                    </div>
                    <?php $total += $item['price'] * $item['quantity']; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="cart-total">
            <div class="total-text">
                <span>Total:</span>
                <span id="cart-total-amount">€<?php echo number_format($total ?? 0, 2); ?></span>
            </div>
            <a href="checkout.php" class="checkout-btn btn">Finalizar Compra</a>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h4>LibreriaOnline</h4>
                    <p>Tu destino literario con miles de libros en formato físico y digital. Explora, compra y lee en cualquier momento y lugar.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h4>Enlaces Rápidos</h4>
                    <ul class="footer-links">
                        <li><a href="catalogo.php">Catálogo</a></li>
                        <li><a href="#about">Sobre Nosotros</a></li>
                        <li><a href="#contact">Contacto</a></li>
                        <li><a href="profile.php">Mi Cuenta</a></li>
                        <li><a href="#">Mis Libros Digitales</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Categorías</h4>
                    <ul class="footer-links">
                        <li><a href="catalogo.php?category=fiction">Ficción</a></li>
                        <li><a href="catalogo.php?category=non-fiction">No Ficción</a></li>
                        <li><a href="catalogo.php?category=digital">Digitales</a></li>
                        <li><a href="catalogo.php?category=physical">Físicos</a></li>
                        <li><a href="catalogo.php">Novedades</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Ayuda & Soporte</h4>
                    <ul class="footer-links">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Envíos</a></li>
                        <li><a href="#">Devoluciones</a></li>
                        <li><a href="#">Términos y Condiciones</a></li>
                        <li><a href="#">Política de Privacidad</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>© 2025 LibreriaOnline. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
<script>
    // Pasar el carrito del backend al frontend
    const initialCart = <?php echo json_encode($_SESSION['cart'] ?? []); ?>;
</script>
<script defer src="scripts/catalogo.js"></script>
</body>
</html>