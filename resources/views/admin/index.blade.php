<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crew Admin Dashboard</title>
    <link rel="stylesheet" href="/css/admin/admin.css">
    <link rel="stylesheet" href="/css/admin/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="admin-container">
        @include("admin.hf.sidebar")
        <!-- Main Content -->
        <main class="main-content">
			@include("admin.hf.header")
            <div class="dashboard-content">
                <div class="page-header">
                    <h1>Dashboard</h1>
                    <div class="date-filter">
                        <select id="dateRange">
                            <option value="today">Today</option>
                            <option value="week" selected>This Week</option>
                            <option value="month">This Month</option>
                            <option value="year">This Year</option>
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
                            <h3>Total Sales</h3>
                            <p class="stat-value">₺24,589.00</p>
                            <p class="stat-change positive">+12.5% <span>from last week</span></p>
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
                            <h3>Orders</h3>
                            <p class="stat-value">156</p>
                            <p class="stat-change positive">+8.2% <span>from last week</span></p>
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
                            <h3>Customers</h3>
                            <p class="stat-value">1,245</p>
                            <p class="stat-change positive">+5.3% <span>from last week</span></p>
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
                            <p class="stat-value">3.6%</p>
                            <p class="stat-change negative">-0.8% <span>from last week</span></p>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="charts-container">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Sales Overview</h3>
                            <div class="chart-actions">
                                <button class="chart-action active" data-period="weekly">Weekly</button>
                                <button class="chart-action" data-period="monthly">Monthly</button>
                            </div>
                        </div>
                        <div class="chart-body">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                    
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Top Products</h3>
                            <select id="productCategory">
                                <option value="all">All Categories</option>
                                <option value="tshirts">T-Shirts</option>
                                <option value="hoodies">Hoodies</option>
                                <option value="cases">Phone Cases</option>
                            </select>
                        </div>
                        <div class="chart-body">
                            <canvas id="productsChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="recent-orders">
                    <div class="section-header">
                        <h2>Recent Orders</h2>
                        <a href="/admin/orders" class="view-all">View All</a>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#ORD-5289</td>
                                    <td>Ahmet Yılmaz</td>
                                    <td>15 Mar 2025</td>
                                    <td>₺599.90</td>
                                    <td><span class="status-badge completed">Completed</span></td>
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
                                <tr>
                                    <td>#ORD-5288</td>
                                    <td>Zeynep Kaya</td>
                                    <td>15 Mar 2025</td>
                                    <td>₺1,199.80</td>
                                    <td><span class="status-badge processing">Processing</span></td>
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
                                <tr>
                                    <td>#ORD-5287</td>
                                    <td>Mehmet Demir</td>
                                    <td>14 Mar 2025</td>
                                    <td>₺899.85</td>
                                    <td><span class="status-badge shipped">Shipped</span></td>
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
                                <tr>
                                    <td>#ORD-5286</td>
                                    <td>Ayşe Öztürk</td>
                                    <td>14 Mar 2025</td>
                                    <td>₺449.95</td>
                                    <td><span class="status-badge cancelled">Cancelled</span></td>
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
                                <tr>
                                    <td>#ORD-5285</td>
                                    <td>Mustafa Aydın</td>
                                    <td>13 Mar 2025</td>
                                    <td>₺749.90</td>
                                    <td><span class="status-badge completed">Completed</span></td>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="/js/admin/admin.js"></script>
</body>
</html>