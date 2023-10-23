function priceForQuantity(inputElement) {
    const row_Element = inputElement.closest('tr');
    const unit_price = parseFloat(row_Element.querySelector('[name="unit_price"]').textContent.replace('$', ''));
    const quantityElement = row_Element.querySelector('[name="quantity"]');
    const quantity = parseInt(quantityElement.value);
    const priceElement = row_Element.querySelector('[name="price"]');
    if (quantity > 0) {
        priceElement.textContent = "$" + (unit_price * quantity).toFixed(2);
    } else {
        quantityElement.value = 1;
        priceElement.textContent = "$" + unit_price.toFixed(2);
    }
}