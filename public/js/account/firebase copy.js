// import { initializeApp } from "https://www.gstatic.com/firebasejs/11.5.0/firebase-app.js"
// // import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.5.0/firebase-analytics.js"
// import {
// 	getAuth,
// 	createUserWithEmailAndPassword,
// 	signInWithEmailAndPassword,
// 	onAuthStateChanged,
// 	signOut
// } from "https://www.gstatic.com/firebasejs/11.5.0/firebase-auth.js"

// const firebaseConfig = {
// 	apiKey: "AIzaSyCw5C-9Nctchu3MQEkD-7778mR_0o25JQY",
// 	authDomain: "ecommerce-5e049.firebaseapp.com",
// 	projectId: "ecommerce-5e049",
// 	storageBucket: "ecommerce-5e049.firebasestorage.app",
// 	messagingSenderId: "130488370203",
// 	appId: "1:130488370203:web:096466cb46fc99ff44e4be",
// 	measurementId: "G-YS3DL7ML9P"
// }

// const app = initializeApp(firebaseConfig)
// // const analytics = getAnalytics(app)
// const auth = getAuth(app)

// const registerUser = async (email, password, fullname) => {
// 	if (auth.currentUser) {
// 		console.log("User already logged in:", auth.currentUser);
// 		return {"status":"error", "message": "already logged in"}
// 	}
//     return await createUserWithEmailAndPassword(auth, email, password, fullname)
// 	.then(async (userCredential) => {

// 		const user = userCredential.user

// 		console.log("User registered to firebase: ", user)
// 		const user_uid = user["uid"]
// 		console.log("User uid: ", user_uid)
// 		console.log("registering to server..")

// 		return await fetch(`/account/register`, {
// 			method: 'POST',
// 			headers: {
// 				'Content-Type': 'application/json',
// 				'X-CSRF-Token': document.querySelector('.csrf-token').content
// 			},
// 			body: JSON.stringify({ 
// 				full_name: fullname,
// 				email: email,
// 				password: password,
// 				fbase_uid: user_uid
// 			})
// 		})
// 		.then(response => {
// 			if (!response.ok) {
// 				console.error('Error:', error);
// 				logoutUser()
// 				return {"status":"error", "message": response}
// 			}
// 			return response.json();
// 		}).catch(error => {
// 			console.error('Error register:', error);
// 			logoutUser()
// 			return {"status":"error", "message": error}
// 		});
			
// 	})
// 	.catch((error) => {
// 		console.error("Error", error)
// 		logoutUser()
// 		return {"status":"error", "message": error}
// 	})
// }




// const loginUser = async (email, password) => {
// 	if (auth.currentUser) {
// 		console.log("User already logged in:", auth.currentUser);
// 		return {"status":"error", "message": "already logged in"}
// 	}
//     return await signInWithEmailAndPassword(auth, email, password)
//         .then(async (userCredential) => {
//             const user = userCredential.user
//             console.log("User logged in: ", user)

// 			console.log("User registered to firebase: ", user)
// 			const user_uid = user["uid"]
// 			console.log("User uid: ", user_uid)
// 			console.log("login to server..")

// 			return await fetch(`/account/login`, {
// 				method: 'POST',
// 				headers: {
// 					'Content-Type': 'application/json',
// 					'X-CSRF-Token': document.querySelector('.csrf-token').content
// 				},
// 				body: JSON.stringify({ 
// 					email: email,
// 					password: password,
// 					fbase_uid: user_uid
// 				})
// 			})
// 			.then(response => {
// 				if (!response.ok) {
// 					console.error('Error:', response);
// 					logoutUser()
// 					return {"status":"error", "message": response}
// 				}
// 				return response.json();
// 			}).catch(error => {
// 				console.error('Error register:', error);
// 				logoutUser()
// 				return {"status":"error", "message": error}
// 			});



//         })
//         .catch((error) => {
//             console.error("Error", error)
// 			logoutUser()
// 			return {"status":"error", "message": error}
//         })
// }





// onAuthStateChanged(auth, (user) => {
//     if (user) {
//         console.log("User is signed in:", user)
//     } else {
//         console.log("No user signed in.")
//     }
// })


// const logoutUser = () => {
//     signOut(auth)
//         .then(() => {
//             console.log("User logged out successfully")
//         })
//         .catch((error) => {
//             const errorCode = error.code
//             const errorMessage = error.message
//             console.error(`Error (${errorCode}): ${errorMessage}`)
//         })
// }



// document.addEventListener('DOMContentLoaded', function() {
// 	const loginEmail_el = document.querySelector("#login-email")
// 	const loginPassword_el = document.querySelector("#login-password")
// 	const loginButton_el = document.querySelector("#login-button")

// 	loginButton_el.addEventListener("click", async ()=>{
// 		const email = loginEmail_el.value
// 		const psw = loginPassword_el.value
// 		await loginUser(email,psw)
// 	})

// 	const registerFullname_el = document.querySelector("#register-name")
// 	const registerEmail_el = document.querySelector("#register-email")
// 	const registerPassword_el = document.querySelector("#register-password")
// 	const registerButton_el = document.querySelector("#register-button")

// 	registerButton_el.addEventListener("click", async ()=>{
// 		const fullname = registerFullname_el.value
// 		const email = registerEmail_el.value
// 		const psw = registerPassword_el.value
// 		await registerUser(email,psw,fullname)
// 	})
	

// })