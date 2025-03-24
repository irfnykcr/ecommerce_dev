document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabLinks = document.querySelectorAll('.sidebar a[data-tab]');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get the tab ID
            const tabId = this.dataset.tab;
            
            // Remove active class from all tabs and links
            tabContents.forEach(tab => tab.classList.remove('active'));
            tabLinks.forEach(link => link.parentElement.classList.remove('active'));
            
            // Add active class to current tab and link
            document.getElementById(tabId).classList.add('active');
            this.parentElement.classList.add('active');
        });
    });
    
    // Form submission handling
    const forms = document.querySelectorAll('.profile-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simulate form submission
            const submitButton = this.querySelector('.save-btn');
            const originalText = submitButton.textContent;
            
            submitButton.textContent = 'Kaydediliyor...';
            submitButton.disabled = true;
            
            setTimeout(() => {
                submitButton.textContent = originalText;
                submitButton.disabled = false;
                
                // Show success message
                alert('Bilgileriniz başarıyla kaydedildi!');
            }, 1500);
        });
    });
    
    // Favorite button functionality
    const favoriteButtons = document.querySelectorAll('.favorite-btn');
    
    favoriteButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.classList.toggle('active');
            
            // If removing from favorites, remove the product card
            if (!this.classList.contains('active')) {
                const productCard = this.closest('.product-card');
                productCard.style.opacity = '0';
                
                setTimeout(() => {
                    productCard.remove();
                    
                    // Update favorites count
                    const favoritesTitle = document.querySelector('#favorites h1');
                    const currentCount = parseInt(favoritesTitle.textContent.match(/$$(\d+)$$/)[1]);
                    const newCount = currentCount - 1;
                    
                    favoritesTitle.textContent = `Beğendiğim Ürünler (${newCount})`;
                    
                    // Show info message if no favorites left
                    if (newCount === 0) {
                        const infoBox = document.createElement('div');
                        infoBox.className = 'info-box';
                        infoBox.textContent = 'Henüz beğendiğiniz bir ürün bulunmamaktadır.';
                        
                        document.querySelector('#favorites .products-grid').replaceWith(infoBox);
                    }
                }, 300);
            }
        });
    });
    
    // Dynamic city-district relationship
    const citySelect = document.getElementById('city');
    const districtSelect = document.getElementById('district');
    
    if (citySelect && districtSelect) {
        const districts = {
            'istanbul': ['Adalar', 'Bakırköy', 'Beşiktaş', 'Kadıköy', 'Şişli'],
            'ankara': ['Çankaya', 'Keçiören', 'Mamak', 'Yenimahalle'],
            'izmir': ['Bornova', 'Karşıyaka', 'Konak']
        };
        
        citySelect.addEventListener('change', function() {
            const selectedCity = this.value;
            
            // Clear district options
            districtSelect.innerHTML = '<option value="">Seçiniz</option>';
            
            // Add new district options based on selected city
            if (selectedCity && districts[selectedCity]) {
                districts[selectedCity].forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.toLowerCase();
                    option.textContent = district;
                    districtSelect.appendChild(option);
                });
            }
        });
    }
});