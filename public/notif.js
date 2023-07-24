<script>
    // La fonction pour mettre à jour le contenu de la balise div avec les informations de la dernière alerte
    function updateLatestAlert() {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // La requête a réussi, traiter les données JSON reçues
                    var response = JSON.parse(xhr.responseText);

                    // Mettre à jour le contenu de la div avec les informations de la dernière alerte
                    var latestAlertDiv = document.getElementById('latestAlert');
                    latestAlertDiv.innerHTML = 'Dernière alerte : Ligne ' + response.ligne + ' - Sens ' + response.sens + ' - Date ' + response.alerteDate;
                } else {
                    console.error('Failed to fetch latest alert.');
                }
            }
        };

        xhr.open('GET', '/get-latest-alert', true);
        xhr.send();
    }

    // Appele la fonction pour mettre à jour la dernière alerte lors du chargement de la page
    window.onload = function() {
        updateLatestAlert();
    };

    // Appele la fonction lorsque l'utilisateur poste une nouvelle alerte
    var submitAlertButton = document.getElementById('submitAlertButton');
    if (submitAlertButton) {
        submitAlertButton.addEventListener('click', function(event) {
            // Empêcher le comportement par défaut du formulaire
            event.preventDefault();

            // appele la fonction pour mettre à jour la dernière alerte
            updateLatestAlert();
        });
    }

    // Appeler la fonction à intervalles réguliers
    setInterval(function() {
        updateLatestAlert();
    }, 10000); // 2000 millisecondes = 2 secondes
</script>