{/* <tr>
	<td><input type="checkbox" class="product-select"></td>
	<td>
		<div class="product-cell">
			<img src="https://placehold.co/60x60" alt="Basic Oversize Sweatshirt - Siyah">
			<div>
				<p class="product-name">Basic Oversize Sweatshirt - Siyah</p>
				<p class="product-id">#PRD-001</p>
			</div>
		</div>
	</td>
	<td>SWT-BLK-001</td>
	<td>Sweatshirts</td>
	<td>₺599.90</td>
	<td>45</td>
	<td><span class="status-badge active">Active</span></td>
	<td>
		<div class="action-buttons">
			<button class="action-btn edit-btn" title="Edit Product">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
					<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
				</svg>
			</button>
			<button class="action-btn delete-btn" title="Delete Product">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<polyline points="3 6 5 6 21 6"></polyline>
					<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
				</svg>
			</button>
		</div>
	</td>
</tr> */}
function closeAllModals() {
    const modals = document.querySelectorAll('.modal')
    modals.forEach(modal => {
        modal.classList.remove('active')
    })
    document.body.style.overflow = ''
}
// Modal Functions
function openModal(modal) {
    if (modal) {
        modal.classList.add('active')
        document.body.style.overflow = 'hidden'
    }
}
// Add Product Modal
const productModal2 = document.getElementById('productModal2')
if (productModal2) {
	document.querySelectorAll(".edit-btn").forEach(btn => {
		btn.addEventListener('click', () => {
			openModal(productModal2)
			const id = btn.dataset.id;
			console.log("Product ID:", id);
			const form_productID = productModal2.querySelector("#productID")
			const form_productName = productModal2.querySelector("#productName")
			const form_productCategory = productModal2.querySelector("#productCategory")
			const form_productDescription = productModal2.querySelector("#productDescription")
			const form_productPrice = productModal2.querySelector("#productPrice")
			const form_productDiscount = productModal2.querySelector("#productDiscount")
			const form_productStock = productModal2.querySelector("#productStock")
			const form_productStatus = productModal2.querySelector("#productStatus")
			const form_productImageURLs = productModal2.querySelector("#productimageURLs")

			// Get the parent row of the clicked edit button
			const row = btn.closest('tr');

			// Fetch data from the row
			const productName = row.querySelector('.product-name').textContent
			// const productId = row.querySelector('.product-id').textContent
			const productStatus = row.querySelector('.status-badge').textContent
			const productCategory = row.cells[3].textContent
			const productDescription = row.cells[4].textContent
			const productPrice = row.cells[5].textContent
			const productDiscountperc = row.cells[6].textContent
			const productStock = row.cells[7].textContent
			const productImageURL = row.cells[8].textContent

			console.log("name",productName)
			console.log("category", productCategory)
			console.log("description", productDescription)
			console.log("price", productPrice)
			console.log("discountperc", productDiscountperc)
			console.log("stock", productStock)
			console.log("status", productStatus)
			console.log("imageURL", productImageURL)

			form_productID.value = id
			form_productName.value = productName
			form_productCategory.value = productCategory
			form_productDescription.value = productDescription
			form_productPrice.value = productPrice
			form_productDiscount.value = productDiscountperc
			form_productStock.value = productStock
			switch (productStatus){
				case "Active":
					form_productStatus.value = "1"
					break
				case "Disabled":
					form_productStatus.value = "0"
					break
				case "OutofStock":
					form_productStatus.value = "2"
					break
			}
			form_productImageURLs.value = productImageURL
			
		})
	})
    
}
const productModal = document.getElementById('productModal')
if (addProductBtn && productModal) {
    addProductBtn.addEventListener('click', () => {
        openModal(productModal)
    })
}
const insertProduct = async ()=>{
	const productForm = document.querySelector("#productForm")

	const name = productForm.querySelector("#productName").value
	if (name === ""){
		return {"status": "error", "error":"name"}
	}
	const category = productForm.querySelector("#productCategory").value
	const price = productForm.querySelector("#productPrice").value
	const discount = productForm.querySelector("#productDiscount").value
	const stock = productForm.querySelector("#productStock").value
	const status = productForm.querySelector("#productStatus").value
	const description = productForm.querySelector("#productDescription").value
	const image = productForm.querySelector("#productimageURLs").value
	
	return await fetch("/admin/insertProduct", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
			"X-CSRF-Token": document.querySelector(".csrf-token").content
		},
		body: JSON.stringify({
			name: name,
			category: category,
			price: price,
			discount: discount,
			stock: stock,
			status: status,
			description: description,
			image: image
		})
	})
	.then(response => {
		if (!response.ok) {
			throw new Error('Network response was not ok')
		}
		return {"status": "error", "error": response.json()}
	})
	.then(data => {
		console.log("Product inserted successfully:", data)
		return {"status": "success"}
	})
	.catch(error => {
		console.error("Error inserting product:", error)
		return {"status": "error", "error": error}
	})
}

