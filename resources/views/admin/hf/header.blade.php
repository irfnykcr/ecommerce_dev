<meta class="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="/css/admin/hf/header.css">
<header class="admin-header">
	<button class="menu-toggle" id="menuToggle">
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
			<line x1="3" y1="12" x2="21" y2="12"></line>
			<line x1="3" y1="6" x2="21" y2="6"></line>
			<line x1="3" y1="18" x2="21" y2="18"></line>
		</svg>
	</button>
	
	<div class="header-right">
		<!-- <div class="notifications">
			<button class="notification-btn">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
					<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
				</svg>
				<span class="notification-badge">3</span>
			</button>
		</div> -->
		
		<div class="admin-profile">
			<img src="https://placehold.co/40x40" alt="Admin" class="profile-img">
			<span class="profile-name">Admin User</span>
		</div>
	</div>
</header>