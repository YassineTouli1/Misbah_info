<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snack El Madina - Cuisine Authentique</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- <link rel="stylesheet" href="{{asset('css/home.css')}}"> -->
    <link rel="stylesheet" href="//web.production-88839.un.callway.aspx/css/home.css">


</head>
<body>

<!-- Navbar -->
@include('partials.nav')

<!-- Hero Section -->
<section id="home" class="hero">
    <div class="hero-content">
        @if($settings)
            <h1 class="hero-title">{{ $settings->hero_title }}</h1>
            <p class="subtitle">{{ $settings->hero_subtitle }}</p>
        @else
            <h1 class="hero-title">Bienvenue sur notre site</h1>
            <p class="subtitle">Decouvrir nos menus specials</p>
        @endif

        <div class="btn-container">
            <a href="#specialties" class="btn-orange">
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
    @if(count($reviews) > 0)
        <div class="reviews-container">
            <button class="slide-btn prev-btn" id="prevReview">
                <i class="fas fa-chevron-left"></i>
            </button>

            <div class="reviews-wrapper">
                <div class="reviews-track">
                    @foreach($reviews as $review)
                        <div class="review">
                            <div class="review-content">
                                <h4 class="review-name">{{ $review->name }}</h4>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="review-text">{{ $review->review }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button class="slide-btn next-btn" id="nextReview">
                <i class="fas fa-chevron-right"></i>
            </button>

            <div class="dots-container" id="reviewDots">
                @foreach($reviews as $key => $review)
                    <span class="dot {{ $key === 0 ? 'active' : '' }}" data-index="{{ $key }}"></span>
                @endforeach
            </div>
        </div>
    @else
        <p class="no-reviews">Aucun avis pour le moment. Soyez le premier à donner votre avis !</p>
    @endif
</section>

<style>
    .reviews {
        padding: 60px 0;
        background-color: #f9f9f9;
        position: relative;
    }

    .reviews-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        position: relative;
    }

    .reviews-wrapper {
        overflow: hidden;
        margin: 0 40px;
    }

    .reviews-track {
        display: flex;
        transition: transform 0.5s ease;
        gap: 20px;
    }

    .review {
        min-width: 100%;
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin: 0 5px;
        flex-shrink: 0;
    }

    .slide-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: #ff6b35; /* Orange color */
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: background-color 0.3s ease;
        z-index: 10;
    }

    .slide-btn:hover {
        background-color: #e65c2e; /* Darker orange on hover */
    }

    .prev-btn {
        left: 10px;
    }

    .next-btn {
        right: 10px;
    }

    .dots-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        gap: 8px;
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #ddd;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .dot.active {
        background-color: #ff6b35; /* Orange color */
    }

    .review-name {
        margin: 0 0 10px 0;
        color: #333;
        font-size: 1.2rem;
    }

    .review-rating {
        color: #ffc107;
        margin-bottom: 15px;
    }

    .review-text {
        color: #666;
        line-height: 1.6;
        margin: 0;
    }

    .no-reviews {
        text-align: center;
        color: #666;
        font-style: italic;
        padding: 20px;
    }
     .btn-orange {
         background-color: #ff9800; /* orange vif */
         color: white;
         font-weight: bold;
         padding: 12px 20px;
         border: none;
         border-radius: 12px;
         font-size: 16px;
         cursor: pointer;
         display: inline-flex;
         align-items: center;
         gap: 8px;
         text-decoration: none;
         box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
         transition: background-color 0.3s ease;
     }

    .btn-orange:hover {
        background-color: #fb8c00; /* un peu plus foncé au hover */
    }

    /* Hide navigation buttons when there are 3 or fewer reviews */
    @media (max-width: 1000px) {
        .reviews-wrapper {
            margin: 0 10px;
        }

        .slide-btn {
            width: 35px;
            height: 35px;
            font-size: 14px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.querySelector('.reviews-track');
        const slides = document.querySelectorAll('.review');
        const dots = document.querySelectorAll('.dot');
        const prevBtn = document.getElementById('prevReview');
        const nextBtn = document.getElementById('nextReview');

        let currentIndex = 0;
        const totalSlides = slides.length;

        // Hide navigation buttons if 3 or fewer reviews
        if (totalSlides <= 1) {
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
        }

        // Function to update slide position
        function updateSlide() {
            track.style.transform = `translateX(-${currentIndex * 100}%)`;

            // Update dots
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });

            // Show/hide navigation buttons based on current index
            prevBtn.style.visibility = currentIndex === 0 ? 'hidden' : 'visible';
            nextBtn.style.visibility = currentIndex >= totalSlides - 1 ? 'hidden' : 'visible';
        }

        // Event listeners for navigation buttons
        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateSlide();
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentIndex < totalSlides - 1) {
                currentIndex++;
                updateSlide();
            }
        });

        // Click on dots to navigate
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentIndex = index;
                updateSlide();
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft' && currentIndex > 0) {
                currentIndex--;
                updateSlide();
            } else if (e.key === 'ArrowRight' && currentIndex < totalSlides - 1) {
                currentIndex++;
                updateSlide();
            }
        });

        // Initialize
        updateSlide();

        // Auto-hide navigation buttons if 3 or fewer reviews
        if (totalSlides <= 3) {
            document.querySelector('.dots-container').style.display = 'none';
        }
    });
</script>

<!-- Contact Section -->
<section id="contact" class="section contact">
    <h2 class="section-title" style="color: white">Contactez-nous</h2>
    <div class="contact-info">
        <div class="contact-item">
            <i class="fas fa-map-marker-alt contact-icon"></i>
            <span>{{ $settings->adresse ?? 'Adresse non disponible' }}</span>
        </div>

        <div class="contact-item">
            <i class="fas fa-phone-alt contact-icon"></i>
            <span>{{ $settings->phone ?? 'Téléphone non disponible' }}</span>
        </div>

        <div class="contact-item">
            <i class="fas fa-clock contact-icon"></i>
            <span>{{ $settings->disponibilite ?? 'Horaires non disponibles' }}</span>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <p> 2023 Snack El Madina. Tous droits réservés.</p>
    <div class="social-links">
        <a href="{{ $settings->facebook_link ?? '#' }}" class="social-link" target="_blank">
            <i class="fab fa-facebook-f"></i>
        </a>

        <a href="{{ $settings->instagram_link ?? '#' }}" class="social-link" target="_blank">
            <i class="fab fa-instagram"></i>
        </a>

        <a href="{{ $settings->whatsapp_link ?? '#' }}" class="social-link" target="_blank">
            <i class="fab fa-whatsapp"></i>
        </a>
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
