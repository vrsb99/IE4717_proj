// This script checks whether the input to the form is valid
var nameNode = document.getElementById('name');
var emailNode = document.getElementById('email');
var form = document.getElementById('signUpForm');

nameNode.addEventListener('change', nameValidate, false);
emailNode.addEventListener('change', emailValidate, false);
form.addEventListener('submit', validateForm);

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

function validateForm(event) {
    if (!nameValidate({currentTarget: nameNode}) || !emailValidate({currentTarget: emailNode}) || !dateValidate({currentTarget: start_date})) {
        event.preventDefault();
    }
}