// Datos de ejemplo para los libros
const books = [
    {
        id: 1,
        title: "Cien años de soledad",
        author: "Gabriel García Márquez",
        price: 19.99,
        stock: 15,
        image: "https://imagessl7.casadellibro.com/a/l/s5/17/9788466379717.webp",
        category: "fiction",
        format: "physical",
        description: "Una de las obras maestras de la literatura latinoamericana que narra la historia de la familia Buendía a lo largo de siete generaciones en el pueblo ficticio de Macondo.",
        content: `<h1>Cien años de soledad</h1>
        <h2>Capítulo 1</h2>
        <p>Muchos años después, frente al pelotón de fusilamiento, el coronel Aureliano Buendía había de recordar aquella tarde remota en que su padre lo llevó a conocer el hielo. Macondo era entonces una aldea de veinte casas de barro y cañabrava construidas a la orilla de un río de aguas diáfanas que se precipitaban por un lecho de piedras pulidas, blancas y enormes como huevos prehistóricos. El mundo era tan reciente, que muchas cosas carecían de nombre, y para mencionarlas había que señalarlas con el dedo.</p>
        <p>Todos los años, por el mes de marzo, una familia de gitanos desarrapados plantaba su carpa cerca de la aldea, y con un grande alboroto de pitos y timbales daban a conocer los nuevos inventos. Primero llevaron el imán. Un gitano corpulento, de barba montaraz y manos de gorrión, que se presentó con el nombre de Melquíades, hizo una truculenta demostración pública de lo que él mismo llamaba la octava maravilla de los sabios alquimistas de Macedonia.</p>`
    },
    {
        id: 2,
        title: "El principito",
        author: "Antoine de Saint-Exupéry",
        price: 14.95,
        stock: 20,
        image: "https://imagessl2.casadellibro.com/a/l/s5/92/9788419087492.webp",
        category: "fiction",
        format: "physical",
        description: "Una fábula filosófica sobre la amistad, el amor y el sentido de la vida, narrada a través de los ojos de un pequeño príncipe que viaja por diversos planetas.",
        content: `<h1>El principito</h1>
        <h2>Capítulo 1</h2>
        <p>Cuando yo tenía seis años vi en un libro sobre la selva virgen que se titulaba "Historias vividas", una magnífica lámina. Representaba una serpiente boa que se tragaba a una fiera. En el libro se afirmaba: "La serpiente boa se traga su presa entera, sin masticarla. Luego ya no puede moverse y duerme durante los seis meses que dura su digestión".</p>
        <p>Reflexioné mucho en ese momento sobre las aventuras de la jungla y a mi vez logré trazar con un lápiz de colores mi primer dibujo. Mi dibujo número 1. Era así:</p>`
    },
    {
        id: 3,
        title: "1984",
        author: "George Orwell",
        price: 16.50,
        stock: 8,
        image: "https://images.cdn3.buscalibre.com/fit-in/360x360/f4/ad/f4adafca3285c21412f0aca63bb2e19f.jpg",
        category: "fiction",
        format: "physical",
        description: "Una novela distópica que describe un futuro totalitario donde el gobierno controla cada aspecto de la vida de los ciudadanos, incluyendo sus pensamientos.",
        content: `<h1>1984</h1>
        <h2>Capítulo 1</h2>
        <p>Era un día luminoso y frío de abril y los relojes daban las trece. Winston Smith, con la barbilla hundida en el pecho en su esfuerzo por burlar el molestísimo viento, se deslizó rápidamente por entre las puertas de cristal de las Casas de la Victoria, aunque no con la suficiente rapidez para evitar que una ráfaga polvorienta se colara con él.</p>
        <p>El vestíbulo olía a legumbres cocidas y a esteras viejas. Al fondo, un cartel de colores, demasiado grande para hallarse en un interior, estaba pegado a la pared. Representaba sólo un enorme rostro de más de un metro de anchura: la cara de un hombre de unos cuarenta y cinco años con un gran bigote negro y facciones hermosas e imperturbables. Winston se dirigió hacia las escaleras. Era inútil intentar subir en el ascensor.</p>`
    },
    {
        id: 4,
        title: "Historia del Arte",
        author: "E.H. Gombrich",
        price: 29.99,
        stock: 5,
        image: "https://imagessl8.casadellibro.com/a/l/s5/08/9780714873008.webp",
        category: "non-fiction",
        format: "physical",
        description: "Una obra clásica que recorre la historia del arte desde la antigüedad hasta la época moderna, con un enfoque accesible para todo tipo de lectores.",
        content: `<h1>Historia del Arte</h1>
        <h2>Introducción</h2>
        <p>No existe, realmente, el Arte. Tan sólo hay artistas. Éstos eran en otros tiempos hombres que cogían tierra coloreada y dibujaban toscamente las formas de un bisonte sobre las paredes de una cueva; hoy, compran sus colores y trazan carteles para las estaciones del metro. Entre unos y otros han hecho muchas cosas los artistas. No hay ningún mal en llamar arte a todas estas actividades, mientras tengamos en cuenta que tal palabra puede significar muchas cosas distintas, en épocas y lugares diversos, y mientras advirtamos que el Arte, escrita la palabra con A mayúscula, no existe, pues el Arte con A mayúscula tiene por esencia que ser un fantasma y un ídolo.</p>`
    },
    {
        id: 5,
        title: "Breve historia del tiempo",
        author: "Stephen Hawking",
        price: 18.75,
        stock: 12,
        image: "https://www.planetadelibros.com.mx/usuaris/libros/fotos/376/m_libros/portada_historia-del-tiempo_stephen-hawking_202302171851.jpg",
        category: "non-fiction",
        format: "physical",
        description: "Un libro de divulgación científica que explica conceptos complejos de física y cosmología de manera accesible para el público general.",
        content: `<h1>Breve historia del tiempo</h1>
        <h2>Capítulo 1: Nuestra imagen del universo</h2>
        <p>Un conocido científico (algunos dicen que fue Bertrand Russell) daba una vez una conferencia sobre astronomía. Describía cómo la Tierra giraba alrededor del Sol y cómo éste, a su vez, giraba alrededor del centro de un vasto conjunto de estrellas que llamamos nuestra galaxia. Al final de la charla, una anciana señora se levantó al fondo de la sala y dijo: "Lo que nos ha contado usted son tonterías. El mundo es en realidad una plataforma plana sustentada por el caparazón de una tortuga gigante". El científico sonrió ampliamente antes de replicar: "¿Y sobre qué se sustenta la tortuga?". "Usted es muy listo, joven, muy listo -dijo la señora-. ¡Pero hay tortugas hasta abajo del todo!"</p>`
    },
    {
        id: 6,
        title: "Don Quijote de la Mancha",
        author: "Miguel de Cervantes",
        price: 12.99,
        stock: 0,
        image: "https://images.cdn2.buscalibre.com/fit-in/360x360/a6/5e/a65e980e9c5ece70d648568274eb9ac5.jpg",
        category: "fiction",
        format: "digital",
        description: "La obra cumbre de la literatura española que narra las aventuras del ingenioso hidalgo Don Quijote y su fiel escudero Sancho Panza.",
        content: `<h1>Don Quijote de la Mancha</h1>
        <h2>Capítulo I</h2>
        <p>En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no ha mucho tiempo que vivía un hidalgo de los de lanza en astillero, adarga antigua, rocín flaco y galgo corredor. Una olla de algo más vaca que carnero, salpicón las más noches, duelos y quebrantos los sábados, lantejas los viernes, algún palomino de añadidura los domingos, consumían las tres partes de su hacienda.</p>
        <p>El resto della concluían sayo de velarte, calzas de velludo para las fiestas, con sus pantuflos de lo mesmo, y los días de entresemana se honraba con su vellorí de lo más fino. Tenía en su casa una ama que pasaba de los cuarenta, y una sobrina que no llegaba a los veinte, y un mozo de campo y plaza, que así ensillaba el rocín como tomaba la podadera.</p>`
    },
    {
        id: 7,
        title: "La metamorfosis",
        author: "Franz Kafka",
        price: 9.95,
        stock: 0,
        image: "https://images.cdn2.buscalibre.com/fit-in/360x360/be/e9/bee9773ea6aa90c80b9f0f5e1d99f648.jpg",
        category: "fiction",
        format: "digital",
        description: "La historia de Gregorio Samsa, un comerciante que se despierta un día convertido en un monstruoso insecto, y las consecuencias que esto tiene en su vida y su familia.",
        content: `<h1>La metamorfosis</h1>
        <h2>I</h2>
        <p>Cuando Gregorio Samsa se despertó una mañana después de un sueño intranquilo, se encontró sobre su cama convertido en un monstruoso insecto. Estaba tumbado sobre su espalda dura, y en forma de caparazón y, al levantar un poco la cabeza veía un vientre abombado, parduzco, dividido por partes duras en forma de arco, sobre cuya protuberancia apenas podía mantenerse el cobertor, a punto ya de resbalar al suelo.</p>
        <p>Sus muchas patas, ridículamente pequeñas en comparación con el resto de su tamaño, se agitaban desamparadas ante sus ojos. «¿Qué me ha ocurrido?», pensó. No era un sueño. Su habitación, una auténtica habitación humana, si bien algo pequeña, permanecía tranquila entre las cuatro paredes harto conocidas.</p>`
    },
    {
        id: 8,
        title: "El universo en una cáscara de nuez",
        author: "Stephen Hawking",
        price: 15.50,
        stock: 0,
        image: "https://bibliometro.cl/wp-content/uploads/bfi_thumb/universo-cascara-nuez-245x350-ojdhpcu9uijduoty76ugmkz4ki0ss5vy8i8amwiopk.jpg",
        category: "non-fiction",
        format: "digital",
        description: "Un fascinante viaje por las fronteras de la física teórica, donde Hawking explora las posibilidades de viajes en el tiempo, agujeros negros y otras dimensiones.",
        content: `<h1>El universo en una cáscara de nuez</h1>
        <h2>Capítulo 1: Breve historia de la relatividad</h2>
        <p>Albert Einstein, el descubridor de las teorías especial y general de la relatividad, nació en Ulm, Alemania, en 1879, pero al año siguiente su familia se mudó a Munich, donde su padre, Hermann, y su tío, Jakob, fundaron una pequeña e infructuosa empresa de ingeniería eléctrica. En 1894, cuando la empresa de ingeniería eléctrica fracasó, la familia Einstein se trasladó a Milán, Italia. Einstein debía quedarse en Munich para acabar sus estudios en el Gymnasium Luitpold. Sin embargo, no le gustaba la escuela de allí, así que, a los pocos meses, se fue también a Milán.</p>`
    }
];

