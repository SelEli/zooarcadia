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
                    animalContainer.innerHTML = data.html;

                    // Ajout du gestionnaire de clic pour les animaux
                    const animalItems = animalContainer.querySelectorAll('.list-group-item');
                    console.log('Animal items:', animalItems);

                    animalItems.forEach(item => {
                        item.addEventListener('click', function() {
                            const animalId = item.getAttribute('data-animal-id');
                            console.log(`Fetching details for animal ID: ${animalId}`);

                            fetch(`/animal/${animalId}`)
                                .then(response => {
                                    console.log('Response status for animal details:', response.status);
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Animal details data:', data);
                                    showAnimalDetails(data);
                                })
                                .catch(error => {
                                    console.error('Error loading animal details:', error);
                                });
                        });
                    });
                })
                .catch(error => {
                    console.error('Error loading animals:', error);
                    animalContainer.innerHTML = `<p class="text-center text-danger">Error loading animals: ${error.message}</p>`;
                });
        });
    });

    function showAnimalDetails(animal) {
        console.log('Showing animal details:', animal);
        const animalDetails = document.getElementById('animal-details');
        animalDetails.querySelector('#animal-name').textContent = animal.name;
        animalDetails.querySelector('#animal-image').src = `data:${animal.imageType};base64,${animal.imageData}`;
        animalDetails.querySelector('#animal-description').textContent = animal.description;
    }
});
