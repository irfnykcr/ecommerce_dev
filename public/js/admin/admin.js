// DOM Elements
const dateRange = document.getElementById('dateRange');
const addProductBtn = document.getElementById('addProductBtn');
const productModal = document.getElementById('productModal');
const closeModal = document.querySelectorAll('.close-modal');
const cancelProductBtn = document.getElementById('cancelProductBtn');
const orderModal = document.getElementById('orderModal');
const viewOrderBtns = document.querySelectorAll('.view-btn');
const selectAll = document.getElementById('selectAll');
const productSelects = document.querySelectorAll('.product-select');

// Modal Functions
function openModal(modal) {
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeAllModals() {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.classList.remove('active');
    });
    document.body.style.overflow = '';
}

// Add Product Modal
if (addProductBtn && productModal) {
    addProductBtn.addEventListener('click', () => {
        openModal(productModal);
    });
}

// View Order Modal
if (viewOrderBtns.length > 0 && orderModal) {
    viewOrderBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            openModal(orderModal);
        });
    });
}

// Close Modals
if (closeModal.length > 0) {
    closeModal.forEach(btn => {
        btn.addEventListener('click', closeAllModals);
    });
}

if (cancelProductBtn) {
    cancelProductBtn.addEventListener('click', closeAllModals);
}

// Close modal on escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeAllModals();
    }
});

// Close modal when clicking outside
document.addEventListener('click', (e) => {
    const modals = document.querySelectorAll('.modal.active');
    modals.forEach(modal => {
        if (e.target === modal) {
            closeAllModals();
        }
    });
});

// Select All Products
if (selectAll && productSelects.length > 0) {
    selectAll.addEventListener('change', () => {
        productSelects.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    });
    
    productSelects.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const allChecked = Array.from(productSelects).every(c => c.checked);
            const someChecked = Array.from(productSelects).some(c => c.checked);
            
            selectAll.checked = allChecked;
            selectAll.indeterminate = someChecked && !allChecked;
        });
    });
}

// Image Upload Preview
const productImage1 = document.getElementById('productImage1');
const imagePreviewContainer = document.querySelector('.image-preview-container');

if (productImage1 && imagePreviewContainer) {
    productImage1.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.createElement('div');
                preview.className = 'image-preview';
                preview.innerHTML = `
                    <img src="${event.target.result}" alt="Product Image">
                    <button class="remove-image" title="Remove Image">&times;</button>
                `;
                imagePreviewContainer.appendChild(preview);
                
                // Remove image functionality
                const removeBtn = preview.querySelector('.remove-image');
                removeBtn.addEventListener('click', () => {
                    preview.remove();
                    productImage1.value = '';
                });
            };
            reader.readAsDataURL(file);
        }
    });
}

