// public/js/comments.js

$(document).ready(function() {
    let offset = 0;
    let isLoading = false; // Ajout d'un drapeau de chargement pour éviter les appels multiples

    function loadComments() {
        if (isLoading) return; // Si déjà en cours de chargement, ne pas recharger
        isLoading = true;
        console.log('Chargement des commentaires...'); // Log de débogage

        $.ajax({
            url: '/comments/load',
            method: 'GET',
            data: { offset: offset },
            success: function(comments) {
                console.log('Commentaires reçus:', comments); // Log de débogage

                // Vérifier si des commentaires sont reçus
                if (comments.length === 0) {
                    console.log('Aucun commentaire reçu.');
                }

                comments.forEach(comment => {
                    console.log('Ajout du commentaire:', comment); // Log de débogage
                    // Vérifier si le commentaire est déjà ajouté
                    if (!document.getElementById(`comment-${comment.id}`)) {
                        const commentCard = `
                            <div class="col mb-3" id="comment-${comment.id}">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">${comment.name}</h5>
                                        <p class="card-text">${comment.comment}</p>
                                    </div>
                                </div>
                            </div>`;
                        $('#comment-container').append(commentCard);
                    } else {
                        console.log('Commentaire déjà ajouté:', comment);
                    }
                });

                offset += comments.length;
                isLoading = false; // Réinitialiser le drapeau après chargement
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors du chargement des commentaires :', error);
                isLoading = false; // Réinitialiser le drapeau en cas d'erreur
            }
        });
    }

    $('#load-more-comments').on('click', function() {
        console.log('Bouton cliqué'); // Log de débogage
        loadComments();
    });

    // Charger initialement les premiers commentaires
    loadComments();
});
