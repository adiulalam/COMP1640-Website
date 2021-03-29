<?php include_once '../admin/includes/helpers.inc.php'; ?> 
<!DOCTYPE html>
<html lang="en">
 <head>

 <style>
/* styling for navigation bar */
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}
li {
  float: left;
  border-right:2px solid #fafcff;
}
li:last-child {
  border-right: none;
}
li a {
  display: block;
  color: white;
  text-align: center;
  padding: 23px 36px;
  text-decoration: none;
}
li a:hover:not(.active) {
  background-color: #5983ff;
}
.active {
  background-color: #a1c0ff;
}

#home {
  left: 0px;
  width: 46px;
  background: url('img_navsprites.gif') 0 0;
}

/* styling for form */
label {
    font-weight: bold;
}

body {
  font-family: Arial, Helvetica, sans-serif;
  font-color: black;
}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border-radius: 4px;
  
}

input[type=submit] {
 background-color: #5983ff;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
  font-size: 20px;
}
input[type=submit]:hover {
  opacity:5;
}
a {
  color: dodgerblue;
}
/* styling for footer */
footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: #e3ecff;
   color: #8d9ab8;
   text-align: center;
}
 </style>

   <meta charset="utf-8">
   <title>Register</title>

          <script>

function validate_form ( )
{
	valid = true;

        if (document.contact_form.Name.value == "")
        {
                alert ( "Please fill in the 'Name' box." );
                valid = false;
        }
    
    if (document.contact_form.Email.value == "")
        {
                alert ( "Please fill in the 'Email' box." );
                valid = false;
        }
 
    
    if (document.contact_form.Password.value == "" || document.contact_form.Password.value.length < 6)
        {
                alert ( "Please fill in the 'Password' box and make sure it over 6 characters." );
                valid = false;
        }

        return valid;
}

</script>
   <script src="https://www.google.com/recaptcha/api.js" async defer></script>
 </head> 
 <body>
<ul>
  <li><a href="../#home">Home</a></li>
  <li><a href="../user/aboutus/">About Us</a></li>
  <li style="float:right"><a href="../user/adminmail/">Contact Us</a></li>
  <li><a class="active" href="../reg">Register<br></a><li>
  <li><a href="../userlogin">Login<br></a><li>
</ul>
   <h1>Register</h1>
    <p>Please fill in this form to create an account.</p>
   <form name="contact_form" action="?addform" method="post" onsubmit="return validate_form ();">
    <div><br/>
        <label for="Name">Name: <input type="text" name="Name" placeholder="Enter your full name" pattern="^[a-zA-Z ]*$" title="Only letters and white space allowed" required autofocus></label>
     </div>
     <div><br/>
         <label for="Email">Email: <input type="text" name="Email" placeholder="Enter your Email Address"></label>
     </div> 
     <div><br/>
         <label for="Password">Password: <input type="password" name="Password" placeholder="Enter a secure password"></label>
     </div>
    <div><br/>
         <input type="checkbox" required name="checkbox" value="check" id="agree" /> <a href="terms.html"> I have read and agree to the Terms and Conditions and Privacy Policy
     </div> 
     <div>
    <br/>
      <div class="g-recaptcha" data-sitekey="6LeE-OEUAAAAANw3945K-hgOnyELcZOe_AwPghKW"></div>
    <br/>
      <input type="submit" name="submit" value="Submit">
     </div>
   </form>
     

   <!--<p><a href="../user/">Return to CMS home</a></p>-->
   <footer>Created by greforum &copy; Copyright 2020</footer>
 </body> 
</html>
