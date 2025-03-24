{/*
laravel, php:
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
*/}
const getPageOrders = async (page)=>{
	const r = await fetch('/admin/getOrders_wPage', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-Token': document.querySelector('.csrf-token').content
		},
		body: JSON.stringify({ page: page })
	})
	.then(response => {
		if (!response.ok) {
			throw new Error('Network response was not ok')
		}
		return response.json()
	})
	.then(data => {
		return data
	})
	.catch(error => {
		console.error('Error fetching orders:', error)
		return null
	})

	if (r===null){
		return r
	}
	const tbody = document.querySelector(".orders-tbody")
	let _tbody_text = ""
	for (const order of r) {
		let status = ""
		if (order.status == 0) {
			status = "cancelled"
		} else if (order.status == 1) {
			status = "completed"
		} else if (order.status == 2) {
			status = "processing"
		} else if (order.status == 3) {
			status = "shipped"
		}
		
		_tbody_text += `
			<tr>
				<td>${order.id}</td>
				<td>
					<div class="customer-cell">
						<div class="customer-avatar">?</div>
						<div>
							<p class="customer-name">?</p>
							<p class="customer-id">${order.user_id}</p>
							<p class="customer-email">?@?.com</p>
						</div>
					</div>
				</td>
				<td>${order.created_at}</td>
				<td>${order.total_price}</td>
				<td>${order.payment}</td>
				<td><span class="status-badge ${status}">${status}</span></td>
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
		`
	}
	tbody.innerHTML = _tbody_text
}

const paginationNumbers = document.querySelectorAll('.pagination-number')
const paginationPrev = document.querySelector('.pagination-btn.prev')
const paginationNext = document.querySelector('.pagination-btn.next')

if (paginationNumbers.length > 0) {
    paginationNumbers.forEach(number => {
        number.addEventListener('click', (e) => {
            // Remove active class from all numbers
            paginationNumbers.forEach(num => num.classList.remove('active'))
            
            // Add active class to clicked number
            e.target.classList.add('active')
            
            // Enable/disable prev/next buttons
            if (e.target.textContent === '1') {
                paginationPrev.disabled = true
            } else {
                paginationPrev.disabled = false
            }
            
            if (e.target.textContent === paginationNumbers[paginationNumbers.length - 1].textContent) {
                paginationNext.disabled = true
            } else {
                paginationNext.disabled = false
            }

            console.log(`Navigating to page ${e.target.textContent}`)
			getPageOrders(e.target.textContent)
        })
    })
}

if (paginationPrev) {
    paginationPrev.addEventListener('click', () => {
        const activePage = document.querySelector('.pagination-number.active')
        const prevPage = activePage.previousElementSibling
        
        if (prevPage && prevPage.classList.contains('pagination-number')) {
            activePage.classList.remove('active')
            prevPage.classList.add('active')
            
            if (prevPage.textContent === '1') {
                paginationPrev.disabled = true
            }
            
            paginationNext.disabled = false

            console.log(`Navigating to page ${prevPage.textContent}`)
			getPageOrders(prevPage.textContent)
        }
    })
}

if (paginationNext) {
    paginationNext.addEventListener('click', () => {
        const activePage = document.querySelector('.pagination-number.active')
        const nextPage = activePage.nextElementSibling
        
        if (nextPage && nextPage.classList.contains('pagination-number')) {
            activePage.classList.remove('active')
            nextPage.classList.add('active')
            
            if (nextPage.textContent === paginationNumbers[paginationNumbers.length - 1].textContent) {
                paginationNext.disabled = true
            }
            
            paginationPrev.disabled = false

            console.log(`Navigating to page ${nextPage.textContent}`)
			getPageOrders(nextPage.textContent)
        }
    })
}



const productSearch = document.getElementById('productSearch')
const productRows = document.querySelectorAll('.products-table tbody tr')
const orderSearch = document.getElementById('orderSearch')
const orderRows = document.querySelectorAll('.orders-table tbody tr')


//sort
const sortFilter = document.getElementById('sortFilter')

