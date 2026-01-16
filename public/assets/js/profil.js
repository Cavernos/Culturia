// Gestion des onglets du profil
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    // Gestion du clic sur les onglets
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');

            // Retirer la classe 'active' de tous les boutons et panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            // Ajouter la classe 'active' au bouton et pane cliqué
            this.classList.add('active');
            document.getElementById(tabName).classList.add('active');
        });
    });

    // Gestion du bouton Modifier dans les informations
    const editInfosBtn = document.getElementById('edit-infos-btn');
    if (editInfosBtn) {
        editInfosBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Redirection vers la page de modification du profil
            window.location.href = 'index.php?url=modifProfil';
        });
    }

    // Gestion des autres boutons Modifier
    const editButtons = document.querySelectorAll('.edit-btn:not(#edit-infos-btn)');
    editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            alert('Fonctionnalité à implémenter');
        });
    });
});
