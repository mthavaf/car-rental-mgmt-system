function displaysign() {
	
  var x=document.getElementById('sign');
   x.style.display = "block";
   document.getElementById('noAccount').style.display = "none";
   document.getElementById('heading').innerHTML = "Customer Registration";
   document.getElementById('loginForm').style.display = "none";
}