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

document.getElementById('Interne').addEventListener('click', function(event) {
    event.preventDefault();  // Empêche le comportement par défaut du lien
    document.getElementById('InterneForm').style.display = 'block';  // Affiche le formulaire interne
    document.getElementById('ExterneForm').style.display = 'none';  // Cache le formulaire externe
  });
  
  document.getElementById('Externe').addEventListener('click', function(event) {
    event.preventDefault();  // Empêche le comportement par défaut du lien
    document.getElementById('ExterneForm').style.display = 'block';  // Affiche le formulaire externe
    document.getElementById('InterneForm').style.display = 'none';  // Cache le formulaire interne
  });