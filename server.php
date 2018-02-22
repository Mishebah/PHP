<?php
session_start();

// initializing variables
$AdmNo = "";
$email    = "";
$errors = array(); 
// connect to the database
require 'connect.php';

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $AdmNo = mysqli_real_escape_string($db, $_POST['AdmNo']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($AdmNo)) { array_push($errors, "AdmNo is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same AdmNo and/or email
  $user_check_query = "SELECT * FROM students WHERE AdmNo ='$AdmNo' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { 
  // if user exists
    if ($user['AdmNo'] === $AdmNo) {
      array_push($errors, " AdmNo already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO students (AdmNo, email, password) 
  			  VALUES('$AdmNo', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['AdmNo'] = $AdmNo;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}
// ... 

// LOGIN USER
if (isset($_POST['login_user'])) {
  $AdmNo = mysqli_real_escape_string($db, $_POST['AdmNo']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($AdmNo)) {
  	array_push($errors, "AdmNo is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM students WHERE AdmNo='$AdmNo' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['AdmNo'] = $AdmNo;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong AdmNo/password combination");
  	}
  }
}

?>