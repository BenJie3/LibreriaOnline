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
    <title>LibreriaOnline - Tu Biblioteca Virtual</title>
    <link rel="stylesheet" href="styles/index.css">
    <script defer src="scripts/index.js"></script>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Tu mundo literario en un solo lugar</h1>
            <p>Descubre, compra y lee miles de libros en formato físico y digital. La mejor biblioteca a tu alcance.</p>
            <a href="catalogo.php" class="btn">Explorar Catálogo Completo</a>
        </div>
    </section>

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
                            <form method="POST" class="add-to-cart-form">
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
            <div class="view-more">
                <a href="catalogo.php" class="btn">Ver Todo el Catálogo</a>
            </div>
        </div>
    </section>

    <!-- Sobre Nosotros -->
    <section id="about" class="about">
        <div class="container">
            <h2 class="section-title">Sobre Nosotros</h2>
            <div class="about-content">
                <div class="about-image">
                    <img src="img/fachada_de_una_biblioteca.png" alt="Nuestra Biblioteca">
                </div>
                <div class="about-text">
                    <h3>Nuestra Historia</h3>
                    <p>Fundada en 2010, LibreriaOnline nació con la misión de hacer que la literatura de calidad sea accesible para todos. Comenzamos como una pequeña librería local y hemos crecido hasta convertirnos en una plataforma digital con miles de títulos disponibles en formato físico y digital.</p>
                    <p>Nuestro equipo está formado por apasionados lectores y expertos en literatura que se dedican a seleccionar cuidadosamente cada título que ofrecemos. Creemos en el poder transformador de los libros y nos esforzamos por crear una comunidad literaria vibrante y diversa.</p>
                    <h3>Nuestra Misión</h3>
                    <p>En LibreriaOnline, nuestra misión es fomentar el amor por la lectura y hacer que los libros sean accesibles para todos. Nos comprometemos a ofrecer una selección diversa de títulos, un servicio al cliente excepcional y una experiencia de compra y lectura sin complicaciones.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <section id="contact" class="contact">
        <div class="container">
            <h2 class="section-title">Contáctanos</h2>
            <div class="contact-container">
                <div class="contact-info">
                    <h3>Información de Contacto</h3>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Ubicación</h4>
                            <p>Av. de los Libros 123, Ciudad Literaria</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4>Teléfono</h4>
                            <p>+34 912 345 678</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>Email</h4>
                            <p>info@libreriaonline.com</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h4>Horario</h4>
                            <p>Lunes a Viernes: 9:00 - 20:00</p>
                            <p>Sábado: 10:00 - 14:00</p>
                        </div>
                    </div>
                </div>
                <div class="contact-form">
                    <form id="contact-form">
                        <div class="form-group">
                            <label for="name">Nombre completo</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Asunto</label>
                            <select id="subject" name="subject">
                                <option value="consulta">Consulta general</option>
                                <option value="pedido">Información sobre mi pedido</option>
                                <option value="devolucion">Devoluciones</option>
                                <option value="sugerencia">Sugerencias</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Mensaje</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Enviar Mensaje</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
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

    <!-- Lector de libros digitales -->
    <div class="ebook-reader" id="ebook-reader">
        <div class="reader-header">
            <h3 class="reader-title" id="reader-title">Título del Libro</h3>
            <button class="close-reader" id="close-reader">×</button>
        </div>
        <div class="reader-content" id="reader-content">
            <!-- El contenido del libro se cargará dinámicamente -->
        </div>
        <div class="reader-footer">
            <div class="page-controls">
                <button class="page-btn" id="prev-page">Anterior</button>
                <button class="page-btn" id="next-page">Siguiente</button>
            </div>
            <div class="page-info">
                <span id="current-page">1</span> / <span id="total-pages">10</span>
            </div>
        </div>
    </div>
<script>
    const initialCart = <?php echo json_encode($_SESSION['cart'] ?? []); ?>;
</script>
<script defer src="scripts/index.js"></script>
</body>
</html>