if (sortFilter && (productRows.length > 0 || orderRows.length > 0)) {
    sortFilter.addEventListener('change', (e) => {
		const orderRows = document.querySelectorAll('.orders-table tbody tr')
		const productRows = document.querySelectorAll('.products-table tbody tr')
        const sortValue = e.target.value
        const rows = productRows.length > 0 ? productRows : orderRows
        const tbody = document.querySelector(".orders-tbody")
        
        const sortedRows = Array.from(rows).sort((a, b) => {
            if (sortValue === 'newest' || sortValue === 'oldest') {
                // Sort by date (for orders) or ID (for products)
                const dateA = productRows.length > 0 ? 
                    a.querySelector('.product-id').textContent : 
                    new Date(a.cells[2].textContent)
                const dateB = productRows.length > 0 ? 
                    b.querySelector('.product-id').textContent : 
                    new Date(b.cells[2].textContent)
                
                return sortValue === 'newest' ? 
                    (dateB > dateA ? 1 : -1) : 
                    (dateA > dateB ? 1 : -1)
            } else if (sortValue === 'price-asc' || sortValue === 'price-desc' || 
                       sortValue === 'amount-asc' || sortValue === 'amount-desc') {
                // Sort by price or amount
                const priceA = parseFloat(productRows.length > 0 ? 
                    a.cells[4].textContent.replace('₺', '').replace(',', '') : 
                    a.cells[3].textContent.replace('₺', '').replace(',', ''))
                const priceB = parseFloat(productRows.length > 0 ? 
                    b.cells[4].textContent.replace('₺', '').replace(',', '') : 
                    b.cells[3].textContent.replace('₺', '').replace(',', ''))
                
                return (sortValue === 'price-asc' || sortValue === 'amount-asc') ? 
                    priceA - priceB : 
                    priceB - priceA
            } else if (sortValue === 'name-asc' || sortValue === 'name-desc') {
                // Sort by name
                const nameA = a.querySelector('.product-name').textContent
                const nameB = b.querySelector('.product-name').textContent
                
                return sortValue === 'name-asc' ? 
                    nameA.localeCompare(nameB) : 
                    nameB.localeCompare(nameA)
            }
            
            return 0
        })
        
        // Re-append sorted rows
        sortedRows.forEach(row => {
            tbody.appendChild(row)
        })
    })
}

// Search Functionality
if (productSearch && productRows.length > 0) {
    productSearch.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase()
        const productRows = document.querySelectorAll('.products-table tbody tr')
        productRows.forEach(row => {
            const productName = row.querySelector('.product-name').textContent.toLowerCase()
            const productId = row.querySelector('.product-id').textContent.toLowerCase()
            const shouldShow = productName.includes(searchTerm) || productId.includes(searchTerm)
            
            row.style.display = shouldShow ? '' : 'none'
        })
    })
}

// Status Filter
const statusFilter = document.getElementById('statusFilter')

if (statusFilter && (productRows.length > 0 || orderRows.length > 0)) {
    statusFilter.addEventListener('change', (e) => {
        const filterValue = e.target.value.toLowerCase()
        
		const orderRows = document.querySelectorAll('.orders-table tbody tr')
		const productRows = document.querySelectorAll('.products-table tbody tr')
		const rows = productRows.length > 0 ? productRows : orderRows
        
        rows.forEach(row => {
            const statusBadge = row.querySelector('.status-badge')
            const status = statusBadge.textContent.toLowerCase()
            
            if (filterValue === '' || status === filterValue) {
                row.style.display = ''
            } else {
                row.style.display = 'none'
            }
        })
    })
}

// Payment Filter
const paymentFilter = document.getElementById('paymentFilter')
const paymentCells = document.querySelectorAll('.orders-table tbody tr td:nth-child(5)')

if (paymentFilter && paymentCells.length > 0) {
    paymentFilter.addEventListener('change', (e) => {
        const filterValue = e.target.value.toLowerCase()
		const orderRows = document.querySelectorAll('.orders-table tbody tr')
        orderRows.forEach((row, index) => {
            const payment = paymentCells[index].textContent.toLowerCase()
            
            if (filterValue === '' || payment.includes(filterValue)) {
                row.style.display = ''
            } else {
                row.style.display = 'none'
            }
        })
    })
}

// Order Search

if (orderSearch && orderRows.length > 0) {
    orderSearch.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase()
        const orderRows = document.querySelectorAll('.orders-table tbody tr')
        orderRows.forEach(row => {
			console.log(row)
            const orderId = row.cells[0].textContent.toLowerCase()
            const customerName = row.querySelector('.customer-name').textContent.toLowerCase()
            const customerId = row.querySelector('.customer-id').textContent.toLowerCase()
            const customerMail = row.querySelector('.customer-email').textContent.toLowerCase()
            const shouldShow = orderId.includes(searchTerm) || customerName.includes(searchTerm) || customerId.includes(searchTerm) || customerMail.includes(searchTerm)
            
            row.style.display = shouldShow ? '' : 'none'
        })
    })
}

