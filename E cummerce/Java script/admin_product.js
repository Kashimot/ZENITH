// Function to handle form submission
document.getElementById('add-product-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Get form data
    const formData = new FormData(this);

    // Create a new product card
    const newProductCard = document.createElement('div');
    newProductCard.classList.add('product-card');

    // Set product card content
    newProductCard.innerHTML = `
        <img src="${formData.get('product_image_url')}" alt="${formData.get('product_name')}">
        <h3>${formData.get('product_name')}</h3>
        <p>${formData.get('product_description')}</p>
        <button class="view-details-btn">View Details</button>
    `;

    // Add the new product card to the product gallery
    document.querySelector('.product-gallery').appendChild(newProductCard);

    // Clear form fields after submission
    this.reset();
});
