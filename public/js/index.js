// DOM Elements
const menuToggle = document.querySelector('.menu-toggle')
const mobileMenu = document.getElementById('mobileMenu')
const closeMenu = document.getElementById('closeMenu')
const searchToggle = document.querySelector('.search-toggle')
const searchOverlay = document.getElementById('searchOverlay')
const closeSearch = document.getElementById('closeSearch')
const cartCount = document.querySelector('.cart-count')

// Mobile Menu Toggle
if (menuToggle && mobileMenu && closeMenu) {
    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.add('active')
        document.body.style.overflow = 'hidden'
    })

    closeMenu.addEventListener('click', () => {
        mobileMenu.classList.remove('active')
        document.body.style.overflow = ''
    })
}

// Search Overlay Toggle
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

    // Close search on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
            searchOverlay.classList.remove('active')
            document.body.style.overflow = ''
        }
    })
}

// Hero Slider
class Slider {
    constructor() {
        this.slider = document.querySelector('.slider-container')
        if (!this.slider) return

        this.slides = Array.from(document.querySelectorAll('.slide'))
        this.dots = document.querySelector('.slider-dots')
        this.currentSlide = 0
        this.slideInterval = null
        this.init()
    }

    init() {
        if (this.slides.length <= 1) return

        // Create dots
        this.slides.forEach((_, index) => {
            const dot = document.createElement('button')
            dot.classList.add('dot')
            dot.setAttribute('aria-label', `Go to slide ${index + 1}`)
            dot.addEventListener('click', () => this.goToSlide(index))
            this.dots.appendChild(dot)
        })

        // Add navigation listeners
        const prevButton = document.querySelector('.prev')
        const nextButton = document.querySelector('.next')
        
        if (prevButton) {
            prevButton.addEventListener('click', () => this.prevSlide())
        }
        
        if (nextButton) {
            nextButton.addEventListener('click', () => this.nextSlide())
        }

        // Update dots
        this.updateDots()

        // Start autoplay
        this.startAutoplay()

        // Pause autoplay on hover
        this.slider.addEventListener('mouseenter', () => this.stopAutoplay())
        this.slider.addEventListener('mouseleave', () => this.startAutoplay())

        // Swipe support for touch devices
        this.setupSwipe()
    }

    updateDots() {
        const dots = this.dots.querySelectorAll('.dot')
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === this.currentSlide)
        })
    }

    goToSlide(index) {
        this.slides[this.currentSlide].classList.remove('active')
        this.currentSlide = index
        if (this.currentSlide >= this.slides.length) this.currentSlide = 0
        if (this.currentSlide < 0) this.currentSlide = this.slides.length - 1
        this.slides[this.currentSlide].classList.add('active')
        this.updateDots()
    }

    nextSlide() {
        this.goToSlide(this.currentSlide + 1)
    }

    prevSlide() {
        this.goToSlide(this.currentSlide - 1)
    }

    startAutoplay() {
        if (this.slideInterval) return
        this.slideInterval = setInterval(() => this.nextSlide(), 5000)
    }

    stopAutoplay() {
        if (this.slideInterval) {
            clearInterval(this.slideInterval)
            this.slideInterval = null
        }
    }

    setupSwipe() {
        let touchStartX = 0
        let touchEndX = 0
        
        this.slider.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX
        }, { passive: true })
        
        this.slider.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX
            this.handleSwipe()
        }, { passive: true })
        
        this.handleSwipe = () => {
            const swipeThreshold = 50
            if (touchEndX < touchStartX - swipeThreshold) {
                // Swipe left, go to next slide
                this.nextSlide()
            }
            if (touchEndX > touchStartX + swipeThreshold) {
                // Swipe right, go to previous slide
                this.prevSlide()
            }
        }
    }
}

// Product Interactions
function setupProductInteractions() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart')
    const quickViewButtons = document.querySelectorAll('.quick-view')
    
    // Add to cart functionality
    addToCartButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault()
            const productCard = button.closest('.product-card')
            const productName = productCard.querySelector('h3').textContent
            
            // Update cart count
            const currentCount = parseInt(cartCount.textContent)
            cartCount.textContent = currentCount + 1
            
            // Add animation
            cartCount.classList.add('bump')
            setTimeout(() => cartCount.classList.remove('bump'), 300)
            
            // Show notification
            showNotification(`${productName} added to cart!`)
        })
    })
    
    // Quick view functionality
    quickViewButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault()
            const productCard = button.closest('.product-card')
            const productName = productCard.querySelector('h3').textContent
            
            // Here you would typically open a modal with product details
            alert(`Quick view for ${productName}`)
        })
    })
}

// Notification system
function showNotification(message) {
    // Check if notification container exists, create if not
    let notificationContainer = document.querySelector('.notification-container')
    if (!notificationContainer) {
        notificationContainer = document.createElement('div')
        notificationContainer.className = 'notification-container'
        document.body.appendChild(notificationContainer)
        
        // Add styles
        const style = document.createElement('style')
        style.textContent = `
            .notification-container {
                position: fixed
                bottom: 20px
                right: 20px
                z-index: 9999
            }
            .notification {
                background: var(--primary-color)
                color: white
                padding: 1rem
                margin-top: 0.5rem
                border-radius: 4px
                box-shadow: 0 4px 6px rgba(0,0,0,0.1)
                transform: translateX(100%)
                animation: slideIn 0.3s forwards, fadeOut 0.3s 2.7s forwards
                max-width: 300px
            }
            @keyframes slideIn {
                to { transform: translateX(0) }
            }
            @keyframes fadeOut {
                to { opacity: 0 }
            }
        `
        document.head.appendChild(style)
    }
    
    // Create and add notification
    const notification = document.createElement('div')
    notification.className = 'notification'
    notification.textContent = message
    notificationContainer.appendChild(notification)
    
    // Remove notification after animation
    setTimeout(() => {
        notification.remove()
    }, 3000)
}

// Lazy Loading Images
function setupLazyLoading() {
    if ('IntersectionObserver' in window) {
        const lazyImages = document.querySelectorAll('img[data-src]')
        
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
        
        lazyImages.forEach(img => imageObserver.observe(img))
    } else {
        // Fallback for browsers that don't support IntersectionObserver
        const lazyImages = document.querySelectorAll('img[data-src]')
        lazyImages.forEach(img => {
            img.src = img.dataset.src
            img.removeAttribute('data-src')
        })
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new Slider()
    setupProductInteractions()
    setupLazyLoading()
    
    // Newsletter form submission
    const newsletterForm = document.querySelector('.newsletter-form')
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault()
            const email = newsletterForm.querySelector('input').value
            showNotification(`Thank you! ${email} has been subscribed.`)
            newsletterForm.reset()
        })
    }
})