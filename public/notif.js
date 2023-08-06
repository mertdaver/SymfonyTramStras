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

<<<<<<< HEAD
=======
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
>>>>>>> 63122ccc929a5e80bd6d48bdd5f1d4971e8d02a9
