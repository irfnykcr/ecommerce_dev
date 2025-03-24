<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/css/admin/admin.css">
    <link rel="stylesheet" href="/css/admin/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
		window.sales_info = {!! json_encode($sales_info) !!}
        window.this_week_sales = sales_info["this_week_sales"]
        window.last_week_sales = sales_info["last_week_sales"]
        window.this_month_sales = sales_info["this_month_sales"]
        window.last_month_sales = sales_info["last_month_sales"]
		window.categories = {!! json_encode($categories) !!}
		window.items_soldinfo = {!! json_encode($items_soldinfo) !!}
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
                    <h1>Dashboard</h1>
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
								@foreach ($categories as $category)
                                <option value="{{$category}}">{{$category}}</option>
								@endforeach
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
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <!-- <th>Actions</th> -->
                                </tr>
                            </thead>
                            <tbody>
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
                                    <td>{{$y["user_id"]}}</td>
                                    <td>{{$y["created_at"]}}</td>
                                    <td>{{$y["total_price"]}}</td>
                                    <td>{{$y["payment"]}}</td>
                                    <td><span class="status-badge {{$status}}">{{$status}}</span></td>
                                    <!-- <td>
                                        <div class="action-buttons">
                                            <button class="action-btn view-btn" title="View Order">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </button>
                                        </div>
                                    </td> -->
                                </tr>
								@endforeach
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