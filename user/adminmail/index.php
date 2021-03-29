<!DOCTYPE html>
<html lang= "en">
<head>
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  font-color: black;
}
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
label {
    font-weight: bold;
}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border-radius: 4px;
  
}

input[type=submit], [type=reset]  {
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
  opacity:15;
}

input[type=reset]:hover {
  opacity:15;
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




    <meta charset="UTF-8">
    <title>Contact Us</title>
</head>
<body>
<ul>
  <li><a href="../../#home">Home</a></li>
  <li><a href="../../user/aboutus/">About Us</a></li>
  <li style="float:right"><a class="active" href="../../user/adminmail/">Contact Us</a></li>
  <li><a href="../../reg">Register<br></a><li>
  <li><a href="../../userlogin">Login<br></a><li>
</ul>
<h1>How Can We Help?</h1>
<p>Please fill in this form to contact the team, we aim to respond to your query within 48hrs.</p>
<form action="mail.php" method="POST">
<p>Name <br/> <input type="text" name="name"></p>
<p>Email <br/> <input type="text" name="email"></p>
<p>Message <br/> <textarea name="message" rows="6" cols="25"></textarea><br /></p>
<input type="submit" value="Send">
<input type="reset" value="Clear">

</form>
 <footer>Created by greforum &copy; Copyright 2020</footer>
 </body>
 </html>
