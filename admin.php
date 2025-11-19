<?php
session_start();
// Database connection
include 'conexion.php';

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

// Manejar altas (añadir libros)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $image = $_POST['image'];
    $category = $_POST['category'];
    $format = $_POST['format'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO books (title, author, price, stock, image_url, category, format, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $author, $price, $stock, $image, $category, $format, $description]);
    $success_message = "Libro añadido correctamente.";
}

// Manejar bajas (eliminar libros)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_book'])) {
    $book_id = intval($_POST['book_id']);
    $stmt = $pdo->prepare("DELETE FROM books WHERE book_id = ?");
    $stmt->execute([$book_id]);
    $success_message = "Libro eliminado correctamente.";
}

// Manejar actualizaciones (editar libros)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_book'])) {
    $book_id = intval($_POST['book_id']);
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $image = $_POST['image'];
    $category = $_POST['category'];
    $format = $_POST['format'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE books SET title = ?, author = ?, price = ?, stock = ?, image_url = ?, category = ?, format = ?, description = ? WHERE book_id = ?");
    $stmt->execute([$title, $author, $price, $stock, $image, $category, $format, $description, $book_id]);
    $success_message = "Libro actualizado correctamente.";
}

// Obtener todos los libros para la consulta
$stmt = $pdo->prepare("SELECT * FROM books");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador - LibreriaOnline</title>
    <link rel="stylesheet" href="styles/index.css"> <!-- Usar el mismo CSS que index.php -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> <!-- Font Awesome para íconos -->
    <style>
        /* Estilo adicional para la tabla y formularios, si no está en styles.css */
        .admin-section {
            margin: 40px 0;
        }
        .admin-section .section-title {
            margin-bottom: 20px;
        }
        .admin-section form {
            max-width: 600px;
            margin: 0 auto;
        }
        .admin-section .form-group {
            margin-bottom: 15px;
        }
        .admin-section .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .admin-section .form-group input,
        .admin-section .form-group select,
        .admin-section .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .admin-section .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        .admin-section .btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .admin-section .btn.submit-btn {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .admin-section .btn.submit-btn:hover {
            background-color: #0056b3;
        }
        .admin-section .btn.cancel-btn {
            background-color: #6c757d;
            color: white;
            border: none;
            margin-left: 10px;
        }
        .admin-section .btn.cancel-btn:hover {
            background-color: #5a6268;
        }
        .book-table {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .book-table th,
        .book-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .book-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .book-table td {
            vertical-align: middle;
        }
        .book-table .btn {
            padding: 8px 12px;
            font-size: 14px;
            margin-right: 5px;
        }
        .book-table .btn.edit-btn {
            background-color: #28a745;
            color: white;
            border: none;
        }
        .book-table .btn.edit-btn:hover {
            background-color: #218838;
        }
        .book-table .btn.delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
        }
        .book-table .btn.delete-btn:hover {
            background-color: #c82333;
        }
        .success-message {
            color: #28a745;
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <!-- Header idéntico al de index.php -->
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
                            <li><a href="admin.php">Panel de Administrador</a></li>
                            <li><a href="profile.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                            <li><a href="logout.php">Cerrar Sesión</a></li>
                        <?php else: ?>
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
                        <li><a href="login.php">Iniciar Sesión</a></li>
                        <li><a href="register.php">Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="admin-section">
            <div class="container">
                <h2 class="section-title">Panel de Administrador</h2>
                <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

                <?php if (isset($success_message)): ?>
                    <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
                <?php endif; ?>

                <!-- Sección para añadir libros (Altas) -->
                <div class="admin-section">
                    <h3 class="section-title">Añadir Nuevo Libro</h3>
                    <form method="POST" action="admin.php">
                        <input type="hidden" name="add_book" value="1">
                        <div class="form-group">
                            <label for="title">Título:</label>
                            <input type="text" name="title" id="title" required>
                        </div>
                        <div class="form-group">
                            <label for="author">Autor:</label>
                            <input type="text" name="author" id="author" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Precio (€):</label>
                            <input type="number" name="price" id="price" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock:</label>
                            <input type="number" name="stock" id="stock" required>
                        </div>
                        <div class="form-group">
                            <label for="image">URL de la Imagen:</label>
                            <input type="text" name="image" id="image" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Categoría:</label>
                            <select name="category" id="category" required>
                                <option value="fiction">Ficción</option>
                                <option value="non-fiction">No Ficción</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="format">Formato:</label>
                            <select name="format" id="format" required>
                                <option value="physical">Físico</option>
                                <option value="digital">Digital</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción:</label>
                            <textarea name="description" id="description" required></textarea>
                        </div>
                        <button type="submit" class="btn submit-btn">Añadir Libro</button>
                    </form>
                </div>

                <!-- Sección para consultar y editar libros -->
                <div class="admin-section">
                    <h3 class="section-title">Consultar y Editar Libros</h3>
                    <table class="book-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Precio (€)</th>
                                <th>Stock</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($books as $book): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($book['book_id']); ?></td>
                                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                                    <td><?php echo number_format($book['price'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($book['stock']); ?></td>
                                    <td>
                                        <!-- Formulario para editar -->
                                        <form method="POST" action="admin.php" style="display:inline;">
                                            <input type="hidden" name="edit_book" value="1">
                                            <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                                            <button type="button" class="btn edit-btn" onclick="fillEditForm(<?php echo $book['book_id']; ?>, '<?php echo htmlspecialchars($book['title'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($book['author'], ENT_QUOTES); ?>', <?php echo $book['price']; ?>, <?php echo $book['stock']; ?>, '<?php echo htmlspecialchars($book['image_url'], ENT_QUOTES); ?>', '<?php echo $book['category']; ?>', '<?php echo $book['format']; ?>', '<?php echo htmlspecialchars($book['description'], ENT_QUOTES); ?>')">Editar</button>
                                        </form>
                                        <!-- Formulario para eliminar -->
                                        <form method="POST" action="admin.php" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este libro?');">
                                            <input type="hidden" name="delete_book" value="1">
                                            <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                                            <button type="submit" class="btn delete-btn">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Formulario oculto para editar libros -->
                <div class="admin-section" id="edit-book-section" style="display:none;">
                    <h3 class="section-title">Editar Libro</h3>
                    <form method="POST" action="admin.php">
                        <input type="hidden" name="edit_book" value="1">
                        <input type="hidden" name="book_id" id="edit-book-id">
                        <div class="form-group">
                            <label for="edit-title">Título:</label>
                            <input type="text" name="title" id="edit-title" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-author">Autor:</label>
                            <input type="text" name="author" id="edit-author" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-price">Precio (€):</label>
                            <input type="number" name="price" id="edit-price" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-stock">Stock:</label>
                            <input type="number" name="stock" id="edit-stock" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-image">URL de la Imagen:</label>
                            <input type="text" name="image" id="edit-image" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-category">Categoría:</label>
                            <select name="category" id="edit-category" required>
                                <option value="fiction">Ficción</option>
                                <option value="non-fiction">No Ficción</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-format">Formato:</label>
                            <select name="format" id="edit-format" required>
                                <option value="physical">Físico</option>
                                <option value="digital">Digital</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-description">Descripción:</label>
                            <textarea name="description" id="edit-description" required></textarea>
                        </div>
                        <button type="submit" class="btn submit-btn">Guardar Cambios</button>
                        <button type="button" class="btn cancel-btn" onclick="cancelEdit()">Cancelar</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>© 2025 LibreriaOnline. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        function fillEditForm(bookId, title, author, price, stock, image, category, format, description) {
            document.getElementById('edit-book-section').style.display = 'block';
            document.getElementById('edit-book-id').value = bookId;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-author').value = author;
            document.getElementById('edit-price').value = price;
            document.getElementById('edit-stock').value = stock;
            document.getElementById('edit-image').value = image;
            document.getElementById('edit-category').value = category;
            document.getElementById('edit-format').value = format;
            document.getElementById('edit-description').value = description;
            window.scrollTo({ top: document.getElementById('edit-book-section').offsetTop - 80, behavior: 'smooth' });
        }

        function cancelEdit() {
            document.getElementById('edit-book-section').style.display = 'none';
        }
    </script>
</body>
</html>