<!-- <script type="module">
	import { initializeApp } from "https://www.gstatic.com/firebasejs/11.5.0/firebase-app.js"
	import {
		getAuth,
		onAuthStateChanged,
		signOut
	} from "https://www.gstatic.com/firebasejs/11.5.0/firebase-auth.js"

	const firebaseConfig = {
		apiKey: "AIzaSyCw5C-9Nctchu3MQEkD-7778mR_0o25JQY",
		authDomain: "ecommerce-5e049.firebaseapp.com",
		projectId: "ecommerce-5e049",
		storageBucket: "ecommerce-5e049.firebasestorage.app",
		messagingSenderId: "130488370203",
		appId: "1:130488370203:web:096466cb46fc99ff44e4be",
		measurementId: "G-YS3DL7ML9P"
	}

	const app = initializeApp(firebaseConfig)
	const auth = getAuth(app)

	signOut(auth)
	.then(() => {
		console.log("User logged out successfully")
	})
	.catch((error) => {
		console.error(error)
	})

	onAuthStateChanged(auth, (user) => {
		if (user) {
			console.log("User is signed in:", user)
		} else {
			console.log("No user signed in.")
		}
		window.location.href = "/account"
	})
</script> -->