// Variable para almacenar los items del carrito
let cartItems = [];

// Inicializar carrito desde session si existe
document.addEventListener('DOMContentLoaded', () => {
    if (typeof window.initialCart !== 'undefined') {
        // Convertir initialCart de objeto a array para compatibilidad
        cartItems = Object.keys(window.initialCart).map(bookId => {
            const item = window.initialCart[bookId];
            const book = books.find(b => b.id === parseInt(bookId)) || {};
            
            return {
                book: {
                    id: parseInt(bookId),
                    title: item.title,
                    price: parseFloat(item.price),
                    format: book.format || "physical",
                    stock: book.stock || 999,
                    image: item.image_url || book.image || "https://via.placeholder.com/50"
                },
                quantity: parseInt(item.quantity)
            };
        });
        
        // Actualizar UI del carrito inmediatamente
        updateCartCount();
    }
});

// Elemento DOM del contador del carrito
const cartCount = document.querySelector('.cart-count');

// Función para renderizar los libros en el catálogo
function renderBooks(booksToRender = books) {
    const booksContainer = document.getElementById('books-container');
    if (!booksContainer) {
        console.error('Books container not found');
        return;
    }
    booksContainer.innerHTML = '';

    booksToRender.forEach(book => {
        const stockClass = book.stock > 10 ? 'in-stock' : book.stock > 0 ? 'low-stock' : 'out-stock';
        const stockText = book.stock > 10 ? 'En stock' : book.stock > 0 ? `¡Solo quedan ${book.stock}!` : 'Agotado';
        const isDigital = book.format === 'digital';
        const formatText = isDigital ? 'Libro Digital' : 'Libro Físico';
        const stockOrReadButton = isDigital ? 
            `<button class="book-btn view-details" onclick="openEbookReader(${book.id})">Leer muestra</button>` : 
            `<p class="stock ${stockClass}">${stockText}</p>`;

        const bookCard = document.createElement('div');
        bookCard.className = `book-card ${stockClass}`;
        bookCard.dataset.category = book.category.toLowerCase();
        bookCard.dataset.format = book.format.toLowerCase();

        bookCard.innerHTML = `
            ${isDigital ? '<i class="fas fa-file-pdf digital-indicator"></i>' : ''}
            <div class="book-image">
                <img src="${book.image}" alt="${book.title}" class="book-img">
            </div>
            <div class="book-info">
                <h3 class="book-title">${book.title}</h3>
                <p class="book-author">${book.author}</p>
                <p class="book-price">${book.price.toFixed(2)}€ <small>(${formatText})</small></p>
                ${stockOrReadButton}
                <div class="book-actions">
                    <form class="add-to-cart-form" data-book-id="${book.id}">
                        <input type="hidden" name="book_id" value="${book.id}">
                        <input type="number" name="quantity" value="1" min="1" max="${book.stock}" class="quantity-input">
                        <button type="submit" name="add_to_cart" class="book-btn add-cart" ${book.stock === 0 && !isDigital ? 'disabled' : ''}>
                            Añadir al carrito
                        </button>
                    </form>
                    <button class="book-btn view-details" onclick="viewBookDetails(${book.id})">
                        Detalles
                    </button>
                </div>
            </div>
        `;

        booksContainer.appendChild(bookCard);
    });
    
    // Re-configurar los eventos después de renderizar los libros
    setupAddToCartForms();
}