const editProduct = async ()=>{
	const productForm2 = document.querySelector("#productForm2")

	const ID = productForm2.querySelector("#productID").value
	const name = productForm2.querySelector("#productName").value
	if (name === ""){
		return {"status": "error", "error":"name"}
	}
	const category = productForm2.querySelector("#productCategory").value
	const price = productForm2.querySelector("#productPrice").value
	const discount = productForm2.querySelector("#productDiscount").value
	const stock = productForm2.querySelector("#productStock").value
	const status = productForm2.querySelector("#productStatus").value
	const description = productForm2.querySelector("#productDescription").value
	const image = productForm2.querySelector("#productimageURLs").value
	
	return await fetch("/admin/editProduct", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
			"X-CSRF-Token": document.querySelector(".csrf-token").content
		},
		body: JSON.stringify({
			product_id: ID,
			name: name,
			category: category,
			price: price,
			discount: discount,
			stock: stock,
			status: status,
			description: description,
			image: image
		})
	})
	.then(response => {
		if (!response.ok) {
			throw new Error('Network response was not ok')
		}
		return {"status": "error", "error": response.json()}
	})
	.then(data => {
		console.log("Product inserted successfully:", data)
		return {"status": "success"}
	})
	.catch(error => {
		console.error("Error inserting product:", error)
		return {"status": "error", "error": error}
	})
}
document.addEventListener('DOMContentLoaded', () => {
	const insertProduct_button = document.querySelector(".insertProductButton")

	insertProduct_button.addEventListener("click",()=>{
		const r = insertProduct().then((r)=>{
			console.log("then - ", r)
			if (r.status === "success"){
				closeAllModals()
				if(confirm("Product inserted successfully. Do you want to reload the page?")) {
					window.location.reload()
				}
			}
		})
	})

	const editProduct_button = document.querySelector(".editProductButton")

	editProduct_button.addEventListener("click",()=>{
		const r = editProduct().then((r)=>{
			console.log("then - ", r)
			if (r.status === "success"){
				closeAllModals()
				if(confirm("Product edited successfully. Do you want to reload the page?")) {
					window.location.reload()
				}
			}
		})
	})

	const productSearch = document.getElementById('productSearch');
	const categoryFilter = document.getElementById('categoryFilter');
	const statusFilter = document.getElementById('statusFilter');
	const sortFilter = document.getElementById('sortFilter');

	function filterAndSortTable() {
		const searchTerm = productSearch.value.toLowerCase();
		const categoryValue = categoryFilter.value.toLowerCase();
		const statusValue = statusFilter.value.toLowerCase();
		const sortValue = sortFilter.value;
		
		const tableRows = document.querySelectorAll('.products-table tbody tr');
		
		tableRows.forEach(row => {
			const name = row.querySelector('.product-name').textContent.toLowerCase();
			const category = row.cells[3].textContent.toLowerCase();
			const status = row.cells[2].textContent.toLowerCase().trim();

			const matchesSearch = name.includes(searchTerm);
			const matchesCategory = categoryValue === '' || category === categoryValue;
			const matchesStatus = statusValue === '' || status === statusValue;
			console.log(status,statusValue)

			if (matchesSearch && matchesCategory && matchesStatus) {
				row.style.display = '';
			} else {
				row.style.display = 'none';
			}
		});

		const tbody = document.querySelector('.products-table tbody');
		const rows = Array.from(tbody.querySelectorAll('tr'));
		
		rows.sort((a, b) => {
			switch(sortValue) {
				case 'newest':
					return new Date(b.cells[9].textContent) - new Date(a.cells[9].textContent);
				case 'oldest':
					return new Date(a.cells[9].textContent) - new Date(b.cells[9].textContent);
				case 'price-asc':
					return parseFloat(a.cells[5].textContent) - parseFloat(b.cells[5].textContent);
				case 'price-desc':
					return parseFloat(b.cells[5].textContent) - parseFloat(a.cells[5].textContent);
				case 'name-asc':
					return a.querySelector('.product-name').textContent.localeCompare(b.querySelector('.product-name').textContent);
				case 'name-desc':
					return b.querySelector('.product-name').textContent.localeCompare(a.querySelector('.product-name').textContent);
				default:
					return 0;
			}
		});

		rows.forEach(row => tbody.appendChild(row));
	}

	productSearch.addEventListener('input', filterAndSortTable);
	categoryFilter.addEventListener('change', filterAndSortTable);
	statusFilter.addEventListener('change', filterAndSortTable);
	sortFilter.addEventListener('change', filterAndSortTable);

	filterAndSortTable();
})