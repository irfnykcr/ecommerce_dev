
document.addEventListener('DOMContentLoaded', () => {
	const menuToggle = document.getElementById('menuToggle')
	const closeSidebar = document.getElementById('closeSidebar')
	const sidebar = document.querySelector('.sidebar')

	menuToggle.addEventListener('click', () => {
		sidebar.classList.add('active')
	})


	closeSidebar.addEventListener('click', () => {
		sidebar.classList.remove('active')
	})

	
	// Close sidebar when clicking outside on mobile
	document.addEventListener('click', (e) => {
		// Check if click target is menuToggle or any of its child SVG elements
		if (e.target === menuToggle || menuToggle.contains(e.target)) {
			return
		}

		if (sidebar && sidebar.classList.contains('active') && !sidebar.contains(e.target)) {
			sidebar.classList.remove('active')
		}
	})
})
