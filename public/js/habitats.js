document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');
    const habitatCards = document.querySelectorAll('.card');
    console.log('Habitat cards:', habitatCards);

    habitatCards.forEach(card => {
        card.addEventListener('click', function() {
            const habitatId = card.getAttribute('data-habitat-id');
            const animalContainer = document.getElementById('animal-container');

            console.log(`Fetching animals for habitat ID: ${habitatId}`);

            fetch(`/habitats/${habitatId}/animals`)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    animalContainer.innerHTML = data.html;  // Assurez-vous que data.html contient le bon HTML pour les liens

                    // Vérification des liens pour chaque animal
                    const animalItems = animalContainer.querySelectorAll('.list-group-item');
                    console.log('Animal items:', animalItems);
                })
                .catch(error => {
                    console.error('Error loading animals:', error);
                    animalContainer.innerHTML = `<p class="text-center text-danger">Error loading animals: ${error.message}</p>`;
                });
        });
    });
});
