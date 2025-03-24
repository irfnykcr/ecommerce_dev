<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion For You - Login/Register</title>
    <link rel="stylesheet" href="/css/account/login.css">
	<link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
	@include("hf.header")
    <div class="container">
        <div class="form-container">
            <div class="tabs">
                <button class="tab-btn active" data-tab="login">Login</button>
                <button class="tab-btn" data-tab="register">Register</button>
            </div>
            
            <div class="form-content" id="login-form">
			<div class="error-message error-message-login" style="display:none"></div>
			<h2>Member Login</h2>
				<div class="input-group">
					<label for="login-email">Email</label>
					<input type="email" id="login-email" required>
				</div>
				<div class="input-group">
					<label for="login-password">Password</label>
					<input type="password" id="login-password" required>
					<button type="button" class="toggle-password">
						<i class="far fa-eye"></i>
					</button>
				</div>
				<button type="submit" id="login-button" class="submit-btn">Login</button>
				<div class="forgot-password">
					<a href="#">Forgot Password?</a>
				</div>
            </div>
            
            <div class="form-content hidden" id="register-form">
				<div class="error-message error-message-register" style="display:none"></div>
                <h2>Register</h2>
				<div class="input-group">
					<label for="register-name">Full Name</label>
					<input type="text" id="register-name" required>
				</div>
				<div class="input-group">
					<label for="register-email">Email</label>
					<input type="email" id="register-email" required>
				</div>
				<div class="input-group">
					<label for="register-password">Password</label>
					<input type="password" id="register-password" required>
					<button type="button" class="toggle-password">
						<i class="far fa-eye"></i>
					</button>
				</div>
				<div class="input-group">
					<label for="register-confirm-password">Confirm Password</label>
					<input type="password" id="register-confirm-password" required>
					<button type="button" class="toggle-password">
						<i class="far fa-eye"></i>
					</button>
				</div>
				<button type="submit" id="register-button" class="submit-btn">Register</button>
            </div>
        </div>
        
        <div class="image-container">
            <div class="overlay">
                <h1>fashion for you</h1>
            </div>
        </div>
    </div>
	@include("hf.footer")
    <script type="module" src="/js/account/firebase.js"></script>
    <script src="/js/account/login.js"></script>
</body>
</html>