int = 0;

// Changing Past Orders to Login if not yet login
function changelink(){
    var link = document.getElementById('changelink');
    link.getAttribute("href");
    link.setAttribute("href","login.html");
    link.textContent = "Login";
}

function adminlogin (){
    var check = prompt("Please enter the admin password");
    document.getElementById("hidden").setAttribute("value",check);
}

function remove(){
    document.getElementById("logoutbutton").removeAttribute("hidden");  
}

function userlogout() {
    var check = confirm("Log out now?");
    
    if (check) {
        document.getElementById("newhidden").setAttribute("value",check);
    }
}

function exit() {
    var check = confirm("Are you sure you want to quit?");
    
    if (check) {
       location.href = "index.php";
    }
}

function validateSubscribeEmail() {
    
    var email = document.getElementById("subscribeemail");
    var form = document.getElementById('subscribeform');


    form.addEventListener('submit', validateForm);


    var emailregexp = /^[\w.-]+@([\w]+\.){1,3}[\w]{2,3}$/;
    var search = email.value.search(emailregexp);
    
    if (search != 0) {
        alert("Wrong email format.\nPlease enter email in the format of:\nvigneshr002@e.ntu.edu.sg");
        email.focus();
        email.select();
        int = 1;
    }
    else int =0;
    
    function validateForm(event) {
        if (validate(int)) {
        event.preventDefault();
    }
}

    function validate(int) {
        return true ? int == 1 : false
    }
}

function confirmDeleteCategory(form) {
  if (confirm("Are you sure you want to delete this category?\nAll items within this category will also be deleted\nThis action cannot be undone.")) {
    return true;
  } else {
    return false;
  }
}

function confirmDeleteItem(form) {
  if (confirm("Are you sure you want to delete this item?\nThis action cannot be undone.")) {
    return true;
  } else {
    return false;
  }
}
