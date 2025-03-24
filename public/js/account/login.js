document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn')
    const loginForm = document.getElementById('login-form')
    const registerForm = document.getElementById('register-form')
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            tabBtns.forEach(b => b.classList.remove('active'))
            
            this.classList.add('active')
            
            if (this.dataset.tab === 'login') {
                loginForm.classList.remove('hidden')
                registerForm.classList.add('hidden')
            } else {
                loginForm.classList.add('hidden')
                registerForm.classList.remove('hidden')
            }
        })
    })
    const togglePasswordBtns = document.querySelectorAll('.toggle-password')
    togglePasswordBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling
            const icon = this.querySelector('i')
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'
                icon.classList.remove('fa-eye')
                icon.classList.add('fa-eye-slash')
            } else {
                passwordInput.type = 'password'
                icon.classList.remove('fa-eye-slash')
                icon.classList.add('fa-eye')
            }
        })
    })
    


	const loginEmail_el = document.querySelector("#login-email")
	const loginPassword_el = document.querySelector("#login-password")
	const loginButton_el = document.querySelector("#login-button")

	loginButton_el.addEventListener("click", async ()=>{
		const email = loginEmail_el.value
		const psw = loginPassword_el.value
		const r = await fetch(`/account/login`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-Token': document.querySelector('.csrf-token').content
			},
			body: JSON.stringify({ 
				email: email,
				password: psw,
			})
		})
		.then(response => {
			if (!response.ok) {
				console.error('Error:', response);
				return {"status":"error", "message": response}
			}
			console.log(response.json())
			window.location.href = "/account"
			return true
		}).catch(error => {
			console.error('Error register:', error);
			return {"status":"error", "message": error}
		})
		console.log(r)
		
	})

	const registerFullname_el = document.querySelector("#register-name")
	const registerEmail_el = document.querySelector("#register-email")
	const registerPassword_el = document.querySelector("#register-password")
	const registerButton_el = document.querySelector("#register-button")

	registerButton_el.addEventListener("click", async ()=>{
		const fullname = registerFullname_el.value
		const email = registerEmail_el.value
		const psw = registerPassword_el.value
		const r = await fetch(`/account/register`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-Token': document.querySelector('.csrf-token').content
			},
			body: JSON.stringify({ 
				full_name: fullname,
				email: email,
				password: psw,
			})
		})
		.then(response => {
			if (!response.ok) {
				console.error('Error:', error);
				return {"status":"error", "message": response}
			}
			console.log(response.json())
			window.location.href = "/account"
			return true
		}).catch(error => {
			console.error('Error register:', error);
			return {"status":"error", "message": error}
		})

		console.log(r)
	})


    // // Form submission (prevent default for demo)
    // const forms = document.querySelectorAll('form')
    
    // forms.forEach(form => {
    //     form.addEventListener('submit', function(e) {
    //         e.preventDefault()
            
    //         // Get form data
    //         const formData = new FormData(this)
    //         const formValues = {}
            
    //         for (let [key, value] of formData.entries()) {
    //             formValues[key] = value
    //         }
            
    //         // In a real application, you would send this data to your server
    //         console.log('Form submitted:', formValues)
            
    //         // Show success message (for demo purposes)
    //         const formType = this.closest('.form-content').id === 'login-form' ? 'Login' : 'Registration'
    //         alert(`${formType} successful!`)
            
    //         // Reset form
    //         this.reset()
    //     })
    // })
})