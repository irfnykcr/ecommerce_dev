<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Crew Admin</title>
    <link rel="stylesheet" href="/css/admin/admin.css">
    <link rel="stylesheet" href="/css/admin/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body>
    <div class="admin-container">
		@include("admin.hf.sidebar")
        <!-- Main Content -->
        <main class="main-content">
			@include("admin.hf.header")
            <div class="dashboard-content">
                <div class="page-header">
                    <h1>Products</h1>
                    <button class="primary-btn" id="addProductBtn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add Product
                    </button>
                </div>

                <!-- Product Filters -->
                <div class="filters-container">
                    <div class="search-filter">
                        <input type="text" placeholder="Search products..." id="productSearch">
                        <button class="search-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="filter-group">
                        <select id="categoryFilter">
                            <option value="">All Categories</option>
                            <option value="tshirts">T-Shirts</option>
                            <option value="hoodies">Hoodies</option>
                            <option value="sweatshirts">Sweatshirts</option>
                            <option value="cases">Phone Cases</option>
                        </select>
                        
                        <select id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="draft">Draft</option>
                            <option value="outofstock">Out of Stock</option>
                        </select>
                        
                        <select id="sortFilter">
                            <option value="newest">Newest</option>
                            <option value="oldest">Oldest</option>
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                            <option value="name-asc">Name: A to Z</option>
                            <option value="name-desc">Name: Z to A</option>
                        </select>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="table-container">
                    <table class="data-table products-table">
                        <thead>
                            <tr>
                                <!-- <th>
                                    <input type="checkbox" id="selectAll">
                                </th> -->
                                <th>action</th>
                                <th>name</th>
                                <th>status</th>
                                <th>category</th>
                                <th>description</th>
                                <th>price</th>
                                <th>discount_perc</th>
                                <th>stock</th>
                                <th>image_url</th>
                                <th>created_at</th>
                                <th>updated_at</th>
                            </tr>
                        </thead>
                        <tbody>

							@foreach ($products as $_=>$product)
							<tr>
                                <!-- <td><input type="checkbox" class="product-select"></td> -->
								<td>
                                    <div class="action-buttons">
                                        <button class="action-btn edit-btn" title="Edit Product" data-id='{{$product["id"]}}'>
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete Product" data-id='{{$product["id"]}}'>
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="product-cell">
                                        <img src="https://placehold.co/60x60" alt='{{$product["name"]}}'>
                                        <div>
                                            <p class="product-name">{{$product["name"]}}</p>
                                            <p class="product-id">#P-{{$product["id"]}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$product["status"]}}</td>
                                <td>{{$product["category"]}}</td>
                                <td>{{$product["description"]}}</td>
                                <td>{{$product["price"]}}</td>
                                <td>{{$product["discount_perc"]}}</td>
                                <td>{{$product["stock"]}}</td>
                                <td>{{$product["image_url"]}}</td>
                                <td>{{$product["created_at"]}}</td>
                                <td>{{$product["updated_at"]}}</td>
                            </tr>
							@endforeach
            
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <button class="pagination-btn prev" disabled>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                        Previous
                    </button>
                    <div class="pagination-numbers">
                        <button class="pagination-number active">1</button>
                        <button class="pagination-number">2</button>
                        <button class="pagination-number">3</button>
                        <span class="pagination-ellipsis">...</span>
                        <button class="pagination-number">10</button>
                    </div>
                    <button class="pagination-btn next">
                        Next
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </div>
            </div>
        </main>
    </div>

    <!-- Add/Edit Product Modal -->
    <div class="modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Product</h2>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="productForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="productName">name</label>
                            <input type="text" id="productName" required>
                        </div>
                        <div class="form-group">
                            <label for="productCategory">Category</label>
                            <select id="productCategory" required>
								@foreach ($categories as $category)
                                <option value="{{$category}}">{{$category}}</option>
								@endforeach
                            </select>
                        </div>
						<div class="form-group">
                            <label for="productPrice">Price (₺)</label>
                            <input type="number" id="productPrice" min="0" step="0.01" value="0" required>
                        </div>
						<div class="form-group">
                            <label for="productDiscount">Discount</label>
                            <input type="number" id="productDiscount" min="0" max="100" value="0" required>
                        </div>
                        <div class="form-group">
                            <label for="productStock">Stock</label>
                            <input type="number" id="productStock" min="0" value="0" required>
                        </div>
                        <div class="form-group">
                            <label for="productStatus">Status</label>
                            <select id="productStatus" required>
                                <option value="1">Active</option>
                                <option value="2">Draft</option>
                                <option value="0">Out of Stock</option>
                            </select>
                        </div>
                    </div>
                    
					<div class="form-group">
						<label for="productDescription">description</label>
						<input type="text" id="productDescription" value='{"renk":"siyah/beyaz/gri","beden":"s/m/l"}' required>
					</div>
					
					<div class="form-group">
						<label for="productimageURLs">imageURLs</label>
						<input type="text" id="productimageURLs" value='{"512":"", "256":"", "128":""}' required>
					</div>

                    <div class="form-actions">
                        <button type="button" class="secondary-btn" id="cancelProductBtn">Cancel</button>
                        <button type="submit" class="primary-btn insertProductButton">Save Product</button>
                    </div>
				</div>
            </div>
        </div>
    </div>

	<script src="/js/admin/admin.js"></script>
	<script src="/js/admin/products.js"></script>
</body>
</html>