// Notifications Alerte

function checkForNotifications() {
    fetch('/get-unread-notifications')
    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            // Afficher la fenêtre modale
            displayModal(data);
        }
        // Vérifiez à nouveau après un certain délai
        setTimeout(checkForNotifications, 5000); // 5 secondes
    });
}

function displayModal(data) {
    // Mettez à jour le contenu de votre fenêtre modale ici et affichez-la
}

// Commencez à vérifier dès que la page est chargée
document.addEventListener('DOMContentLoaded', function() {
    checkForNotifications();
});


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

// MENU CARDS

document.querySelectorAll('.gravityButton').forEach(btn => {
  
    btn.addEventListener('mousemove', (e) => {
      
      const rect = btn.getBoundingClientRect();    
      const h = rect.width / 2;
      
      const x = e.clientX - rect.left - h;
      const y = e.clientY - rect.top - h;
  
      const r1 = Math.sqrt(x*x+y*y);
      const r2 = (1 - (r1 / h)) * r1;
  
      const angle = Math.atan2(y, x);
      const tx = Math.round(Math.cos(angle) * r2 * 100) / 100;
      const ty = Math.round(Math.sin(angle) * r2 * 100) / 100;
      
      const op = (r2 / r1) + 0.25;
  
      btn.style.setProperty('--tx', `${tx}px`);
      btn.style.setProperty('--ty', `${ty}px`);
      btn.style.setProperty('--opacity', `${op}`);
    });
  
    btn.addEventListener('mouseleave', (e) => {
      btn.style.setProperty('--tx', '0px');
      btn.style.setProperty('--ty', '0px');
      btn.style.setProperty('--opacity', `${0.25}`);
    });
  })

//   BURGER MENU

document.addEventListener("DOMContentLoaded", function() {
    var menuIcon = document.getElementById('menu-icon');
    var menu = document.getElementById('menu');

    menuIcon.addEventListener('click', function() {
        var expanded = this.getAttribute("aria-expanded") === "true";
        this.setAttribute("aria-expanded", !expanded);
        menu.setAttribute("aria-hidden", expanded);
    });
});



// STYLE INSCRIPTION 
function darken(color, percentage) {
    const amount = (percentage / 100) * 255;
    let [r, g, b] = color.match(/\w\w/g).map((c) => parseInt(c, 16) - amount);

    return `#${((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1)}`;
}

document.querySelector('.btn').addEventListener('mouseover', function() {
    this.style.backgroundColor = darken('--primary-color', 10);
});

document.querySelector('.btn').addEventListener('mouseout', function() {
    this.style.backgroundColor = 'var(--primary-color)';
});

