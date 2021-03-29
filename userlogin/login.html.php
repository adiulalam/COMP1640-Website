<?php include_once '../admin/includes/helpers.inc.php'; ?> 
<!DOCTYPE html>
<html lang="en">
 <head>
   <meta charset="utf-8">
   <title>Log In</title>
 </head> 
 
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

 <body>
 <ul>
  <li><a href="../#home">Home</a></li>
  <li><a href="../user/aboutus/">About Us</a></li>
  <li style="float:right"><a href="../user/adminmail/">Contact Us</a></li>
  <li><a href="../reg">Register<br></a><li>
  <li><a class="active" href="/userlogin">Login<br></a><li>
</ul>
   <h1>Log In</h1>
   <p>Please log in to view the page that you requested.</p> 
   <?php if (isset($loginError)): ?>
     <p><?php echo($loginError); ?></p>
   <?php endif; ?>
   <form action="" method="post">
     <div>
      <label for="Email">Email: <input type="Text" name="Email" id="Email"></label><br/>
     </div> 
     <br/><div>
      <label for="Password">Password: <input type="Password" name="Password" id="Password"></label><br/>
     </div>
     <div>
      <input type="hidden" name="action" value="login">
      <input type="submit" value="Log in">
      <p><a href="forgotPassword.php">Forgot Password</a></p>
     </div>
   </form>
   <!--<p><a href="../">Return to CMS home</a></p>-->
   <footer>Created by greforum &copy; Copyright 2020</footer>
 </body> 
</html>

