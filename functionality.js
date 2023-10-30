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