// Charts (if on dashboard page)
if (document.getElementById('salesChart') && document.getElementById('productsChart')) {
    // Sales Chart
    const salesChartCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesChartCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'This Week',
                data: [3200, 2800, 4100, 3800, 5200, 6100, 4800],
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                tension: 0.3,
                fill: true
            }, {
                label: 'Last Week',
                data: [2800, 2600, 3800, 3200, 4800, 5600, 4200],
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
                            return '₺' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
    
    // Products Chart
    const productsChartCtx = document.getElementById('productsChart').getContext('2d');
    const productsChart = new Chart(productsChartCtx, {
        type: 'bar',
        data: {
            labels: ['Basic Oversize Sweatshirt - Siyah', 'Basic Oversize Sweatshirt - Beyaz', 'Basic Oversize Sweatshirt - Gri', 'Basic Oversize Sweatshirt - Kahve', 'Sun Pattern Phone Case'],
            datasets: [{
                label: 'Units Sold',
                data: [42, 38, 35, 29, 56],
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
    });
    
    // Chart Period Toggle
    const chartActions = document.querySelectorAll('.chart-action');
    if (chartActions.length > 0) {
        chartActions.forEach(action => {
            action.addEventListener('click', (e) => {
                const period = e.target.dataset.period;
                
                // Remove active class from all buttons
                chartActions.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                e.target.classList.add('active');
                
                // Update chart data based on period
                if (period === 'weekly') {
                    salesChart.data.labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    salesChart.data.datasets[0].data = [3200, 2800, 4100, 3800, 5200, 6100, 4800];
                    salesChart.data.datasets[1].data = [2800, 2600, 3800, 3200, 4800, 5600, 4200];
                } else if (period === 'monthly') {
                    salesChart.data.labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                    salesChart.data.datasets[0].data = [18000, 22000, 24000, 27000];
                    salesChart.data.datasets[1].data = [16000, 19000, 21000, 24000];
                }
                
                salesChart.update();
            });
        });
    }
    
    // Product Category Filter
    const productCategory = document.getElementById('productCategory');
    if (productCategory) {
        productCategory.addEventListener('change', (e) => {
            const category = e.target.value;
            
            // Update chart data based on category
            if (category === 'all') {
                productsChart.data.labels = ['Basic Oversize Sweatshirt - Siyah', 'Basic Oversize Sweatshirt - Beyaz', 'Basic Oversize Sweatshirt - Gri', 'Basic Oversize Sweatshirt - Kahve', 'Sun Pattern Phone Case'];
                productsChart.data.datasets[0].data = [42, 38, 35, 29, 56];
            } else if (category === 'tshirts') {
                productsChart.data.labels = ['Basic T-Shirt - Siyah', 'Graphic Print T-Shirt', 'White Graphic T-Shirt', 'Crew Logo T-Shirt'];
                productsChart.data.datasets[0].data = [32, 28, 25, 30];
            } else if (category === 'hoodies') {
                productsChart.data.labels = ['Basic Hoodie - Siyah', 'Basic Hoodie - Beyaz', 'Basic Hoodie - Gri'];
                productsChart.data.datasets[0].data = [22, 18, 20];
            } else if (category === 'cases') {
                productsChart.data.labels = ['Sun Pattern Phone Case', 'Wave Pattern Phone Case', 'Mountain Phone Case', 'Black Phone Case'];
                productsChart.data.datasets[0].data = [56, 48, 42, 38];
            }
            
            productsChart.update();
        });
    }
}

// Search Functionality
const productSearch = document.getElementById('productSearch');
const productRows = document.querySelectorAll('.products-table tbody tr');

if (productSearch && productRows.length > 0) {
    productSearch.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        
        productRows.forEach(row => {
            const productName = row.querySelector('.product-name').textContent.toLowerCase();
            const productId = row.querySelector('.product-id').textContent.toLowerCase();
            const shouldShow = productName.includes(searchTerm) || productId.includes(searchTerm);
            
            row.style.display = shouldShow ? '' : 'none';
        });
    });
}

// Order Search
const orderSearch = document.getElementById('orderSearch');
const orderRows = document.querySelectorAll('.orders-table tbody tr');

if (orderSearch && orderRows.length > 0) {
    orderSearch.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        
        orderRows.forEach(row => {
            const orderId = row.cells[0].textContent.toLowerCase();
            const customerName = row.querySelector('.customer-name').textContent.toLowerCase();
            const shouldShow = orderId.includes(searchTerm) || customerName.includes(searchTerm);
            
            row.style.display = shouldShow ? '' : 'none';
        });
    });
}

// Status Filter
const statusFilter = document.getElementById('statusFilter');

