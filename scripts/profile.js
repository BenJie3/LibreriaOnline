document.addEventListener('DOMContentLoaded', () => {
    // Ensure DOM is fully loaded before attaching events
    const editProfileBtn = document.getElementById('edit-profile-btn');
    const cancelEditBtn = document.getElementById('cancel-edit-btn');
    const editProfileSection = document.querySelector('.edit-profile');
    const updateProfileForm = document.getElementById('update-profile-form');
    const profileMessages = document.getElementById('profile-messages');

    if (!editProfileBtn || !cancelEditBtn || !editProfileSection || !updateProfileForm) {
        console.error('One or more elements not found in the DOM');
        return;
    }

    // Toggle edit profile form visibility
    editProfileBtn.addEventListener('click', () => {
        editProfileSection.style.display = 'block';
    });

    cancelEditBtn.addEventListener('click', () => {
        editProfileSection.style.display = 'none';
    });

    // Handle profile form submission with AJAX
    updateProfileForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Client-side validation
        const firstName = document.getElementById('first_name').value.trim();
        const lastName = document.getElementById('last_name').value.trim();
        const address = document.getElementById('address').value.trim();
        const phone = document.getElementById('phone').value.trim();

        let errors = [];
        if (!firstName || !lastName) {
            errors.push('El nombre y apellido son obligatorios.');
        }
        if (phone && !/^\+?\d{7,15}$/.test(phone)) {
            errors.push('El teléfono debe ser un número válido (7-15 dígitos).');
        }

        if (errors.length > 0) {
            profileMessages.innerHTML = `
                <div class="error-messages">
                    ${errors.map(error => `<p>${error}</p>`).join('')}
                </div>
            `;
            return;
        }

        // Clear previous messages
        profileMessages.innerHTML = '';

        // Submit form via AJAX
        const formData = new FormData(updateProfileForm);
        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the displayed profile details
                document.getElementById('full-name').textContent = `${data.user.first_name} ${data.user.last_name}`;
                document.getElementById('address').textContent = data.user.address || 'No especificada';
                document.getElementById('phone').textContent = data.user.phone || 'No especificado';

                // Show success message
                profileMessages.innerHTML = `
                    <div class="success-message">
                        <p>${data.message}</p>
                    </div>
                `;

                // Hide the edit form
                editProfileSection.style.display = 'none';
            } else {
                // Show error messages
                profileMessages.innerHTML = `
                    <div class="error-messages">
                        ${data.errors.map(error => `<p>${error}</p>`).join('')}
                    </div>
                `;
            }
        })
        .catch(error => {
            profileMessages.innerHTML = `
                <div class="error-messages">
                    <p>Error al actualizar el perfil. Por favor, intenta de nuevo.</p>
                </div>
            `;
            console.error('Error:', error);
        });
    });

    // Toggle order details visibility
    const viewDetailsButtons = document.querySelectorAll('.view-details');
    viewDetailsButtons.forEach(button => {
        button.addEventListener('click', () => {
            const orderId = button.getAttribute('data-order-id');
            const detailsRow = document.getElementById(`details-${orderId}`);
            const isVisible = detailsRow.style.display === 'table-row';
            
            detailsRow.style.display = isVisible ? 'none' : 'table-row';
            button.textContent = isVisible ? 'Ver Detalles' : 'Ocultar Detalles';
        });
    });
});