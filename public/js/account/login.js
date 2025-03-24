const checkLoginForm = (email,psw)=>{
	if (psw.length < 6 || psw.length > 256){
		return [false, "Password must be at least 6 characters"]
	}
	if (email.length > 100) {
		return [false, "email too long"]
	}
	const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
	if (!emailRegex.test(email)) {
		return [false, "Invalid email format"]
	}
	if (!/\d/.test(psw)) {
		return [false, "Password must contain a numeric character"]
	}
	return [true, ""]
}

const checkRegisterForm = (fullname,email,psw,pswC)=>{
	if (fullname.length < 2 || fullname.length > 256){
		return [false, "Fullname must be at least 2 characters"]
	}
	if (email.length > 100) {
		return [false, "email too long"]
	}
	if (psw.length < 6 || psw.length > 256){
		return [false, "Password must be at least 6 characters"]
	}

	const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
	if (!emailRegex.test(email)) {
		return [false, "Invalid email format"]
	}
	if (!/\d/.test(psw)) {
		return [false, "Password must contain a numeric character"]
	}
	if (psw !== pswC){
		return [false, "Passwords does not match"]
	}
	return [true, ""]
}


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
    
	const errorMessageLogin_el = document.querySelector(".error-message-login")
	const loginEmail_el = document.querySelector("#login-email")
	const loginPassword_el = document.querySelector("#login-password")
	const loginButton_el = document.querySelector("#login-button")

	loginButton_el.addEventListener("click", async ()=>{
		const email = loginEmail_el.value
		const psw = loginPassword_el.value
		const loginform = checkLoginForm(email,psw)
		if (!loginform[0]){
			errorMessageLogin_el.innerHTML=loginform[1]
			errorMessageLogin_el.style.display="flex"
			return 
		}
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
			return response.json()
		}).catch(error => {
			return error.json()
		})
		console.log(r)
		if (r["status"] === "error"){
			errorMessageLogin_el.innerHTML=r["message"]
			errorMessageLogin_el.style.display="flex"
		} else {
			errorMessageLogin_el.innerHTML=r["message"]
			errorMessageLogin_el.style.backgroundColor="var(--success-color)"
			errorMessageLogin_el.style.display="flex"
			window.location.href = "/account"
		}
		
	})

	const errorMessageRegister_el = document.querySelector(".error-message-register")
	const registerFullname_el = document.querySelector("#register-name")
	const registerEmail_el = document.querySelector("#register-email")
	const registerPassword_el = document.querySelector("#register-password")
	const registerPasswordConfirm_el = document.querySelector("#register-confirm-password")
	const registerButton_el = document.querySelector("#register-button")

	registerButton_el.addEventListener("click", async ()=>{
		const fullname = registerFullname_el.value
		const email = registerEmail_el.value
		const psw = registerPassword_el.value
		const pswC = registerPasswordConfirm_el.value
		const registerform = checkRegisterForm(fullname,email,psw,pswC)
		if (!registerform[0]){
			errorMessageRegister_el.innerHTML=registerform[1]
			errorMessageRegister_el.style.display="flex"
			return 
		}
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
			return response.json()
		}).catch(error => {
			return error.json()
		})

		console.log(r)
		if (r["status"] === "error"){
			errorMessageRegister_el.innerHTML=r["message"]
			errorMessageRegister_el.style.display="flex"
		} else {
			errorMessageRegister_el.innerHTML=r["message"]
			errorMessageRegister_el.style.backgroundColor="var(--success-color)"
			errorMessageRegister_el.style.display="flex"
			window.location.href = "/account"
		}
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