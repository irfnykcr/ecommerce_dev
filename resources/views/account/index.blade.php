<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Fashion For You</title>
    <link rel="stylesheet" href="/css/account/index.css">
	<link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
	@include("hf.header")
    <div class="container">
        <!-- Sidebar Navigation -->
        <div class="sidebar">
            <div class="user-info">
                <h2>{{$info["full_name"]}}</h2>
                <a href="/account/logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Çıkış yap</a>
            </div>
            
            <div class="nav-section">
                <h3>Kişisel Bilgilerim</h3>
                <ul>
                    <li class="active"><a href="#" data-tab="personal-info">Kişisel Bilgilerim</a></li>
                    <li><a href="#" data-tab="addresses">Adreslerim</a></li>
                    <li><a href="#" data-tab="favorites">Beğendiğim Ürünler</a></li>
                </ul>
            </div>
            
            <div class="nav-section">
                <h3>Sipariş Bilgilerim</h3>
                <ul>
                    <li><a href="#" data-tab="orders">Siparişlerim</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="content">
            <!-- Personal Information Tab -->
            <div class="tab-content active" id="personal-info">
				<div class="error-message error-message-update" style="display:none"></div>
                <h1>Kişisel Bilgilerim</h1>
				<div class="form-row">
					<div class="form-group">
						<label for="first-name">isim Soyisim</label>
						<input type="text" id="first-name" value="{{$info['full_name']}}">
					</div>
				</div>
				
				<div class="form-row">
					<div class="form-group">
						<label for="phone">Telefon</label>
						<div class="phone-input">
							<div class="country-code">
								<img src="https://upload.wikimedia.org/wikipedia/commons/b/b4/Flag_of_Turkey.svg" alt="Turkey Flag" class="flag">
								<span>+90</span>
							</div>
							<input type="tel" id="phone" value="{{str_replace('+90 ', '', $info['phone_number'])}}" placeholder="5XX XXX XX XX">
						</div>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" id="email" value="{{$info['email']}}">
					</div>
				</div>
				
				<button type="submit" class="save-btn" id="update-user-info">KAYDET</button>
            </div>
            
            <!-- Addresses Tab -->
            <div class="tab-content" id="addresses">
                <h1>Adres Oluştur</h1>
				@if (count($adresses) > 0)
					<ul class="address-list">
						@foreach ($adresses as $address)
							<li class="address-item" style="display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #eee;">
								<div class="address-details" >
									<h4 class="address-title">{{ $address["adres_baslik"] }}</h4>
									<p class="address-line-main">{{ $address["adres"] }}</p>
									<p class="address-line-extra">{{ $address["adres_extra"] }}</p>
									<p class="address-line-ililce">{{ $address["il"] }}, {{ $address["ilce"] }}, {{ $address["ulke"] }}</p>
								</div>
								<div class="address-actions" style="display: flex; gap: 5px;">
									<button class="edit-btn" style="background-color: #4CAF50; color: white; padding: 8px 12px; border: none; cursor: pointer; border-radius: 5px;"><i class="fas fa-edit"></i> Düzenle</button>
									<button class="delete-btn" style="background-color: #f44336; color: white; padding: 8px 12px; border: none; cursor: pointer; border-radius: 5px;"><i class="fas fa-trash-alt"></i> Sil</button>
								</div>
							</li>
						@endforeach
					</ul>
					
				@else
                <div class="info-box">
                    Kayıtlı bir adresiniz yok. Lütfen aşağıdaki kısımdan adres oluşturunuz.
                </div>
                @endif
                <form class="profile-form">
                    <div class="form-group full-width">
                        <label for="address-title">Adres Başlığı</label>
                        <input type="text" id="address-title" placeholder="(ev, iş vb...)">
                    </div>

                    <div class="form-group full-width">
                        <label for="address-detail">Adres</label>
                        <textarea id="address-detail" rows="3"></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="address-detail-2" class="notrequired">Adres extra (tarif)</label>
                            <input type="text" id="address-detail-2">
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="country">Ülke</label>
                        <select id="country">
                            <option value="turkey">Türkiye</option>
                            <!-- <option value="other">Diğer</option> -->
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">İl</label>
                            <select name="city" class="il-select">
							</select>
                        </div>
                        <div class="form-group">
                            <label for="district">İlçe</label>
                            <select id="district" class="ilce-select">
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="address-phone">Telefon</label>
                        <div class="phone-input">
                            <div class="country-code">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b4/Flag_of_Turkey.svg" alt="Turkey Flag" class="flag">
                                <span>+90</span>
                            </div>
                            <input type="tel" id="address-phone" placeholder="5XX XXX XX XX">
                        </div>
                    </div>
                    
                    <button type="submit" class="save-btn">KAYDET</button>
                </form>
            </div>
            
            <!-- Favorites Tab -->
            <div class="tab-content" id="favorites">
                <h1>Beğendiğim Ürünler (1)</h1>
                <div class="products-grid">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-P0ZtZqKqY98EONyVL9KcL3UTdVQnLy.png" alt="Black T-Shirt">
                            <button class="favorite-btn active"><i class="fas fa-heart"></i></button>
                        </div>
                        <div class="product-info">
                            <div class="product-brand">CREWWEARTR</div>
                            <div class="product-name">CREW T-Shirt</div>
                            <div class="product-price">
                                <span class="old-price">₺599.90</span>
                                <span class="current-price">₺459.90</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Orders Tab -->
            <div class="tab-content" id="orders">
                <h1>Siparişlerim</h1>
                <div class="info-box">
                    Henüz bir sipariş vermediniz.
                </div>
            </div>
        </div>
    </div>
	@include("hf.footer")
    <script src="/js/account/index.js"></script>
</body>
</html>