// DOM Elements
const dateRange = document.getElementById('dateRange')
const addProductBtn = document.getElementById('addProductBtn')
const productModal = document.getElementById('productModal')
const closeModal = document.querySelectorAll('.close-modal')
const cancelProductBtn = document.getElementById('cancelProductBtn')
const orderModal = document.getElementById('orderModal')
const viewOrderBtns = document.querySelectorAll('.view-btn')
const selectAll = document.getElementById('selectAll')
const productSelects = document.querySelectorAll('.product-select')

// Modal Functions
function openModal(modal) {
    if (modal) {
        modal.classList.add('active')
        document.body.style.overflow = 'hidden'
    }
}

function closeAllModals() {
    const modals = document.querySelectorAll('.modal')
    modals.forEach(modal => {
        modal.classList.remove('active')
    })
    document.body.style.overflow = ''
}

// Add Product Modal
if (addProductBtn && productModal) {
    addProductBtn.addEventListener('click', () => {
        openModal(productModal)
    })
}

// View Order Modal
if (viewOrderBtns.length > 0 && orderModal) {
    viewOrderBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            openModal(orderModal)
        })
    })
}

// Close Modals
if (closeModal.length > 0) {
    closeModal.forEach(btn => {
        btn.addEventListener('click', closeAllModals)
    })
}

if (cancelProductBtn) {
    cancelProductBtn.addEventListener('click', closeAllModals)
}

// Close modal on escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeAllModals()
    }
})

// Close modal when clicking outside
document.addEventListener('click', (e) => {
    const modals = document.querySelectorAll('.modal.active')
    modals.forEach(modal => {
        if (e.target === modal) {
            closeAllModals()
        }
    })
})

// Select All Products
if (selectAll && productSelects.length > 0) {
    selectAll.addEventListener('change', () => {
        productSelects.forEach(checkbox => {
            checkbox.checked = selectAll.checked
        })
    })
    
    productSelects.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const allChecked = Array.from(productSelects).every(c => c.checked)
            const someChecked = Array.from(productSelects).some(c => c.checked)
            
            selectAll.checked = allChecked
            selectAll.indeterminate = someChecked && !allChecked
        })
    })
}

// Image Upload Preview
const productImage1 = document.getElementById('productImage1')
const imagePreviewContainer = document.querySelector('.image-preview-container')

if (productImage1 && imagePreviewContainer) {
    productImage1.addEventListener('change', (e) => {
        const file = e.target.files[0]
        if (file) {
            const reader = new FileReader()
            reader.onload = function(event) {
                const preview = document.createElement('div')
                preview.className = 'image-preview'
                preview.innerHTML = `
                    <img src="${event.target.result}" alt="Product Image">
                    <button class="remove-image" title="Remove Image">&times</button>
                `
                imagePreviewContainer.appendChild(preview)
                
                // Remove image functionality
                const removeBtn = preview.querySelector('.remove-image')
                removeBtn.addEventListener('click', () => {
                    preview.remove()
                    productImage1.value = ''
                })
            }
            reader.readAsDataURL(file)
        }
    })
}

