<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snack El Madina - Cuisine Authentique</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/home.css">

</head>
<body>
<!-- Navbar -->
<x-nav/>

<!-- Hero Section -->
<section id="home" class="hero">
    <div class="hero-content">
        <h1 class="hero-title">Découvrez la saveur authentique</h1>
        <p class="subtitle">Des plats traditionnels préparés avec des ingrédients frais et une touche d'amour</p>
        <div class="btn-container">
            <a href="#specialties" class="btn btn-primary">
                <i class="fas fa-utensils"></i> Nos spécialités
            </a>
            <a href="#contact" class="btn btn-outline">
                <i class="fas fa-phone-alt"></i> Réserver
            </a>
        </div>
    </div>
    <div class="scroll-down" onclick="document.querySelector('#specialties').scrollIntoView({ behavior: 'smooth' })">
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- Specialties Section -->
<section id="specialties" class="section">
    <h2 class="section-title">Nos Spécialités</h2>
    <div class="dishes">
        <div class="dish">
            <img src="https://images.unsplash.com/photo-1559847844-5315695dadae?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="Tajine" class="dish-img">
            <div class="dish-info">
                <h3 class="dish-name">Tajine Marocain</h3>
                <p class="dish-desc">Tajine traditionnel aux légumes et viande tendre, mijoté à feu doux avec des épices aromatiques.</p>
                <div class="dish-price">45 Dhs</div>
            </div>
        </div>

        <div class="dish">
            <img src="https://images.unsplash.com/photo-1601050690597-df0568f70950?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="Couscous" class="dish-img">
            <div class="dish-info">
                <h3 class="dish-name">Couscous Royal</h3>
                <p class="dish-desc">Semoule légère avec légumes frais et viande tendre, accompagné de sa sauce savoureuse.</p>
                <div class="dish-price">50 Dhs</div>
            </div>
        </div>

        <div class="dish">
            <img src="https://images.unsplash.com/photo-1604329760661-e71dc83f8f26?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" alt="Brochettes" class="dish-img">
            <div class="dish-info">
                <h3 class="dish-name">Brochettes Maison</h3>
                <p class="dish-desc">Brochettes de viande marinée au citron et épices, grillées au charbon de bois.</p>
                <div class="dish-price">40 Dhs</div>
            </div>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section id="reviews" class="section reviews">
    <h2 class="section-title">Avis Clients</h2>
    <div class="testimonials">
        <div class="review">
            <div class="review-header">
                <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Client" class="review-avatar">
                <div>
                    <h4 class="review-name">Fatima Z.</h4>
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
            <p class="review-text">
                "Le meilleur tajine que j'ai mangé de ma vie ! Les saveurs sont incroyables et l'accueil est très chaleureux. Je recommande vivement !"
            </p>
        </div>

        <div class="review">
            <div class="review-header">
                <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Client" class="review-avatar">
                <div>
                    <h4 class="review-name">Karim B.</h4>
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p class="review-text">
                "Un restaurant familial avec des plats faits maison. Les brochettes sont exceptionnelles et les prix très raisonnables. À découvrir absolument !"
            </p>
        </div>

        <div class="review">
            <div class="review-header">
                <img src="https://randomuser.me/api/portraits/women/63.jpg" alt="Client" class="review-avatar">
                <div>
                    <h4 class="review-name">Amina T.</h4>
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
            <p class="review-text">
                "Nous y allons en famille chaque semaine. La qualité est toujours au rendez-vous et le service impeccable. Mention spéciale pour le couscous du vendredi !"
            </p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="section contact">
    <h2 class="section-title">Contactez-nous</h2>
    <div class="contact-info">
        <div class="contact-item">
            <i class="fas fa-map-marker-alt contact-icon"></i>
            <span>123 Rue Principale, Ville</span>
        </div>
        <div class="contact-item">
            <i class="fas fa-phone-alt contact-icon"></i>
            <span>+212 6 12 34 56 78</span>
        </div>
        <div class="contact-item">
            <i class="fas fa-clock contact-icon"></i>
            <span>Ouvert 7j/7 de 11h à 23h</span>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <p>© 2023 Snack El Madina. Tous droits réservés.</p>
    <div class="social-links">
        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
        <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
    </div>
</footer>

<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navLinks = document.querySelector('.nav-links');

    mobileMenuBtn.addEventListener('click', function() {
        navLinks.classList.toggle('active');
        this.innerHTML = navLinks.classList.contains('active') ?
            '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
    });

    // Close mobile menu when clicking on a link
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', function() {
            navLinks.classList.remove('active');
            mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
        });
    });

    // Scroll animations
    function animateOnScroll() {
        const dishes = document.querySelectorAll('.dish');
        const reviews = document.querySelectorAll('.review');

        dishes.forEach((dish, index) => {
            const dishPosition = dish.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.3;

            if (dishPosition < screenPosition) {
                setTimeout(() => {
                    dish.classList.add('show');
                }, index * 200);
            }
        });

        reviews.forEach((review, index) => {
            const reviewPosition = review.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.3;

            if (reviewPosition < screenPosition) {
                setTimeout(() => {
                    review.classList.add('show');
                }, index * 200);
            }
        });
    }

    window.addEventListener('scroll', animateOnScroll);
    window.addEventListener('load', animateOnScroll);
</script>
</body>
</html>