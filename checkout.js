var nameNode = document.getElementById('name');
var emailNode = document.getElementById('email');

nameNode.addEventListener('change', nameValidate, false);
emailNode.addEventListener('change', emailValidate, false);

function nameValidate(event){
    var name = event.currentTarget;
    var nameregexp = /^[a-z A-Z]{2,100}$/;
    var search = name.value.search(nameregexp);

    if (search != 0) {
        alert("The Name you entered is invalid.\nPlease input alphabetical values only.");
        name.focus();
        name.select();
        return false;
    }
    return true;
}

function emailValidate(event){
    var email = event.currentTarget;
    var emailregexp = /^[\w.-]+@([\w]+\.){1,3}[\w]{2,3}$/;
    var search = email.value.search(emailregexp);

    if (search != 0) {
        alert("Wrong email format.\nPlease enter email in the format of:\nvigneshr002@e.ntu.edu.sg");
        email.focus();
        email.select();
        return false;
    }
    return true;
}

function priceForQuantity(inputElement) {
    const row_Element = inputElement.closest('tr');
    const unit_price = parseFloat(row_Element.querySelector('[name="unit_price"]').textContent.replace('$', ''));
    const quantityElement = row_Element.querySelector('[name="quantity*"');
    const quantity = parseInt(quantityElement.value);
    const priceElement = row_Element.querySelector('[name="price"]');
    const current_price = parseFloat(priceElement.textContent.replace('$', ''));

    const totalElement = document.querySelector('[name="total_price"]');
    const current_total = parseFloat(totalElement.textContent.replace('$', ''));

    if (quantity > 0) {
        new_price = unit_price * quantity;
    } else {
        quantityElement.value = 1;
        new_price = unit_price;
    }
    
    priceElement.textContent = "$" + (new_price).toFixed(2);
    totalElement.textContent = "$" + (current_total - current_price + new_price).toFixed(2);
}