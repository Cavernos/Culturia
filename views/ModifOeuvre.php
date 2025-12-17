
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="../public/assets/img/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culturia</title>
</head>

<body>
    <main class="oeuvre">
        <h1>Modifier l'œuvre</h1>

        <form id="editForm">

            <lab for="title">Titre de l'œuvre *</lab>
            <input type="text" id="title" value="La création d'Adam" required>

            <section class="cate">
                <lab>
                    Catégorie *
                    <select id="category" required>
                        <option value="peinture" selected>Peinture</option>
                        <option value="sculpture">Sculpture</option>
                        <option value="photographie">Photographie</option>
                        <option value="dessin">Dessin</option>
                        <option value="ceramique">Céramique</option>
                    </select>
                </lab>

                <lab>
                    Prix (€) *
                    <input type="number" id="price" value="2500" required>
                </lab>
            </section>

            <section class="cate">
                <lab>
                    Largeur (cm)
                    <input type="number" id="width" value="80">
                </lab>

                <lab>
                    Hauteur (cm)
                    <input type="number" id="height" value="60">
                </lab>
            </section>

            <lab for="description">Description *</lab>
            <textarea id="description" required>
Une reproduction inspirée de la célèbre fresque de Michel-Ange, réalisée avec des techniques modernes tout en préservant l'essence de l'original.
            </textarea>

            <lab for="technique">Technique</lab>
            <input type="text" id="technique" value="Huile sur toile">

            <section>
                <p>Image de l'œuvre</p>

                <div class="image-upload" onclick="document.getElementById('fileInput').click()">
                    <input type="file" id="fileInput" accept="image/*" onchange="previewImage(event)">
                    <p>📷</p>
                    <p> Cliquez pour modifier l'image</p>
                    <p>Veuillez introduitre 5 images au maximum</p>
                    <p class="image-note">Format: JPG, PNG (max 5MB)</p>
                </div>

            </section>

            <footer class="bouton">
                <button type="button" class="suprr" onclick="showDeleteModal()">Supprimer</button>
                <button type="button" class="annul" onclick="window.history.back()">Annuler</button>
                <button type="submit" class="enreg">Enregistrer</button>
            </footer>
        </form>
    </main>
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                if (preview) {
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="max-width: 300px; border-radius: 8px;">';
                }
            }
            reader.readAsDataURL(file);
        }
    }

    function showDeleteModal() {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette œuvre définitivement ?')) {
            alert('Œuvre supprimée avec succès');
            window.history.back();
        }
    }

    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Sauvegarder tous les champs
        document.querySelectorAll('input, textarea, select').forEach(field => {
            if (field.type !== 'file') {
                localStorage.setItem(field.id, field.value);
            }
        });
        
        alert('✓ Modification enregistrée');
    });

    // Charger les données au chargement
    window.addEventListener('load', function() {
        document.querySelectorAll('input, textarea, select').forEach(field => {
            const saved = localStorage.getItem(field.id);
            if (saved && field.type !== 'file') {
                field.value = saved;
            }
        });
    });
</script>

</body>
</html>