//  NOTIF ALERTE 







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


