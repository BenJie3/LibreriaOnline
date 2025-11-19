document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', (e) => {
            const username = registerForm.username.value;
            const email = registerForm.email.value;
            const password = registerForm.password.value;
            const confirmPassword = registerForm.confirm_password.value;
            const firstName = registerForm.first_name.value;
            const lastName = registerForm.last_name.value;
            let errors = [];

            if (username.length < 3) {
                errors.push('El nombre de usuario debe tener al menos 3 caracteres');
            }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                errors.push('Por favor, introduce un email válido');
            }
            if (password.length < 8) {
                errors.push('La contraseña debe tener al menos 8 caracteres');
            }
            if (password !== confirmPassword) {
                errors.push('Las contraseñas no coinciden');
            }
            if (firstName.length < 1) {
                errors.push('El nombre es obligatorio');
            }
            if (lastName.length < 1) {
                errors.push('El apellido es obligatorio');
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join('\n'));
            }
        });
    }
});