//modal
//code on the html:
{/* <div class="modal-header">
	<h2>Order #id</h2>
	<button class="close-modal">&times;</button>
</div>
<div class="modal-body">
	<div class="order-details">
		<div class="order-info-grid">
			<div class="order-info-card">
				<h3>Customer Information</h3>
				<div class="info-group">
					<!-- <p><strong>Name:</strong> Ahmet Yılmaz</p>
					<p><strong>Email:</strong> ahmet@example.com</p>
					<p><strong>Phone:</strong> +90 555 123 4567</p> -->
				</div>
			</div>
			
			<div class="order-info-card">
				<h3>Shipping Address</h3>
				<div class="info-group">
					<!-- <p>Ahmet Yılmaz</p>
					<p>Atatürk Caddesi No: 123</p>
					<p>Kadıköy, İstanbul 34700</p>
					<p>Turkey</p> -->
				</div>
			</div>
			
			<div class="order-info-card">
				<h3>Order Information</h3>
				<div class="info-group">
					<!-- <p><strong>Order Date:</strong> 15 Mar 2025</p>
					<p><strong>Payment Method:</strong> Credit Card</p>
					<p><strong>Status:</strong> <span class="status-badge completed">Completed</span></p> -->
				</div>
			</div>
			
			<div class="order-info-card">
				<h3>Order Summary</h3>
				<div class="info-group">
					<!-- <p><strong>Subtotal:</strong> ₺599.90</p>
					<p><strong>Shipping:</strong> ₺0.00</p>
					<p><strong>Tax:</strong> ₺0.00</p>
					<p><strong>Total:</strong> ₺599.90</p> -->
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
								<!-- <img src="https://placehold.co/60x60" alt="Basic Oversize Sweatshirt - Siyah"> -->
								<div>
									<!-- <p class="product-name">Basic Oversize Sweatshirt - Siyah</p>
									<p class="product-id">SKU: SWT-BLK-001</p> -->
								</div>
							</div>
						</td>
						<!-- <td>₺599.90</td>
						<td>1</td>
						<td>₺599.90</td> -->
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="order-actions">
			<button class="secondary-btn">Update Status</button>
			<button class="primary-btn">Print Invoice</button>
		</div>
	</div>
</div> */}

function openModal(modal, btn) {
	if (modal) {
		modal.classList.add('active')
		document.body.style.overflow = 'hidden'
		// Get the order details to display in the modal
		const orderId = btn.closest('tr').cells[1].textContent
		const customerId = btn.closest('tr').querySelector('.customer-id').textContent
		const orderDate = btn.closest('tr').cells[3].textContent
		const totalPrice = btn.closest('tr').cells[4].textContent
		const paymentMethod = btn.closest('tr').cells[5].textContent
		const statusElement = btn.closest('tr').querySelector('.status-badge')
		const orderStatus = statusElement.textContent
		const statusClass = statusElement.classList[1]

		console.log("orderId", orderId)
		console.log("customerId", customerId)
		console.log("orderDate", orderDate)
		console.log("totalPrice", totalPrice)
		console.log("paymentMethod", paymentMethod)
		console.log("orderStatus", orderStatus)
		console.log("statusClass", statusClass)

		// Update modal header with order ID
		modal.querySelector('.modal-header h2').textContent = `Order #${orderId}`

		// Populate customer information
		const customerInfoCard = modal.querySelector('.order-info-card:nth-child(1) .info-group')
		customerInfoCard.innerHTML = `
			<p><strong>Customer ID:</strong> ${customerId}</p>
			<p><strong>Email:</strong> Not available</p>
			<p><strong>Phone:</strong> Not available</p>
		`

		// Populate shipping address (placeholder)
		const shippingAddressCard = modal.querySelector('.order-info-card:nth-child(2) .info-group')
		shippingAddressCard.innerHTML = `
			<p>Address information not available</p>
		`

		// Populate order information
		const orderInfoCard = modal.querySelector('.order-info-card:nth-child(3) .info-group')
		orderInfoCard.innerHTML = `
			<p><strong>Order Date:</strong> ${orderDate}</p>
			<p><strong>Payment Method:</strong> ${paymentMethod}</p>
			<p><strong>Status:</strong> <span class="status-badge ${statusClass}">${orderStatus}</span></p>
		`

		// Populate order summary
		const orderSummaryCard = modal.querySelector('.order-info-card:nth-child(4) .info-group')
		orderSummaryCard.innerHTML = `
			<p><strong>Total:</strong> ${totalPrice}</p>
		`

		// Placeholder for order items - in a real implementation, you'd fetch the line items
		const orderItemsBody = modal.querySelector('.order-items tbody')
		// Fetch order items data from server
		fetch(`/admin/getOrderedItems_Order_id`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-Token': document.querySelector('.csrf-token').content
			},
			body: JSON.stringify({ order_id: orderId })
		})
		.then(response => {
			if (!response.ok) {
				throw new Error('Failed to fetch order items');
			}
			return response.json();
		})
		.then(items => {
			if (items && items.length > 0) {
				orderItemsBody.innerHTML = items.map(item => `
					<tr>
						<td>
							<div class="product-cell">
								<div>
									<p class="product-name">${item.item_name || 'Product Name Not Available'}</p>
									<p class="product-id">ID: ${item.id || 'N/A'}</p>
								</div>
							</div>
						</td>
						<td>${item.quantity || '1'}</td>
						<td>${item.price || '0.00'}</td>
					</tr>
				`).join('');
			} else {
				orderItemsBody.innerHTML = '<tr><td colspan="4">No items found for this order</td></tr>';
			}
		})
		.catch(error => {
			console.error('Error fetching order items:', error);
			orderItemsBody.innerHTML = '<tr><td colspan="4">Failed to load order items</td></tr>';
		});
		orderItemsBody.innerHTML = `
			<tr>
				
			</tr>
		`
    }
}
// View Order Modal
if (viewOrderBtns.length > 0 && orderModal) {
	viewOrderBtns.forEach(btn => {
		btn.addEventListener('click', () => {
			openModal(orderModal, btn)
		})
	})
}