document.addEventListener("DOMContentLoaded", function() {
    
    // Ouverture de la fenêtre modale
function openModal(alerte) {
    var modal = document.getElementById("myModalAlerte");
    if (modal) {
        var modalContent = modal.querySelector(".modal-content");
        modalContent.querySelector('.ligne').textContent = alerte.ligne;
        modalContent.querySelector('.sens').textContent = alerte.sens;
        modalContent.querySelector('.user').textContent = alerte.user;
        modalContent.querySelector('.alerteDate').textContent = alerte.alerteDate;
        modal.style.display = "block";
    }
}

// Fonction pour créer un cookie
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// Fonction pour obtenir la valeur d'un cookie
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Gestionnaire d'événement pour fermer la fenêtre modale d'alerte
function attachCloseHandlers() {
    var cardAlerte = document.querySelector(".card-alerte");
    if (cardAlerte) {
        var closeButton = cardAlerte.querySelector(".close-alerte");
        closeButton.addEventListener("click", function () {
            cardAlerte.style.display = "none";
            var overlay = document.querySelector(".overlay");
            if (overlay) {
                overlay.style.display = "none";
            }
        });

        // Fermer la fenêtre modale d'alerte en cliquant en dehors
        var overlay = document.querySelector(".overlay");
        if (overlay) {
            overlay.addEventListener("click", function () {
                cardAlerte.style.display = "none";
                overlay.style.display = "none";
            });
        }
    }
}

attachCloseHandlers();

// Vérifie régulièrement s'il y a de nouvelles alertes
function checkForNewAlerts() {
    $.ajax({
        url: '/getLatestAlertId',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            const alertId = response.id;
            if (alertId) {
                getAlertDetails(alertId);
            }
        }
    });
}

function getAlertDetails(alertId) {
    if (!alertId) return;

    $.ajax({
        url: '/getAlertDetails/' + alertId,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.alertId) {
                openModal(response);
            }
        }
    });
}

// Vérifie si l'alerte a déjà été montrée
var alerteCookie = getCookie("alerteShown");
if (!alerteCookie) {
    setCookie("alerteShown", "true", 1);
    setInterval(checkForNewAlerts, 5000);
}

// Ferme la fenêtre modale d'alerte
var modalAlerte = document.getElementById("myModalAlerte");
if (modalAlerte) {
    var closeButton = modalAlerte.querySelector(".close");
    closeButton.addEventListener("click", function () {
        modalAlerte.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target === modalAlerte) {
            modalAlerte.style.display = "none";
        }
    });
}
});