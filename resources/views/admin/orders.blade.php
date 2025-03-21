<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Crew Admin</title>
    <link rel="stylesheet" href="/css/admin/admin.css">
    <link rel="stylesheet" href="/css/admin/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
	<script>
		window.sales_info = {!! json_encode($sales_info) !!}
        window.this_week_sales = sales_info["this_week_sales"]
        window.last_week_sales = sales_info["last_week_sales"]
        window.this_month_sales = sales_info["this_month_sales"]
        window.last_month_sales = sales_info["last_month_sales"]
    </script>
</head>
<body>
    <div class="admin-container">
		@include("admin.hf.sidebar")
        <!-- Main Content -->
        <main class="main-content">
			@include("admin.hf.header")
            <div class="dashboard-content">
			<div class="page-header">
                    <h1>Orders</h1>
                    <div class="date-filter">
                        <select id="dateRange">
                            <option value="this_week" selected>This Week</option>
                            <option value="last_week" selected>Last Week</option>
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="this_year">This Year</option>
                        </select>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon sales-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                <polyline points="17 6 23 6 23 12"></polyline>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3 class="stat-sales-header">This week Sales</h3>
							@php
							$sales_change = ($sales_info["this_week"]["total_sales"] - $sales_info["last_week"]["total_sales"]) / $sales_info["last_week"]["total_sales"] * 100;
							$sales_change = round($sales_change, 2);
							$sales_state = $sales_change > 0 ? "positive" : "negative";
							@endphp
                            <p class="stat-value stat-sales-value">₺{{$sales_info["this_week"]["total_sales"]}}</p>
                            <p class="stat-change stat-sales-change {{$sales_state}}">{{$sales_change}}% <span>from last week</span></p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon orders-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3 class="stat-orders-header">This week Orders</h3>
							@php
							$orders_change = ($sales_info["this_week"]["orders"] - $sales_info["last_week"]["orders"]) / $sales_info["last_week"]["orders"] * 100;
							$orders_change = round($orders_change, 2);
							$orders_state = $orders_change > 0 ? "positive" : "negative";
							@endphp
                            <p class="stat-value stat-orders-value">{{$sales_info["this_week"]["orders"]}}</p>
                            <p class="stat-change stat-orders-change {{$orders_state}}">{{$orders_change}}% <span>from last week</span></p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon customers-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3 class="stat-customers-header">This week Customers</h3>
							@php
							$customers_change = ($sales_info["this_week"]["customers"] - $sales_info["last_week"]["customers"]) / $sales_info["last_week"]["customers"] * 100;
							$customers_change = round($customers_change, 2);
							$customers_state = $customers_change > 0 ? "positive" : "negative";
							@endphp
                            <p class="stat-value stat-customers-value">{{$sales_info["this_week"]["customers"]}}</p>
                            <p class="stat-change stat-customers-change {{$customers_state}}">{{$customers_change}}% <span>from last week</span></p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon conversion-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20V10"></path>
                                <path d="M18 20V4"></path>
                                <path d="M6 20v-4"></path>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3>Conversion Rate</h3>
                            <p class="stat-value">?%</p>
                            <p class="stat-change negative">?% <span>from last week</span></p>
                        </div>
                    </div>
                </div>

                <!-- Order Filters -->
                <div class="filters-container">
                    <div class="search-filter">
                        <input type="text" placeholder="Search orders..." id="orderSearch">
                        <button class="search-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="filter-group">
                        <select id="statusFilter">
                            <option value="">All Status</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        
                        <select id="paymentFilter">
                            <option value="">All Payment Methods</option>
                            <option value="credit">Credit Card</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="paypal">PayPal</option>
                        </select>
                        
                        <select id="sortFilter">
                            <option value="newest">Newest</option>
                            <option value="oldest">Oldest</option>
                            <option value="price-asc">price: Low to High</option>
                            <option value="price-desc">price: High to Low</option>
                        </select>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="table-container">
                    <table class="data-table orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="orders-tbody">
							@foreach ($recent as $x=>$y)
								@php
									$status = "";
									if ($y["status"] == 0) {
										$status = "cancelled";
									} elseif ($y["status"] == 1) {
										$status = "completed";
									} elseif ($y["status"] == 2) {
										$status = "processing";
									} elseif ($y["status"] == 3) {
										$status = "shipped";
									}
								@endphp
								<tr>
                                    <td>{{$y["id"]}}</td>
                                    <!-- <td>{{$y["user_id"]}}</td> -->
                                    <td>
										<div class="customer-cell">
											<div class="customer-avatar">?</div>
											<div>
												<p class="customer-name">?</p>
												<p class="customer-id">{{$y["user_id"]}}</p>
												<p class="customer-email">?@?.com</p>
											</div>
										</div>
									</td>
                                    <td>{{$y["created_at"]}}</td>
                                    <td>{{$y["total_price"]}}</td>
                                    <td>{{$y["payment"]}}</td>
                                    <td><span class="status-badge {{$status}}">{{$status}}</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn view-btn" title="View Order">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
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
						@for ($i = 2; $i <= $orders_length-1; $i++)
							<button class="pagination-number">{{ $i }}</button>
						@endfor
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

    <!-- Order Details Modal -->
    <div class="modal" id="orderModal">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h2>Order #ORD-5289</h2>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="order-details">
                    <div class="order-info-grid">
                        <div class="order-info-card">
                            <h3>Customer Information</h3>
                            <div class="info-group">
                                <p><strong>Name:</strong> Ahmet Yılmaz</p>
                                <p><strong>Email:</strong> ahmet@example.com</p>
                                <p><strong>Phone:</strong> +90 555 123 4567</p>
                            </div>
                        </div>
                        
                        <div class="order-info-card">
                            <h3>Shipping Address</h3>
                            <div class="info-group">
                                <p>Ahmet Yılmaz</p>
                                <p>Atatürk Caddesi No: 123</p>
                                <p>Kadıköy, İstanbul 34700</p>
                                <p>Turkey</p>
                            </div>
                        </div>
                        
                        <div class="order-info-card">
                            <h3>Order Information</h3>
                            <div class="info-group">
                                <p><strong>Order Date:</strong> 15 Mar 2025</p>
                                <p><strong>Payment Method:</strong> Credit Card</p>
                                <p><strong>Status:</strong> <span class="status-badge completed">Completed</span></p>
                            </div>
                        </div>
                        
                        <div class="order-info-card">
                            <h3>Order Summary</h3>
                            <div class="info-group">
                                <p><strong>Subtotal:</strong> ₺599.90</p>
                                <p><strong>Shipping:</strong> ₺0.00</p>
                                <p><strong>Tax:</strong> ₺0.00</p>
                                <p><strong>Total:</strong> ₺599.90</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-items">
                        <h3>Order Items</h3>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="product-cell">
                                            <img src="https://placehold.co/60x60" alt="Basic Oversize Sweatshirt - Siyah">
                                            <div>
                                                <p class="product-name">Basic Oversize Sweatshirt - Siyah</p>
                                                <p class="product-id">SKU: SWT-BLK-001</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>₺599.90</td>
                                    <td>1</td>
                                    <td>₺599.90</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="order-actions">
                        <button class="secondary-btn">Update Status</button>
                        <button class="primary-btn">Print Invoice</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/admin/admin.js"></script>
    <script src="/js/admin/orders.js"></script>
</body>
</html>