<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if (isset($category))
	<title>{{$category}} - Crew</title>
	@else
	<title>Giyim - Crew</title>
	@endif
    <link rel="stylesheet" href="/css/category.css">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body>
    @include("hf.header")

    <main>
        <div class="category-header">
			@if (isset($category))
            <h1>{{$category}} <span class="product-count">35 ürün</span></h1>
			@else
            <h1>Giyim <span class="product-count">35 ürün</span></h1>
			@endif
            <div class="search-bar">
                <input type="search" placeholder="Ne aramıştınız?">
                <button type="button" aria-label="Search">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>
        </div>

        <div class="product-grid">
            <!-- dynamically loaded -->
        </div>

		<div class="load-more-container">
			<a class="load-more-btn">
				Daha Fazla Yükle
				<svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<polyline points="6 9 12 15 18 9"></polyline>
				</svg>
			</a>
		</div>
    </main>

    <div class="search-overlay" id="searchOverlay">
        <div class="search-container">
            <form class="search-form">
                <input type="search" placeholder="Ürün ara..." autofocus>
                <button type="submit">Ara</button>
            </form>
            <button class="close-search" id="closeSearch">×</button>
        </div>
    </div>
	@include("hf.footer")
    <script src="/js/category.js"></script>
</body>
</html>