if (statusFilter && (productRows.length > 0 || orderRows.length > 0)) {
    statusFilter.addEventListener('change', (e) => {
        const filterValue = e.target.value.toLowerCase();
        
        const rows = productRows.length > 0 ? productRows : orderRows;
        
        rows.forEach(row => {
            const statusBadge = row.querySelector('.status-badge');
            const status = statusBadge.textContent.toLowerCase();
            
            if (filterValue === '' || status === filterValue) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

// Payment Filter
const paymentFilter = document.getElementById('paymentFilter');
const paymentCells = document.querySelectorAll('.orders-table tbody tr td:nth-child(5)');

if (paymentFilter && paymentCells.length > 0) {
    paymentFilter.addEventListener('change', (e) => {
        const filterValue = e.target.value.toLowerCase();
        
        orderRows.forEach((row, index) => {
            const payment = paymentCells[index].textContent.toLowerCase();
            
            if (filterValue === '' || payment.includes(filterValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

// Sort Filter
const sortFilter = document.getElementById('sortFilter');

if (sortFilter && (productRows.length > 0 || orderRows.length > 0)) {
    sortFilter.addEventListener('change', (e) => {
        const sortValue = e.target.value;
        const rows = productRows.length > 0 ? productRows : orderRows;
        const tbody = rows[0].parentNode;
        
        const sortedRows = Array.from(rows).sort((a, b) => {
            if (sortValue === 'newest' || sortValue === 'oldest') {
                // Sort by date (for orders) or ID (for products)
                const dateA = productRows.length > 0 ? 
                    a.querySelector('.product-id').textContent : 
                    new Date(a.cells[2].textContent);
                const dateB = productRows.length > 0 ? 
                    b.querySelector('.product-id').textContent : 
                    new Date(b.cells[2].textContent);
                
                return sortValue === 'newest' ? 
                    (dateB > dateA ? 1 : -1) : 
                    (dateA > dateB ? 1 : -1);
            } else if (sortValue === 'price-asc' || sortValue === 'price-desc' || 
                       sortValue === 'amount-asc' || sortValue === 'amount-desc') {
                // Sort by price or amount
                const priceA = parseFloat(productRows.length > 0 ? 
                    a.cells[4].textContent.replace('₺', '').replace(',', '') : 
                    a.cells[3].textContent.replace('₺', '').replace(',', ''));
                const priceB = parseFloat(productRows.length > 0 ? 
                    b.cells[4].textContent.replace('₺', '').replace(',', '') : 
                    b.cells[3].textContent.replace('₺', '').replace(',', ''));
                
                return (sortValue === 'price-asc' || sortValue === 'amount-asc') ? 
                    priceA - priceB : 
                    priceB - priceA;
            } else if (sortValue === 'name-asc' || sortValue === 'name-desc') {
                // Sort by name
                const nameA = a.querySelector('.product-name').textContent;
                const nameB = b.querySelector('.product-name').textContent;
                
                return sortValue === 'name-asc' ? 
                    nameA.localeCompare(nameB) : 
                    nameB.localeCompare(nameA);
            }
            
            return 0;
        });
        
        // Re-append sorted rows
        sortedRows.forEach(row => {
            tbody.appendChild(row);
        });
    });
}

// Date Range Filter
if (dateRange) {
    dateRange.addEventListener('change', (e) => {
        const range = e.target.value;
        console.log(`Filtering data by date range: ${range}`);
        // In a real application, this would fetch new data or filter existing data
    });
}

// Pagination
const paginationNumbers = document.querySelectorAll('.pagination-number');
const paginationPrev = document.querySelector('.pagination-btn.prev');
const paginationNext = document.querySelector('.pagination-btn.next');

if (paginationNumbers.length > 0) {
    paginationNumbers.forEach(number => {
        number.addEventListener('click', (e) => {
            // Remove active class from all numbers
            paginationNumbers.forEach(num => num.classList.remove('active'));
            
            // Add active class to clicked number
            e.target.classList.add('active');
            
            // Enable/disable prev/next buttons
            if (e.target.textContent === '1') {
                paginationPrev.disabled = true;
            } else {
                paginationPrev.disabled = false;
            }
            
            if (e.target.textContent === paginationNumbers[paginationNumbers.length - 1].textContent) {
                paginationNext.disabled = true;
            } else {
                paginationNext.disabled = false;
            }
            
            // In a real application, this would fetch new data for the selected page
            console.log(`Navigating to page ${e.target.textContent}`);
        });
    });
}

if (paginationPrev) {
    paginationPrev.addEventListener('click', () => {
        const activePage = document.querySelector('.pagination-number.active');
        const prevPage = activePage.previousElementSibling;
        
        if (prevPage && prevPage.classList.contains('pagination-number')) {
            activePage.classList.remove('active');
            prevPage.classList.add('active');
            
            if (prevPage.textContent === '1') {
                paginationPrev.disabled = true;
            }
            
            paginationNext.disabled = false;
            
            // In a real application, this would fetch new data for the previous page
            console.log(`Navigating to page ${prevPage.textContent}`);
        }
    });
}

if (paginationNext) {
    paginationNext.addEventListener('click', () => {
        const activePage = document.querySelector('.pagination-number.active');
        const nextPage = activePage.nextElementSibling;
        
        if (nextPage && nextPage.classList.contains('pagination-number')) {
            activePage.classList.remove('active');
            nextPage.classList.add('active');
            
            if (nextPage.textContent === paginationNumbers[paginationNumbers.length - 1].textContent) {
                paginationNext.disabled = true;
            }
            
            paginationPrev.disabled = false;
            
            // In a real application, this would fetch new data for the next page
            console.log(`Navigating to page ${nextPage.textContent}`);
        }
    });
}

// Initialize tooltips, notifications, etc.
document.addEventListener('DOMContentLoaded', () => {
    console.log('Admin dashboard initialized');
});