// Función para filtrar libros
function filterBooks() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            
            const filter = button.dataset.filter;
            let filteredBooks;
            
            if (filter === 'all') {
                filteredBooks = books;
            } else if (filter === 'fiction' || filter === 'non-fiction') {
                filteredBooks = books.filter(book => book.category === filter);
            } else if (filter === 'digital' || filter === 'physical') {
                filteredBooks = books.filter(book => book.format === filter);
            }
            
            renderBooks(filteredBooks);
        });
    });
}

// Función para añadir un libro al carrito (usando AJAX)
function addToCart(bookId, quantity) {
    const formData = new FormData();
    formData.append('add_to_cart', true);
    formData.append('book_id', bookId);
    formData.append('quantity', quantity);

    fetch('add_to_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log("Respuesta del servidor:", data);
        if (data.success) {
            // Actualizar cartItems con el carrito devuelto por el servidor
            cartItems = Object.keys(data.cart).map(bookId => {
                const item = data.cart[bookId];
                const book = books.find(b => b.id === parseInt(bookId)) || {};
                
                return {
                    book: {
                        id: parseInt(bookId),
                        title: item.title,
                        price: parseFloat(item.price),
                        format: book.format || "physical",
                        stock: book.stock || 999,
                        image: item.image_url || book.image || "https://via.placeholder.com/50"
                    },
                    quantity: parseInt(item.quantity)
                };
            });
            
            updateCartCount();
            renderCartItems();
            //alert(`"${data.cart[bookId].title}" añadido al carrito`);
            // Mostrar mini-notificación sin recargar la página
            showCartNotification(data.cart[bookId].title);
        } else {
            alert(data.message || "Error al añadir el artículo al carrito.");
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
        alert("Error al procesar la solicitud. Revisa la consola para más detalles.");
    });
}

