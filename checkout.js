var nameNode = document.getElementById('name');
var emailNode = document.getElementById('email');
var form = document.getElementById('customerform');

function validation(int){
    if (parseInt(int) == 0) {
    nameNode.addEventListener('change', nameValidate, false);
    emailNode.addEventListener('change', emailValidate, false);
    form.addEventListener('submit', validateForm);
    }
    else {
    nameNode.removeEventListener('change', nameValidate, false);
    emailNode.removeEventListener('change', emailValidate, false);
    form.removeEventListener('submit', validateForm)
    };
}


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
    const quantityElement = inputElement;
    const quantity = parseInt(quantityElement.value);
    const priceElement = row_Element.querySelector('[name="price"]');
    const current_price = parseFloat(priceElement.textContent.replace('$', ''));

    const totalElement = document.querySelector('[name="total_price"]');
    const current_total = parseFloat(totalElement.textContent.replace('$', ''));
    console.log(current_total)
    if (quantity > 0) {
        new_price = unit_price * quantity;
    } else {
        quantityElement.value = 1;
        new_price = unit_price;
    }
    
    priceElement.textContent = "$" + (new_price).toFixed(2);
    totalElement.textContent = "$" + (current_total - current_price + new_price).toFixed(2);
}

function validateForm(event) {
    if (!nameValidate({currentTarget: nameNode}) || !emailValidate({currentTarget: emailNode}) || !dateValidate({currentTarget: start_date})) {
        event.preventDefault();
    }
}


// function removeevent() {  
//     nameNode.removeEventListener("change",nameValidate,false);
//     emailNode.removeEventListener("change",emailValidate,false);
//     formNode.removeEventListener("change",validateForm);
// }