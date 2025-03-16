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
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.classList.remove('active');
    });
    document.body.style.overflow = '';
}
const insertProduct = async ()=>{
	const productForm = document.querySelector("#productForm")

	const name = productForm.querySelector("#productName").value;
	if (name === ""){
		return {"status": "error", "error":"name"}
	}
	const category = productForm.querySelector("#productCategory").value;
	const price = productForm.querySelector("#productPrice").value;
	const discount = productForm.querySelector("#productDiscount").value;
	const stock = productForm.querySelector("#productStock").value;
	const status = productForm.querySelector("#productStatus").value;
	const description = productForm.querySelector("#productDescription").value;
	const image = productForm.querySelector("#productimageURLs").value;
	
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
			throw new Error('Network response was not ok');
		}
		return {"status": "error", "error": response.json()}
	})
	.then(data => {
		console.log("Product inserted successfully:", data);
		return {"status": "success"}
	})
	.catch(error => {
		console.error("Error inserting product:", error);
		return {"status": "error", "error": error}
	});
}
document.addEventListener('DOMContentLoaded', () => {
	const insertProduct_button = document.querySelector(".insertProductButton")

	insertProduct_button.addEventListener("click",()=>{
		const r = insertProduct().then((r)=>{
			console.log("then - ", r)
			if (r.status === "success"){
				closeAllModals()
				if(confirm("Product inserted successfully. Do you want to reload the page?")) {
					window.location.reload();
				}
			}
		})
	})
})