// Función para mostrar una notificación temporal
function showCartNotification(title) {
    // Crear elemento de notificación
    const notification = document.createElement('div');
    notification.className = 'cart-notification';
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-check-circle"></i>
            <span>"${title}" añadido al carrito</span>
        </div>
    `;
    
    // Añadir al body
    document.body.appendChild(notification);
    
    // Mostrar con animación
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);
    
    // Eliminar después de 3 segundos
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Función para actualizar el contador del carrito
function updateCartCount() {
    const totalItems = cartItems.reduce((total, item) => total + item.quantity, 0);
    if (cartCount) {
        cartCount.textContent = totalItems;
        
        // Animación sutil para resaltar el cambio
        cartCount.classList.add('update-animation');
        setTimeout(() => {
            cartCount.classList.remove('update-animation');
        }, 300);
    }
}

// Función para renderizar los items del carrito
function renderCartItems() {
    const cartItemsContainer = document.getElementById('cart-items');
    if (!cartItemsContainer) return;
    
    cartItemsContainer.innerHTML = '';
    
    if (cartItems.length === 0) {
        cartItemsContainer.innerHTML = '<p class="empty-cart">Tu carrito está vacío</p>';
        document.getElementById('cart-total-amount').textContent = '0.00€';
        return;
    }
    
    let total = 0;
    
    cartItems.forEach((item, index) => {
        const subtotal = item.book.price * item.quantity;
        total += subtotal;
        
        const cartItemElement = document.createElement('div');
        cartItemElement.className = 'cart-item';
        cartItemElement.dataset.bookId = item.book.id;
        cartItemElement.innerHTML = `
            <img src="${item.book.image}" alt="${item.book.title}" class="cart-item-img">
            <div class="cart-item-details">
                <h4 class="cart-item-title">${item.book.title}</h4>
                <p class="cart-item-price">${item.book.price.toFixed(2)}€ ${item.book.format === 'digital' ? '(Digital)' : '(Físico)'}</p>
                <div class="cart-item-quantity">
                    <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                    <input type="number" class="quantity-input" value="${item.quantity}" min="1" max="${item.book.format === 'physical' ? item.book.stock : 1}" onchange="updateQuantityInput(${index}, this.value)">
                    <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                </div>
                <button class="remove-item" onclick="removeFromCart(${index})">Eliminar</button>
            </div>
        `;
        
        cartItemsContainer.appendChild(cartItemElement);
    });
    
    if (document.getElementById('cart-total-amount')) {
        document.getElementById('cart-total-amount').textContent = total.toFixed(2) + '€';
    }
}

// Función para actualizar la cantidad de un item en el carrito
function updateQuantity(index, change) {
    const item = cartItems[index];
    const newQuantity = item.quantity + change;
    
    if (newQuantity < 1) return;
    
    if (item.book.format === 'physical' && newQuantity > item.book.stock) return;
    if (item.book.format === 'digital' && newQuantity > 1) return;
    
    item.quantity = newQuantity;
    
    // También actualizar en el servidor
    updateCartInServer(item.book.id, newQuantity);
    
    updateCartCount();
    renderCartItems();
}

// Función para actualizar la cantidad mediante input
function updateQuantityInput(index, value) {
    const item = cartItems[index];
    const newQuantity = parseInt(value);
    
    if (isNaN(newQuantity) || newQuantity < 1) {
        renderCartItems();
        return;
    }
    
    if (item.book.format === 'physical' && newQuantity > item.book.stock) {
        item.quantity = item.book.stock;
    } else if (item.book.format === 'digital' && newQuantity > 1) {
        item.quantity = 1;
    } else {
        item.quantity = newQuantity;
    }
    
    // También actualizar en el servidor
    updateCartInServer(item.book.id, item.quantity);
    
    updateCartCount();
    renderCartItems();
}

// Función para actualizar el carrito en el servidor
function updateCartInServer(bookId, quantity) {
    const formData = new FormData();
    formData.append('update_cart', true);
    formData.append('book_id', bookId);
    formData.append('quantity', quantity);
    
    fetch('update_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log("Carrito actualizado en el servidor:", data);
    })
    .catch(error => {
        console.error("Error al actualizar carrito:", error);
    });
}

// Función para eliminar un item del carrito
function removeFromCart(index) {
    const bookId = cartItems[index].book.id;
    cartItems.splice(index, 1);
    
    // También eliminar en el servidor
    const formData = new FormData();
    formData.append('remove_from_cart', true);
    formData.append('book_id', bookId);
    
    fetch('remove_from_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log("Item eliminado del carrito en el servidor:", data);
    })
    .catch(error => {
        console.error("Error al eliminar item del carrito:", error);
    });
    
    updateCartCount();
    renderCartItems();
}

// Función para mostrar detalles de un libro
function viewBookDetails(bookId) {
    const book = books.find(b => b.id === bookId);
    if (!book) return;
    
    alert(`${book.title} por ${book.author}\n\n${book.description}`);
}

// Funcionalidad para abrir y cerrar el carrito
function setupCart() {
    const cartBtn = document.getElementById('cart-btn');
    const closeCartBtn = document.getElementById('close-cart');
    const cartModal = document.getElementById('cart-modal');
    const overlay = document.getElementById('overlay');
    
    if (cartBtn) {
        cartBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (cartModal) {
                cartModal.classList.add('open');
                if (overlay) overlay.classList.add('active');
                renderCartItems();
            }
        });
    }
    
    if (closeCartBtn) {
        closeCartBtn.addEventListener('click', () => {
            if (cartModal) cartModal.classList.remove('open');
            if (overlay) overlay.classList.remove('active');
        });
    }
    
    if (overlay) {
        overlay.addEventListener('click', () => {
            if (cartModal) cartModal.classList.remove('open');
            overlay.classList.remove('active');
            closeEbookReader();
        });
    }
}

// Funcionalidad para el lector de libros electrónicos
function setupEbookReader() {
    const closeReaderBtn = document.getElementById('close-reader');
    if (!closeReaderBtn) return;
    
    closeReaderBtn.addEventListener('click', closeEbookReader);
}

function openEbookReader(bookId) {
    const book = books.find(b => b.id === bookId);
    if (!book) return;
    
    const readerTitle = document.getElementById('reader-title');
    const readerContent = document.getElementById('reader-content');
    const currentPage = document.getElementById('current-page');
    const totalPages = document.getElementById('total-pages');
    const ebookReader = document.getElementById('ebook-reader');
    const overlay = document.getElementById('overlay');
    
    if (readerTitle) readerTitle.textContent = book.title;
    if (readerContent) readerContent.innerHTML = book.content;
    if (currentPage) currentPage.textContent = '1';
    if (totalPages) totalPages.textContent = '10';
    
    if (ebookReader) ebookReader.classList.add('active');
    if (overlay) overlay.classList.add('active');
}

function closeEbookReader() {
    const ebookReader = document.getElementById('ebook-reader');
    const overlay = document.getElementById('overlay');
    
    if (ebookReader) ebookReader.classList.remove('active');
    if (overlay) overlay.classList.remove('active');
}

// Funcionalidad del formulario de contacto
function setupContactForm() {
    const contactForm = document.getElementById('contact-form');
    if (!contactForm) return;
    
    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const name = contactForm.name.value;
        const email = contactForm.email.value;
        
        alert(`Gracias ${name} por tu mensaje.\nTe responderemos lo antes posible a ${email}.`);
        
        contactForm.reset();
    });
}

// Funcionalidad para manejar navegación suave
function setupSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (!targetElement) return;
            
            e.preventDefault();
            
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth'
            });
        });
    });
}

// Función para manejar el envío de formularios de "Añadir al carrito"
// Función para manejar el envío de formularios de "Añadir al carrito"
function setupAddToCartForms() {
    const forms = document.querySelectorAll('.add-to-cart-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir recarga de página y el envío del formulario tradicional
            
            const bookId = parseInt(this.dataset.bookId || this.querySelector('input[name="book_id"]').value);
            const quantityInput = this.querySelector('input[name="quantity"]');
            const quantity = parseInt(quantityInput.value);
            
            if (isNaN(bookId) || isNaN(quantity) || quantity < 1) {
                console.error("Datos inválidos para añadir al carrito");
                return;
            }
            
            addToCart(bookId, quantity);
        });
    });
}

// Inicializar todas las funcionalidades cuando el DOM está cargado
document.addEventListener('DOMContentLoaded', () => {
    renderBooks();
    filterBooks();
    setupCart();
    setupEbookReader();
    setupContactForm();
    setupSmoothScroll();
    setupAddToCartForms();
    updateCartCount();
});