// Appele la fonction lorsque l'utilisateur poste une nouvelle alerte
var alertForm = document.getElementById('alertForm');
if (alertForm) {
    alertForm.addEventListener('submit', function(event) {
        // Empêcher le comportement par défaut du formulaire
        event.preventDefault();

        // Créer une nouvelle alerte
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/alerte', false);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // L'alerte a été créée avec succès, mettre à jour la dernière alerte
                    updateLatestAlert();
                } else {
                    console.error('Failed to create new alert.');
                }
            }
        };
        xhr.send(new FormData(alertForm));
    });
}

setInterval(updateLatestAlert, 2000);

// JS parallax Footer

window.addEventListener('scroll', function() {
    var parallax = document.querySelector('.parallax-footer');
    var scrollPosition = window.scrollY;

    parallax.style.backgroundPosition = 'center ' + (scrollPosition * 0.1) + 'px';
});

// MENU

