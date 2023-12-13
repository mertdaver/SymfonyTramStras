//  Sticky-MENU 

document.addEventListener("DOMContentLoaded", function() {
    if (window.innerWidth > 850) {
        console.log("La largeur de l'écran est supérieure à 850px, donc la fonction pour les écrans de moins de 850px a été désactivée.");
        return;
    }

    let lastScrollTop = 0;
    const navbar = document.getElementById('navbar');
    const menu = document.getElementById('menu');
    const menuIcon = document.getElementById('menu-icon');

    if (!navbar || !menu || !menuIcon) {
        console.log("Un ou plusieurs éléments n'ont PAS été trouvés");
        return;
    } else {
        console.log("La navbar, le menu et l'icône de menu ont été trouvés pour les écrans de moins de 850px.");
    }

    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop) {
            navbar.style.top = '-100%';
            menu.style.left = '-100%';
            menuIcon.setAttribute("aria-expanded", "false");
        } else {
            navbar.style.top = '0';
            menu.style.left = "0";
            menuIcon.setAttribute("aria-expanded", "true");
        }
        
        lastScrollTop = scrollTop;
    });
});

    //+850px menu icon user
    document.addEventListener("DOMContentLoaded", function() {
        if (window.innerWidth <= 850) {
            console.log("La largeur de l'écran est inférieure ou égale à 850px, donc la fonction pour les écrans de plus de 850px a été désactivée.");
            return;
        }
    
        handleNavbarInteraction();
        handleMenuIconClick();
        handleUserIconDropdown();
    
        function handleNavbarInteraction() {
            let lastScrollTop = 0;
            const navbar = document.getElementById('navbar');
    
            navbar.addEventListener('mouseover', function() {
                navbar.style.top = '0';
            });
    
            navbar.addEventListener('mouseout', function() {
                navbar.style.top = '-6%';
            });
    
            window.addEventListener('scroll', function() {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
                if (scrollTop > lastScrollTop) {
                    navbar.style.top = '-100%';
                } else {
                    navbar.style.top = '0';
                }
                
                lastScrollTop = scrollTop;
            });
        }
    
        function handleMenuIconClick() {
            var menuIcon = document.getElementById('menu-icon');
            var menu = document.getElementById('menu');
            var backgroundBlur = document.getElementById('background-blur');
            
            menuIcon.addEventListener('click', function() {
                menuIcon.classList.toggle('active');
                menu.classList.toggle('open');
                backgroundBlur.classList.toggle('open');
    
                if (menu.classList.contains('open')) {
                    backgroundBlur.style.display = 'block';
                } else {
                    backgroundBlur.style.display = 'none';
                }
            });
    
            // Fermez le menu lorsque vous cliquez en dehors
            backgroundBlur.addEventListener('click', function() {
                menuIcon.classList.remove('active');
                menu.classList.remove('open');
                backgroundBlur.style.display = 'none';
            });
        }
    
        function handleUserIconDropdown() {
            var userIcon = document.getElementById('user-icon');
            if (userIcon) {
                userIcon.addEventListener('click', function(event) {
                    event.preventDefault(); // empêche le comportement par défaut du lien
    
                    var dropdownContent = this.nextElementSibling; // suppose que .dropdown-content est le frère suivant de #user-icon
                    if (dropdownContent && dropdownContent.classList.contains('dropdown-content')) {
                        if (dropdownContent.style.display === 'block') {
                            dropdownContent.style.display = 'none';
                        } else {
                            dropdownContent.style.display = 'block';
                        }
                    }
                });
            }
        }
    });
    
    
    
// JS parallax Footer

// window.addEventListener('scroll', function() {
//     var parallax = document.querySelector('.parallax-footer');
//     var scrollPosition = window.scrollY;

//     parallax.style.backgroundPosition = 'center ' + (scrollPosition * 0.1) + 'px';
// });

// MENU CARDS

// Sélectionne tous les éléments ayant la classe 'gravityButton'
document.querySelectorAll('.gravityButton').forEach(btn => {
  
    // Ajoute un écouteur d'événement 'mousemove' à chaque bouton
    btn.addEventListener('mousemove', (e) => {
      
      // Obtient les dimensions et la position du bouton
      const rect = btn.getBoundingClientRect();
      
      // Calcule la moitié de la largeur du bouton
      const h = rect.width / 2;
      
      // Calcule les coordonnées x et y du pointeur de la souris par rapport au centre du bouton
      const x = e.clientX - rect.left - h;
      const y = e.clientY - rect.top - h;
  
      // Calcule la distance entre le centre du bouton et le pointeur de la souris
      const r1 = Math.sqrt(x*x+y*y);
      
      // Calcule une nouvelle distance basée sur r1, qui diminue à mesure que le pointeur s'éloigne du centre
      const r2 = (1 - (r1 / h)) * r1;
  
      // Calcule l'angle entre la ligne horizontale passant par le centre du bouton et la ligne formée par le centre du bouton et le pointeur de la souris
      const angle = Math.atan2(y, x);
      
      // Calcule les déplacements tx et ty basés sur l'angle et la distance r2
      const tx = Math.round(Math.cos(angle) * r2 * 100) / 100;
      const ty = Math.round(Math.sin(angle) * r2 * 100) / 100;
      
      // Calcule une valeur d'opacité basée sur r2 et r1
      const op = (r2 / r1) + 0.25;
  
      // Applique les déplacements tx et ty ainsi que l'opacité au bouton à l'aide de propriétés CSS personnalisées
      btn.style.setProperty('--tx', `${tx}px`);
      btn.style.setProperty('--ty', `${ty}px`);
      btn.style.setProperty('--opacity', `${op}`);
    });
  
    // Ajoute un écouteur d'événement 'mouseleave' pour réinitialiser les propriétés lorsque le pointeur de la souris quitte le bouton
    btn.addEventListener('mouseleave', (e) => {
      btn.style.setProperty('--tx', '0px');
      btn.style.setProperty('--ty', '0px');
      btn.style.setProperty('--opacity', `${0.25}`);
    });
});

//   BURGER MENU

document.addEventListener("DOMContentLoaded", function() {
  var menuIcon = document.getElementById('menu-icon');
  var menu = document.getElementById('menu');
  var backgroundBlur = document.getElementById('background-blur');
  
  menuIcon.addEventListener('click', function() {
      menuIcon.classList.toggle('active');
      menu.classList.toggle('open');
      backgroundBlur.classList.toggle('open');

      if (menu.classList.contains('open')) {
          backgroundBlur.style.display = 'block'; // Affichez le fond flouté
      } else {
          backgroundBlur.style.display = 'none'; // Cachez le fond flouté
      }
  });

  // Fermez le menu lorsque vous cliquez en dehors
  backgroundBlur.addEventListener('click', function() {
      menuIcon.classList.remove('active');
      menu.classList.remove('open');
      backgroundBlur.style.display = 'none'; // Cachez le fond flouté
  });
});




// STYLE INSCRIPTION 
// function darken(color, percentage) {
//     const amount = (percentage / 100) * 255;
//     let [r, g, b] = color.match(/\w\w/g).map((c) => parseInt(c, 16) - amount);

//     return `#${((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1)}`;
// }


