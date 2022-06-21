<?php
// Include the functions file
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
// Trigger the function when form is submitted
if (isset($_POST['signin'])) {
  // Get the user's email and password
  $email = $_POST['email'];
  $password = $_POST['password'];
  // Run the Signin function
  $result = Signin($email, $password);
  if ($result == true) location("/dashboard/");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign in</title>

  <!-- Include the tailwind css file -->
  <link rel="stylesheet" href="/assets/css/output.css">
</head>

<body>

  <!-- Page Container -->
  <div class="min-h-screen flex items-center justify-center bg-gray-100 text-gray-900 relative">
    <!-- Log In Section -->
    <div class="px-5 py-6 lg:px-6 lg:py-8 w-full md:w-8/12 lg:w-6/12 xl:w-4/12 relative">
      <!-- Logo -->
      <div class="mb-6 text-center">
        <h3 class="text-3xl inline-flex items-center">
          <svg class="w-12 inline-block text-indigo-500 mr-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
            <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
            <path d="M320 104.5c171.4 0 303.2 72.2 303.2 151.5S491.3 407.5 320 407.5c-171.4 0-303.2-72.2-303.2-151.5S148.7 104.5 320 104.5m0-16.8C143.3 87.7 0 163 0 256s143.3 168.3 320 168.3S640 349 640 256 496.7 87.7 320 87.7zM218.2 242.5c-7.9 40.5-35.8 36.3-70.1 36.3l13.7-70.6c38 0 63.8-4.1 56.4 34.3zM97.4 350.3h36.7l8.7-44.8c41.1 0 66.6 3 90.2-19.1 26.1-24 32.9-66.7 14.3-88.1-9.7-11.2-25.3-16.7-46.5-16.7h-70.7L97.4 350.3zm185.7-213.6h36.5l-8.7 44.8c31.5 0 60.7-2.3 74.8 10.7 14.8 13.6 7.7 31-8.3 113.1h-37c15.4-79.4 18.3-86 12.7-92-5.4-5.8-17.7-4.6-47.4-4.6l-18.8 96.6h-36.5l32.7-168.6zM505 242.5c-8 41.1-36.7 36.3-70.1 36.3l13.7-70.6c38.2 0 63.8-4.1 56.4 34.3zM384.2 350.3H421l8.7-44.8c43.2 0 67.1 2.5 90.2-19.1 26.1-24 32.9-66.7 14.3-88.1-9.7-11.2-25.3-16.7-46.5-16.7H417l-32.8 168.7z" />
          </svg>
          PHP Boilerplate
        </h3>
        <p class="text-gray-600">
          Welcome, please log in to continue.
        </p>
      </div>
      <!-- END Logo -->

      <!-- Form -->
      <div class="rounded border p-6 lg:p-10 shadow-sm bg-white">
        <!-- Error Message -->
        <?php if (isset($result) && $result == false) { ?>
          <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-full" role="alert">
            <p>
              Email or password is incorrect.
            </p>
          </div>
        <?php } ?>

        <form method="POST">
          <label class="block text-gray-700">
            Email
            <input type="email" name="email" class="appearance-none border rounded px-4 py-3 mt-1 block w-full outline-none focus:border-blue-500" placeholder="Enter your email" required>
          </label>
          <label class="block text-gray-700 mt-4">
            Password
            <input type="password" name="password" class="appearance-none border rounded px-4 py-3 mt-1 block w-full outline-none focus:border-blue-500" placeholder="Enter your password" required>
          </label>
          <div class="mt-6">
            <button type="submit" class="px-4 py-3 bg-blue-500 text-white rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline block w-full">Sign In</button>
          </div>
        </form>
        <div class="mt-6 text-center text-sm">
          <a class="text-gray-600 hover:text-gray-700 underline block md:inline-block mb-2 md:mb-0" href="create.html">Create Account</a>
          <span class="text-gray-600 mx-1 hidden md:inline-block">·</span>
          <a class="text-gray-600 hover:text-gray-700 underline block md:inline-block" href="forgot.html">Forgot Password?</a>
        </div>
      </div>
      <!-- END Form -->

      <!-- Footer -->
      <div class="text-xs text-gray-600 text-center mt-6">
        <span class="font-semibold">Web Application</span> &copy; <script>
          document.write((new Date).getFullYear());
        </script> · <a class="text-gray-600 hover:text-gray-700 underline" href="javascript:void(0)">Terms &amp; Conditions</a>
      </div>
      <!-- END Footer -->
    </div>
    <!-- END Log In Section -->
  </div>
  <!-- END Page Container -->

</body>

</html>