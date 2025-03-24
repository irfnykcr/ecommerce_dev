const checkUpdateForm = (fullname,phone,email) =>{
	if (email.length > 100) {
		return [false, "email too long"]
	}
	if (fullname.length > 100){
		return [false, "name is too long"]
	}
	if (phone.length > 20) {
		return [false, "incorrect phone number"]
	}
	const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
	if (!emailRegex.test(email)) {
		return [false, "Invalid email format"]
	}
	return [true, ""]
	
}

document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabLinks = document.querySelectorAll('.sidebar a[data-tab]')
    const tabContents = document.querySelectorAll('.tab-content')
    
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault()
            
            // Get the tab ID
            const tabId = this.dataset.tab
            
            // Remove active class from all tabs and links
            tabContents.forEach(tab => tab.classList.remove('active'))
            tabLinks.forEach(link => link.parentElement.classList.remove('active'))
            
            // Add active class to current tab and link
            document.getElementById(tabId).classList.add('active')
            this.parentElement.classList.add('active')
        })
    })

	const updateuserError_el = document.querySelector(".error-message-update")
	const updateUserButton_el = document.querySelector("#update-user-info")
	const updateUserName_el = document.querySelector("#first-name")
	const updateUserPhone_el = document.querySelector("#phone")
	const updateUserEmail_el = document.querySelector("#email")

	updateUserButton_el.addEventListener("click", async ()=>{
		const full_name = updateUserName_el.value
		const phone_number = updateUserPhone_el.value
		const email = updateUserEmail_el.value
		const checkform = checkUpdateForm(full_name,phone_number,email)
		if (!checkform[0]){
			updateuserError_el.innerHTML = checkform[1]
			updateuserError_el.style.display="flex"
			return
		}
		const r = await fetch(`/account/updateInfo`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-Token': document.querySelector('.csrf-token').content
			},
			body: JSON.stringify({ 
				full_name: full_name,
				email: email,
				phone_number: phone_number,
			})
		})
		.then(response => {
			return response.json()
		}).catch(error => {
			return error.json()
		})

		if (r["status"] === "error"){
			updateuserError_el.innerHTML = r["message"]
			updateuserError_el.style.display="flex"
		} else {
			updateuserError_el.innerHTML=r["message"]
			updateuserError_el.style.backgroundColor="var(--success-color)"
			updateuserError_el.style.display="flex"
			window.location.href = "/account"
		}
	})


	const ilSec_el = document.querySelector(".il-select")
	const ilceSec_el = document.querySelector(".ilce-select")
	const api_url = "https://turkiyeapi.dev/api/v1/provinces?fields=name"

	fetch(api_url)
		.then(response => {
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}
			return response.json();
		})
		.then(data => {
			// Clear existing options
			ilSec_el.innerHTML = '<option value="">Şehir Seçiniz</option>';
			
			// Add options for each province
			data.data.forEach(province => {
				const option = document.createElement('option');
				option.value = province.name.toLowerCase();
				option.textContent = province.name;
				ilSec_el.appendChild(option);
			});
		})
		.catch(error => {
			console.error('Error fetching cities:', error);
		});
	//https://turkiyeapi.dev/api/v1/provinces?name=istanbul

	ilSec_el.addEventListener("change", (i)=>{
		const selectedCity = i.target.value;
		if (!selectedCity) return;
		
		fetch(`https://turkiyeapi.dev/api/v1/provinces?name=${selectedCity}`)
			.then(response => {
				if (!response.ok) {
					throw new Error('Network response was not ok');
				}
				return response.json();
			})
			.then(data => {
				console.log('City data:', data);
				// Clear existing options first
				ilceSec_el.innerHTML = '<option value="">İlçe Seçiniz</option>';
				
				data["data"][0]["districts"].forEach(district => {
					const option = document.createElement('option');
					option.value = district.name.toLowerCase();
					option.textContent = district.name;
					ilceSec_el.appendChild(option);
				});
			})
			.catch(error => {
				console.error('Error fetching city details:', error);
			});
	})
    
    // Form submission handling
    // const forms = document.querySelectorAll('.profile-form')
    
    // forms.forEach(form => {
    //     form.addEventListener('submit', function(e) {
    //         e.preventDefault()
            
    //         // Simulate form submission
    //         const submitButton = this.querySelector('.save-btn')
    //         const originalText = submitButton.textContent
            
    //         submitButton.textContent = 'Kaydediliyor...'
    //         submitButton.disabled = true
            
    //         setTimeout(() => {
    //             submitButton.textContent = originalText
    //             submitButton.disabled = false
                
    //             // Show success message
    //             alert('Bilgileriniz başarıyla kaydedildi!')
    //         }, 1500)
    //     })
    // })
    
    // Favorite button functionality
    const favoriteButtons = document.querySelectorAll('.favorite-btn')
    
    favoriteButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.classList.toggle('active')
            
            // If removing from favorites, remove the product card
            if (!this.classList.contains('active')) {
                const productCard = this.closest('.product-card')
                productCard.style.opacity = '0'
                
                setTimeout(() => {
                    productCard.remove()
                    
                    // Update favorites count
                    const favoritesTitle = document.querySelector('#favorites h1')
                    const currentCount = parseInt(favoritesTitle.textContent.match(/$$(\d+)$$/)[1])
                    const newCount = currentCount - 1
                    
                    favoritesTitle.textContent = `Beğendiğim Ürünler (${newCount})`
                    
                    // Show info message if no favorites left
                    if (newCount === 0) {
                        const infoBox = document.createElement('div')
                        infoBox.className = 'info-box'
                        infoBox.textContent = 'Henüz beğendiğiniz bir ürün bulunmamaktadır.'
                        
                        document.querySelector('#favorites .products-grid').replaceWith(infoBox)
                    }
                }, 300)
            }
        })
    })
    
})