<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foire aux Questions</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>

    <?php

        require_once __DIR__ . '/header.html';

        ?>
    <div class="faq-container">
        <div class="faq-header">
            <h1>Foire aux Questions</h1>
            <p>Les questionnements essentiels que tout le monde se pose</p>
        </div>

        <div class="faq-content">
            <div class="expand-all-btn">
                <button onclick="toggleAll()">Tout développer / Tout réduire</button>
            </div>

            <!-- Section Acheteurs -->
            <div class="faq-section">
                <h2 class="faq-section-title">Pour les acheteurs</h2>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-question-text">Comment puis-je acheter une œuvre d'art ?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        Parcourez notre catalogue, sélectionnez l'œuvre qui vous plaît, et cliquez sur "Acheter". Vous serez guidé à travers un processus de paiement sécurisé. Une fois l'achat effectué, vous recevrez un email avec tous les détails de votre commande validée.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-question-text">Quels sont les moyens de paiement acceptés ?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        Nous acceptons les cartes bancaires (Visa, Mastercard, American Express), PayPal, et les virements bancaires pour les achats importants. Tous les paiements sont sécurisés et cryptés.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-question-text">Les prix affichés sont-ils définitifs ?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        Les prix incluent la TVA applicable. Les frais de livraison sont calculés selon la destination et les dimensions de l'œuvre. Vous verrez l'ensemble total avant de valider votre commande.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-question-text">Puis-je négocier le prix ?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        Pour certaines œuvres en collection, une négociation peut être possible. Contactez-nous directement en utilisant la fonction "Faire une offre" à côté de l'œuvre qui vous intéresse.
                    </div>
                </div>
            </div>

            <!-- Section Livraison et Retours -->
            <div class="faq-section">
                <h2 class="faq-section-title">Livraison et Retours</h2>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-question-text">Quels sont les délais de livraison ?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        Le délai standard est variable selon la provenance de l'artiste et votre adresse. Généralement, comptez 7 à 21 jours ouvrés. Un suivi vous sera communiqué dès l'expédition de votre œuvre.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-question-text">Comment est l'œuvre expédiée ?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        Chaque œuvre est soigneusement emballée par l'artiste ou notre équipe avec des matériaux de protection professionnels adaptés, et une assurance. Nous veillons à minimiser tout risque d'endommagement pendant le transport.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-question-text">Puis-je retourner une œuvre si elle ne me convient pas ?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        Oui, vous disposez d'un délai de 14 jours à compter de la réception pour nous retourner l'œuvre dans son état d'origine. Les frais de retour sont à votre charge. L'œuvre doit être retournée dans son emballage d'origine, en parfait état et sans dommage.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-question-text">Que faire si l'œuvre arrive endommagée ?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        Photographiez immédiatement les dommages et l'emballage, puis contactez-nous sous 48h. Nous gérerons le dossier avec le transporteur et vous proposerons un remplacement ou un remboursement complet.
                    </div>
                </div>
            </div>

            <!-- Section Authenticité -->
            <div class="faq-section">
                <h2 class="faq-section-title">Authenticité et Certificats</h2>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-question-text">Les œuvres sont-elles authentiques ?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        Toute œuvre vendue sur notre plateforme est créée et signée par les artistes. Chaque artiste est vérifié lors de son inscription pour garantir l'authenticité des œuvres diffusées.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-question-text">Vais-je recevoir un certificat d'authenticité ?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        Oui, chaque œuvre originale ou en édition limitée s'accompagne d'un certificat d'authenticité signé par l'artiste, mentionnant la taille, les dimensions, la technique, et le numéro de création.
                    </div>
                </div>
            </div>

            <!-- Autres sections... (continuez avec le même pattern) -->
        </div>
    </div>

    <script>
        // Fonction pour ouvrir/fermer une question
        function toggleFaq(element) {
            const faqItem = element.parentElement;
            const wasActive = faqItem.classList.contains('active');
            
            // Animation fluide
            faqItem.classList.toggle('active');
            
            // Scroll doux vers l'élément si on l'ouvre
            if (!wasActive) {
                setTimeout(() => {
                    element.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'nearest' 
                    });
                }, 100);
            }
        }

        // Fonction pour tout développer/réduire
        function toggleAll() {
            const allItems = document.querySelectorAll('.faq-item');
            const hasActive = document.querySelector('.faq-item.active');
            
            allItems.forEach(item => {
                if (hasActive) {
                    item.classList.remove('active');
                } else {
                    item.classList.add('active');
                }
            });
        }

        // Permettre la navigation au clavier
        document.addEventListener('keydown', function(e) {
            if (e.target.classList.contains('faq-question')) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleFaq(e.target);
                }
            }
        });

        // Rendre les questions accessibles au clavier
        document.querySelectorAll('.faq-question').forEach(question => {
            question.setAttribute('tabindex', '0');
            question.setAttribute('role', 'button');
            question.setAttribute('aria-expanded', 'false');
        });

        // Mettre à jour aria-expanded quand on clique
        document.addEventListener('click', function(e) {
            if (e.target.closest('.faq-question')) {
                const question = e.target.closest('.faq-question');
                const isExpanded = question.parentElement.classList.contains('active');
                question.setAttribute('aria-expanded', isExpanded);
            }
        });
    </script>

    <?php
    require_once __DIR__ . '/footer.html';
    ?>
</body>
</html>