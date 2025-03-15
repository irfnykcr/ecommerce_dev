
function setupLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target
                    img.src = img.dataset.src
                    img.removeAttribute('data-src')
                    imageObserver.unobserve(img)
                }
            })
        })
        
        const lazyImages = document.querySelectorAll('img[data-src]')
        lazyImages.forEach(img => imageObserver.observe(img))
    }
}

function populate(num){
	const product_grid = document.querySelector(".product-grid")
	let _html = ""
	for (let _ = 0; _ < num; _++){
		_html += `
			<article class="product-card">
				<div class="product-images">
					<img src="https://placehold.co/400x500" alt="Basic Oversize Sweatshirt - Siyah" class="front">
					<img src="https://placehold.co/400x500" alt="Basic Oversize Sweatshirt - Siyah Back View" class="back">
				</div>
				<div class="product-info">
					<h2>Basic Oversize Sweatshirt - Siyah</h2>
					<div class="price-container">
						<span class="original-price">₺800.00</span>
						<div class="current-price">
							<span class="discount-badge">%33</span>
							<span class="price">₺599.90</span>
						</div>
					</div>
				</div>
			</article>
		`
	}
	
	product_grid.innerHTML += _html
}

document.addEventListener('DOMContentLoaded', () => {
	const searchToggle = document.querySelector('.search-toggle')
	const searchOverlay = document.getElementById('searchOverlay')
	const categorySearch = document.querySelector('.search-bar input')
	const dropdowns = document.querySelectorAll('.has-dropdown')
	const closeSearch = document.getElementById('closeSearch')
	const productCards = document.querySelectorAll('.product-card')
	const loadMoreButton = document.querySelector('.load-more-btn')

	if (searchToggle && searchOverlay && closeSearch) {
		searchToggle.addEventListener('click', () => {
			searchOverlay.classList.add('active')
			document.body.style.overflow = 'hidden'
			searchOverlay.querySelector('input').focus()
		})
		closeSearch.addEventListener('click', () => {
			searchOverlay.classList.remove('active')
			document.body.style.overflow = ''
		})
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
				searchOverlay.classList.remove('active')
				document.body.style.overflow = ''
			}
		})
	}

	productCards.forEach(card => {
		const frontImage = card.querySelector('.front')
		const backImage = card.querySelector('.back')
		
		if (frontImage && backImage) {
			const preloadImage = new Image()
			preloadImage.src = backImage.src
			card.addEventListener('touchstart', () => {
				frontImage.style.opacity = '0'
				backImage.style.opacity = '1'
			})
			card.addEventListener('touchend', () => {
				frontImage.style.opacity = '1'
				backImage.style.opacity = '0'
			})
		}
	})

	if (categorySearch) {
		categorySearch.addEventListener('input', (e) => {
			const searchTerm = e.target.value.toLowerCase()
			
			productCards.forEach(card => {
				const productName = card.querySelector('h2').textContent.toLowerCase()
				const shouldShow = productName.includes(searchTerm)
				
				card.style.display = shouldShow ? 'block' : 'none'
			})
		})
	}

	dropdowns.forEach(dropdown => {
		dropdown.addEventListener('mouseenter', () => {
			dropdown.querySelector('.dropdown-arrow').style.transform = 'rotate(180deg)'
		})
		
		dropdown.addEventListener('mouseleave', () => {
			dropdown.querySelector('.dropdown-arrow').style.transform = 'rotate(0deg)'
		})
	})


    setupLazyLoading()
	populate(12)
	loadMoreButton.addEventListener("click", ()=>{
		populate(12)
	})
})