<meta class="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="/css/hf/header.css">
<header>
	<nav>
		<button class="menu-toggle" aria-label="Toggle menu">
			<span></span>
			<span></span>
			<span></span>
		</button>
		<a href="/" class="logo">deneme</a>
		<div class="nav-right">
			<button class="search-toggle" aria-label="Search">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<circle cx="11" cy="11" r="8"></circle>
					<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
				</svg>
			</button>
			<a href="/account" class="account-link" aria-label="Account">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
					<circle cx="12" cy="7" r="4"></circle>
				</svg>
			</a>
			<a href="/cart" class="cart-link" aria-label="Cart">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
					<line x1="3" y1="6" x2="21" y2="6"></line>
					<path d="M16 10a4 4 0 0 1-8 0"></path>
				</svg>
				<span class="cart-count">1</span>
			</a>
		</div>
	</nav>
</header>

<div class="search-overlay" id="searchOverlay">
	<div class="search-container">
		<form class="search-form">
			<input type="search" placeholder="Ürün ara..." autofocus>
			<button type="submit">Ara</button>
		</form>
		<button class="close-search" id="closeSearch">×</button>
	</div>
</div>

<div class="mobile-menu" id="mobileMenu">
	<div class="mobile-menu-header">
		<a href="/" class="logo">deneme</a>
		<button class="close-menu" id="closeMenu">×</button>
	</div>
	<nav class="mobile-nav">
		<ul>
			<li><a href="/t-shirts">T-Shirts</a></li>
			<li><a href="/hoodies">Hoodies</a></li>
			<li><a href="/sweatshirts">Sweatshirts</a></li>
			<li><a href="/phone-cases">Phone Cases</a></li>
			<li><a href="/new-arrivals">New Arrivals</a></li>
			<li><a href="/sale">Sale</a></li>
		</ul>
	</nav>
	<div class="mobile-menu-footer">
		<a href="/account">My Account</a>
		<a href="/orders">Orders</a>
		<a href="/contact">Contact Us</a>
	</div>
</div>