// Vous pouvez ajouter des fonctionnalités JavaScript ici si nécessaire
document.addEventListener('DOMContentLoaded', function() {
    // Exemple: Ajouter un effet de défilement fluide pour les liens d'ancrage
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});