<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>deneme - Modern Streetwear</title>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body>
	@include("hf.header")
    <main>
        <section class="hero-slider">
            <div class="slider-container">
                <div class="slide active">
					<picture>
						<!-- Small screens -->
						<source media="(max-width: 1280px)" srcset="https://placehold.co/640x480/000000/FFFFFF" alt="Oversize Sweat Collection">
						<!-- Large screens -->
						<source media="(min-width: 1281px)" srcset="https://placehold.co/1920x1080/000000/FFFFFF" alt="Oversize Sweat Collection">
						<!-- Fallback -->
						<img src="https://placehold.co/1920x1080/000000/FFFFFF" alt="Oversize Sweat Collection">
					</picture>
                    <div class="slide-content">
                        <h1>OVERSIZE SWEAT</h1>
                        <p>İNDİRİMLİ FİYATLAR</p>
                        <a href="/category" class="cta-button">ALIŞVERİŞE BAŞLA</a>
                    </div>
                </div>
                <div class="slide">
					<picture>
						<!-- Small screens -->
						<source media="(max-width: 1280px)" srcset="https://placehold.co/640x480/000000/FFFFFF" alt="T-Shirt Collection">
						<!-- Large screens -->
						<source media="(min-width: 1281px)" srcset="https://placehold.co/1920x1080/000000/FFFFFF" alt="T-Shirt Collection">
						<!-- Fallback -->
						<img src="https://placehold.co/1920x1080/000000/FFFFFF" alt="T-Shirt Collection">
					</picture>
                    <div class="slide-content">
                        <h1>STREET STYLE</h1>
                        <p>YENİ SEZON</p>
                        <a href="/category" class="cta-button">KEŞFET</a>
                    </div>
                </div>
                <div class="slide">
					<picture>
						<!-- Small screens -->
						<source media="(max-width: 1280px)" srcset="https://placehold.co/640x480/000000/FFFFFF" alt="Özel Tasarımlar">
						<!-- Large screens -->
						<source media="(min-width: 1281px)" srcset="https://placehold.co/1920x1080/000000/FFFFFF" alt="Özel Tasarımlar">
						<!-- Fallback -->
						<img src="https://placehold.co/1920x1080/000000/FFFFFF" alt="Özel Tasarımlar">
					</picture>
                    <div class="slide-content">
                        <h1>Diğer</h1>
                        <p>ÖZEL TASARIMLAR</p>
                        <a href="/category" class="cta-button">HEMEN BAK</a>
                    </div>
                </div>
                <button class="slider-nav prev" aria-label="Previous slide">‹</button>
                <button class="slider-nav next" aria-label="Next slide">›</button>
                <div class="slider-dots"></div>
            </div>
        </section>


		<!-- Update the featured categories section in index.html with responsive image sources -->
		<section class="featured-categories">
			<div class="category-grid">
				<div class="category-card">
					<picture>
						<!-- Small screens -->
						<source media="(max-width: 576px)" srcset="https://placehold.co/300x300">
						<!-- Medium screens -->
						<source media="(max-width: 991px)" srcset="https://placehold.co/400x300">
						<!-- Large screens -->
						<source media="(min-width: 992px)" srcset="https://placehold.co/600x300">
						<!-- Fallback -->
						<img src="https://placehold.co/600x300" alt="Oversize T-Shirt">
					</picture>
					<h3>Oversize T-Shirt</h3>
				</div>
				<div class="category-card">
					<picture>
						<!-- Small screens -->
						<source media="(max-width: 576px)" srcset="https://placehold.co/300x300">
						<!-- Medium screens -->
						<source media="(max-width: 991px)" srcset="https://placehold.co/400x300">
						<!-- Large screens -->
						<source media="(min-width: 992px)" srcset="https://placehold.co/400x600">
						<!-- Fallback -->
						<img src="https://placehold.co/400x600" alt="Diğer">
					</picture>
					<h3>Diğer</h3>
				</div>
				<div class="category-card">
					<picture>
						<!-- Small screens -->
						<source media="(max-width: 576px)" srcset="https://placehold.co/300x300">
						<!-- Medium screens -->
						<source media="(max-width: 991px)" srcset="https://placehold.co/400x300">
						<!-- Large screens -->
						<source media="(min-width: 992px)" srcset="https://placehold.co/400x300">
						<!-- Fallback -->
						<img src="https://placehold.co/400x300" alt="Oversize Sweat">
					</picture>
					<h3>Oversize Sweat</h3>
				</div>
				<div class="category-card">
					<picture>
						<!-- Small screens -->
						<source media="(max-width: 576px)" srcset="https://placehold.co/300x300">
						<!-- Medium screens -->
						<source media="(max-width: 991px)" srcset="https://placehold.co/400x300">
						<!-- Large screens -->
						<source media="(min-width: 992px)" srcset="https://placehold.co/400x300">
						<!-- Fallback -->
						<img src="https://placehold.co/400x300" alt="Oversize Hoodie">
					</picture>
					<h3>Oversize Hoodie</h3>
				</div>
			</div>
		</section>

        <section class="t-shirts">
            <h2 class="section-title">T-Shirt</h2>
            <div class="product-grid">
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://placehold.co/300" alt="Black T-Shirt">
                        <div class="product-actions">
                            <button class="quick-view">Hızlı Bakış</button>
                            <button class="add-to-cart">Sepete Ekle</button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3>Basic Black T-Shirt</h3>
                        <p class="price">199.99 TL</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://placehold.co/300" alt="Graphic T-Shirt">
                        <div class="product-actions">
                            <button class="quick-view">Hızlı Bakış</button>
                            <button class="add-to-cart">Sepete Ekle</button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3>Graphic Print T-Shirt</h3>
                        <p class="price">249.99 TL</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://placehold.co/300" alt="White T-Shirt">
                        <div class="product-actions">
                            <button class="quick-view">Hızlı Bakış</button>
                            <button class="add-to-cart">Sepete Ekle</button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3>White Graphic T-Shirt</h3>
                        <p class="price">229.99 TL</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://placehold.co/300" alt="Black Graphic T-Shirt">
                        <div class="product-actions">
                            <button class="quick-view">Hızlı Bakış</button>
                            <button class="add-to-cart">Sepete Ekle</button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3>deneme Logo T-Shirt</h3>
                        <p class="price">199.99 TL</p>
                    </div>
                </div>
            </div>
            <div class="view-all-container">
                <a href="/category/t-shirt" class="view-all-button">Tümünü Gör</a>
            </div>
        </section>

        <section class="new-arrivals">
            <h2 class="section-title">Yeni Gelenler</h2>
            <div class="product-grid">
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://placehold.co/300" alt="New Phone Case">
                        <span class="badge">Yeni</span>
                        <div class="product-actions">
                            <button class="quick-view">Hızlı Bakış</button>
                            <button class="add-to-cart">Sepete Ekle</button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3>Cherry Pattern Case</h3>
                        <p class="price">149.99 TL</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://placehold.co/300" alt="New Wave Case">
                        <span class="badge">Yeni</span>
                        <div class="product-actions">
                            <button class="quick-view">Hızlı Bakış</button>
                            <button class="add-to-cart">Sepete Ekle</button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3>Great Wave Case</h3>
                        <p class="price">149.99 TL</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://placehold.co/300" alt="New Mountain Case">
                        <span class="badge">Yeni</span>
                        <div class="product-actions">
                            <button class="quick-view">Hızlı Bakış</button>
                            <button class="add-to-cart">Sepete Ekle</button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3>Blue Mountain Case</h3>
                        <p class="price">149.99 TL</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://placehold.co/300" alt="New Black Case">
                        <span class="badge">Yeni</span>
                        <div class="product-actions">
                            <button class="quick-view">Hızlı Bakış</button>
                            <button class="add-to-cart">Sepete Ekle</button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3>Matte Black Case</h3>
                        <p class="price">149.99 TL</p>
                    </div>
                </div>
            </div>
            <div class="view-all-container">
                <a href="/category/new" class="view-all-button">Tümünü Gör</a>
            </div>
        </section>

        <section class="newsletter">
            <div class="newsletter-container">
                <h2>Yeniliklerden Haberdar Olun</h2>
                <p>Yeni ürünler ve indirimlerden ilk siz haberdar olun.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="E-posta adresiniz" required>
                    <button type="submit">Abone Ol</button>
                </form>
            </div>
        </section>
    </main>
    <script src="/js/index.js"></script>
	@include("hf.footer")
</body>
</html>