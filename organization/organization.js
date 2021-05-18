function displaySignUpForm() {
  var x=document.getElementById('signUpForm');
   x.style.display = "block";
   document.getElementById('noAccount').style.display = "none";
   document.getElementById('heading').innerHTML = "organization Registration";
   document.getElementById('loginForm').style.display = "none";
}
