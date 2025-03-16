<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Crew Admin</title>
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
                    <h1>Orders</h1>
                    <div class="date-filter">
                        <select id="dateRange">
                            <option value="today">Today</option>
                            <option value="week" selected>This Week</option>
                            <option value="month">This Month</option>
                            <option value="year">This Year</option>
                        </select>
                    </div>
                </div>

                <!-- Order Stats -->
                <div class="stats-grid">
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
                            <h3>Total Orders</h3>
                            <p class="stat-value">156</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon processing-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3>Processing</h3>
                            <p class="stat-value">28</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon shipped-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3>Shipped</h3>
                            <p class="stat-value">42</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon completed-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3>Completed</h3>
                            <p class="stat-value">86</p>
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
                            <option value="amount-asc">Amount: Low to High</option>
                            <option value="amount-desc">Amount: High to Low</option>
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
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#ORD-5289</td>
                                <td>
                                    <div class="customer-cell">
                                        <div class="customer-avatar">AY</div>
                                        <div>
                                            <p class="customer-name">Ahmet Yılmaz</p>
                                            <p class="customer-email">ahmet@example.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td>15 Mar 2025</td>
                                <td>₺599.90</td>
                                <td>Credit Card</td>
                                <td><span class="status-badge completed">Completed</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn view-btn" title="View Order">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </button>
                                        <button class="action-btn print-btn" title="Print Invoice">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                                <rect x="6" y="14" width="12" height="8"></rect>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-5288</td>
                                <td>
                                    <div class="customer-cell">
                                        <div class="customer-avatar">ZK</div>
                                        <div>
                                            <p class="customer-name">Zeynep Kaya</p>
                                            <p class="customer-email">zeynep@example.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td>15 Mar 2025</td>
                                <td>₺1,199.80</td>
                                <td>PayPal</td>
                                <td><span class="status-badge processing">Processing</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn view-btn" title="View Order">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </button>
                                        <button class="action-btn print-btn" title="Print Invoice">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                                <rect x="6" y="14" width="12" height="8"></rect>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- More order rows would go here -->
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
</body>
</html>