// Charts (if on dashboard page)
if (document.getElementById('salesChart') && document.getElementById('productsChart')) {
    // Sales Chart
    const salesChartCtx = document.getElementById('salesChart').getContext('2d')
    const salesChart = new Chart(salesChartCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'This Week',
                data: window.this_week_sales,
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                tension: 0.3,
                fill: true
            }, {
                label: 'Last Week',
                data: window.last_week_sales,
                borderColor: '#9ca3af',
                backgroundColor: 'rgba(156, 163, 175, 0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₺' + value.toLocaleString()
                        }
                    }
                }
            }
        }
    })
    
    const sorted_items = Object.values(window.items_soldinfo)
			.sort((a, b) => a.sold - b.sold)
    const productsChartCtx = document.getElementById('productsChart').getContext('2d')
    const productsChart = new Chart(productsChartCtx, {
        type: 'bar',
        data: {
            labels: sorted_items.map(item => item.name),
            datasets: [{
                label: 'Units Sold',
                data: sorted_items.map(item => item.sold),
                backgroundColor: [
                    'rgba(79, 70, 229, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    })
    
    // Chart Period Toggle
    const chartActions = document.querySelectorAll('.chart-action')
    if (chartActions.length > 0) {
        chartActions.forEach(action => {
            action.addEventListener('click', (e) => {
                const period = e.target.dataset.period
                
                // Remove active class from all buttons
                chartActions.forEach(btn => btn.classList.remove('active'))
                
                // Add active class to clicked button
                e.target.classList.add('active')
                
                // Update chart data based on period
                if (period === 'weekly') {
                    salesChart.data.labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                    salesChart.data.datasets[0].data = window.this_week_sales
                    salesChart.data.datasets[1].data = window.last_week_sales
                } else if (period === 'monthly') {
                    salesChart.data.labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4']
                    salesChart.data.datasets[0].data = window.this_month_sales
                    salesChart.data.datasets[1].data = window.last_month_sales
                }
                
                salesChart.update()
            })
        })
    }
    
    // Product Category Filter
    const productCategory = document.getElementById('productCategory')
    if (productCategory) {
        productCategory.addEventListener('change', (e) => {
            const category = e.target.value
            
            // Update chart data based on category
            if (category === 'all') {
                productsChart.data.labels = sorted_items.map(item => item.name)
                productsChart.data.datasets[0].data = sorted_items.map(item => item.sold)
            } else {
				const filteredItems = sorted_items.filter(item => item.category === category)
				productsChart.data.labels = filteredItems.map(item => item.name)
				productsChart.data.datasets[0].data = filteredItems.map(item => item.sold)
			}  
            productsChart.update()
        })
    }
}

// Date Range Filter

// currently, it's handled like this in php, laravel:
{/*
<script>
	window.sales_info = {!! json_encode($sales_info) !!}
	window.this_week_sales = sales_info["this_week_sales"]
	window.last_week_sales = sales_info["last_week_sales"]
	window.this_month_sales = sales_info["this_month_sales"]
	window.last_month_sales = sales_info["last_month_sales"]
	window.categories = {!! json_encode($categories) !!}
	window.items_soldinfo = {!! json_encode($items_soldinfo) !!}
</script> 

<select id="dateRange">
	<option value="this_week" selected>This Week</option>
	<option value="last_week" selected>Last Week</option>
	<option value="this_month">This Month</option>
	<option value="last_month">Last Month</option>
</select>
<div class="stat-card">
<div class="stat-icon sales-icon">
	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
		<polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
		<polyline points="17 6 23 6 23 12"></polyline>
	</svg>
</div>
<div class="stat-info">
	<h3>This week Sales</h3>
	@php
	$sales_change = ($sales_info["this_week"]["total_sales"] - $sales_info["last_week"]["total_sales"]) / $sales_info["last_week"]["total_sales"] * 100;
	$sales_change = round($sales_change, 2);
	$sales_state = $sales_change > 0 ? "positive" : "negative";
	@endphp
	<p class="stat-value">₺{{$sales_info["this_week"]["total_sales"]}}</p>
	<p class="stat-change {{$sales_state}}">{{$sales_change}}% <span>from last week</span></p>
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
	<h3>This week Orders</h3>
	@php
	$orders_change = ($sales_info["this_week"]["orders"] - $sales_info["last_week"]["orders"]) / $sales_info["last_week"]["orders"] * 100;
	$orders_change = round($orders_change, 2);
	$orders_state = $orders_change > 0 ? "positive" : "negative";
	@endphp
	<p class="stat-value">{{$sales_info["this_week"]["orders"]}}</p>
	<p class="stat-change {{$orders_state}}">{{$orders_change}}% <span>from last week</span></p>
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
	<h3>This week Customers</h3>
	@php
	$customers_change = ($sales_info["this_week"]["customers"] - $sales_info["last_week"]["customers"]) / $sales_info["last_week"]["customers"] * 100;
	$customers_change = round($customers_change, 2);
	$customers_state = $customers_change > 0 ? "positive" : "negative";
	@endphp
	<p class="stat-value">{{$sales_info["this_week"]["customers"]}}</p>
	<p class="stat-change {{$customers_state}}">{{$customers_change}}% <span>from last week</span></p>
</div>

*/}

const getStateChange = (range,range_other)=>{
	return parseFloat(((range - range_other) / range_other * 100).toFixed(2))
}
const changeStateChange = (e, e_change, e_value, range, compared_range) =>{
	const cr = compared_range.replace("_", " ")
	const r = range.replace("_", " ")
	const statHeader = document.querySelector(`.stat-${e}-header`)
	statHeader.innerHTML = `
		${r} ${e}
	`

	const statValue = document.querySelector(`.stat-${e}-value`)
	statValue.innerHTML = `
		${e_value}
	`


	const statChange = document.querySelector(`.stat-${e}-change`)
	if (e_change > 0){
		if (statChange.classList.contains("negative")){
			statChange.classList.remove("negative")
		}
		statChange.classList.add("positive")
	} else {
		if (statChange.classList.contains("positive")){
			statChange.classList.remove("positive")
		}
		statChange.classList.add("negative")
	}
	statChange.innerHTML = `
		${e_change}% <span>from ${cr}</span>
	`
}

if (dateRange) {
    dateRange.addEventListener('change', (e) => {
        const range = e.target.value
		const compared_range = range.startsWith('last_') ? range.replace('last_', 'this_') : range.replace('this_', 'last_')
		console.log(`date range: ${range}, compared: ${compared_range}`)
		const sales_range_info = window.sales_info[range]
		const sales_range_info_other = window.sales_info[compared_range]

		//customer
		const customers_change = getStateChange(sales_range_info["customers"], sales_range_info_other["customers"])
		console.log(sales_range_info["customers"],customers_change)
		changeStateChange("customers", customers_change, sales_range_info["customers"], range, compared_range)

		//orders
		const orders_change = getStateChange(sales_range_info["orders"], sales_range_info_other["orders"])
		console.log(sales_range_info["orders"], orders_change)
		changeStateChange("orders", orders_change, sales_range_info["orders"], range, compared_range)

		//sales
		const sales_change = getStateChange(sales_range_info["total_sales"], sales_range_info_other["total_sales"])
		console.log(sales_range_info["total_sales"],sales_change)
		changeStateChange("sales", sales_change, "₺"+sales_range_info["total_sales"], range, compared_range)
		
		
    })
}


// Initialize tooltips, notifications, etc.
document.addEventListener('DOMContentLoaded', () => {
    console.log('Admin dashboard initialized')
})