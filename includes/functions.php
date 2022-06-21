<?php
// Start a new session
session_start();

// Location redirect
// It is a header("location: http://www.example.com") alternative to avoid the Header already sent error
function location($url)
{
  // Check if the header has already been sent
  if (!headers_sent()) {
    // Redirect to the new location with header()
    header('Location: ' . $url);
    // Exit the script
    exit;
  } else {
    // Redirect to the new location with a JavaScript
    echo '<script type="text/javascript">';
    echo 'window.location.href="' . $url . '";';
    echo '</script>';
    // Redirect to the new location with a meta tag
    echo '<noscript>';
    echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
    echo '</noscript>';
    // Exit the script
    exit;
  }
}


// Database connection function
function DBConnect()
{
  // Get the configuration array
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/config.dist.php';
  try {
    // Create a new PDO connection
    $db = new PDO('mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'], $config['db_user'], $config['db_pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
  }
}

// Password hashing function
function Password($password, $salt)
{
  // Hash the password
  return hash('sha256', $password . $salt);
}

// Set session variables
function SetUserSession($user)
{
  // Set the session variables
  $_SESSION['user'] = array(
    "id" => $user['id'],
    "firstname" => $user['firstname'],
    "lastname" => $user['lastname'],
    "email" => $user['email'],
    "gravatar" => "http://www.gravatar.com/avatar/" . md5(strtolower(trim($user['email']))) . "?s=256", // Get the user's gravatar image
  );
}

// Salt generator
function Salt()
{
  // Allowed characters
  $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789()?;.:/!@#$%^&*[]{}<>,~`+-=';
  // Generate a random string
  $salt = '';
  for ($i = 0; $i < 32; $i++) {
    $salt .= $chars[rand(0, strlen($chars) - 1)];
  }
  // Encrypt the salt
  $salt = Password($salt, $salt);
  // Return the salt
  return $salt;
}

// Sign in function
function Signin($email, $password)
{
  // Get the database connection
  $db = DBConnect();
  // Get the user
  $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  // Check if the user exists
  if (!$user) return false;
  // Check if the password is correct
  if ($user['password'] != Password($password, $user['salt'])) return false;
  // Set the session variables
  SetUserSession($user);
  // Return the user
  return true;
}

// Sign up function
function Signup($firstname, $lastname, $email, $password, $confirm_password)
{
  // Check if the passwords match
  if ($password != $confirm_password) return "PASSWORDS_DONT_MATCH";
  // Get the database connection
  $db = DBConnect();
  // Check if the user already exists
  $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($user) return "EMAIL_ALREADY_EXISTS";
  // Generate a salt
  $salt = Salt();
  // Hash the password
  $password = Password($password, $salt);
  // Insert the user into the database
  $stmt = $db->prepare('INSERT INTO users (firstname, lastname, email, password, salt) VALUES (:firstname, :lastname, :email, :password, :salt)');
  $stmt->bindParam(':firstname', $firstname);
  $stmt->bindParam(':lastname', $lastname);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $password);
  $stmt->bindParam(':salt', $salt);
  $stmt->execute();
  // Set the user's session variables
  SetUserSession(array(
    "id" => $db->lastInsertId(),
    "firstname" => $firstname,
    "lastname" => $lastname,
    "email" => $email,
  ));
  // Return the user's ID
  return $db->lastInsertId();
}

// Log out function
function Logout($url = "/")
{
  // Unset the session variables
  unset($_SESSION['user']);
  session_destroy();
  // Redirect
  location($url);
}

// Check if the user is logged in
function IsLoggedIn()
{
  // Check if the user is logged in
  if (isset($_SESSION['user'])) return true;
  // Return false
  return false;
}

// Check if the user is an admin
function IsAdmin()
{
  // Get the database connection
  $db = DBConnect();
  // Check if the user is an admin
  $stmt = $db->prepare('SELECT * FROM admins WHERE user_id = :id');
  $stmt->bindParam(':id', $_SESSION['user']['id']);
  $stmt->execute();
  $admin = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($admin) return true;
  // Return false
  return false;
}
