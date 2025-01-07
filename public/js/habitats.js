// /public/js/habitats.js

document.addEventListener('DOMContentLoaded', function() {
    const habitatCards = document.querySelectorAll('.card');

    habitatCards.forEach(card => {
        card.addEventListener('click', function() {
            const habitatId = card.getAttribute('data-habitat-id');
            const animalContainer = document.getElementById('animal-container');

            console.log(`Fetching animals for habitat ID: ${habitatId}`);

            fetch(`/habitats/${habitatId}/animals`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    animalContainer.innerHTML = data.html;
                })
                .catch(error => {
                    console.error('Error loading animals:', error);
                    animalContainer.innerHTML = `<p class="text-center text-danger">Error loading animals: ${error.message}</p>`;
                });
        });
    });
});
