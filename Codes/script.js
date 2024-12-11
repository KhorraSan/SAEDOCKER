const togglePasswords = document.querySelectorAll('.toggle-password');
const passwordInputs = document.querySelectorAll('input[type="password"]');

togglePasswords.forEach(function(togglePassword) {
    togglePassword.addEventListener('click', function () {
        // On vérifie le type actuel du premier champ de mot de passe
        const type = passwordInputs[0].getAttribute('type') === 'password' ? 'text' : 'password';
        
        // On applique le nouveau type à tous les champs de mot de passe
        passwordInputs.forEach(function(passwordInput) {
            passwordInput.setAttribute('type', type);
        });

        // On met à jour le texte de tous les boutons (👁 ou 🙈)
        togglePasswords.forEach(function(toggle) {
            toggle.textContent = type === 'password' ? '👁' : '🙈';
        });
    });
});
