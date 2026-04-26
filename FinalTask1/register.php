<?php

$errors = [];
$success = false;

if (isset($_POST['register'])) {

    $full_name        = trim($_POST['full_name']        ?? '');
    $email            = trim($_POST['email']            ?? '');
    $username         = trim($_POST['username']         ?? '');
    $password         =      $_POST['password']         ?? '';
    $confirm_password =      $_POST['confirm_password'] ?? '';
    $age              = trim($_POST['age']              ?? '');
    $gender           = trim($_POST['gender']           ?? '');
    $course           = trim($_POST['course']           ?? '');
    $terms            =      $_POST['terms']            ?? '';


    if ($full_name === '')        $errors[] = "Full Name is required.";
    if ($email === '')            $errors[] = "Email Address is required.";
    if ($username === '')         $errors[] = "Username is required.";
    if ($password === '')         $errors[] = "Password is required.";
    if ($confirm_password === '') $errors[] = "Confirm Password is required.";
    if ($age === '')              $errors[] = "Age is required.";
    if ($gender === '')           $errors[] = "Gender must be selected.";
    if ($course === '')           $errors[] = "Course must be selected.";
    if ($terms !== '1')           $errors[] = "You must accept the Terms & Conditions.";


    if ($full_name !== '' && !preg_match('/^[a-zA-Z ]+$/', $full_name)) {
        $errors[] = "Full Name must contain only letters and spaces.";
    }

    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email Address is not valid.";
    }

    if ($username !== '' && strlen($username) < 5) {
        $errors[] = "Username must be at least 5 characters long.";
    }

    if ($password !== '' && strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if ($password !== '' && $confirm_password !== '' && $password !== $confirm_password) {
        $errors[] = "Password and Confirm Password do not match.";
    }

    if ($age !== '' && (int)$age < 18) {
        $errors[] = "Age must be 18 or above.";
    }


    if ($gender !== '' && !in_array($gender, ['Male', 'Female'])) {
        $errors[] = "Gender selection is invalid.";
    }

    if (empty($errors)) {
        $success = true;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Result</title>
</head>
<body>

<?php if (!isset($_POST['register'])): ?>

  <p>No form submitted. <a href="register.html">Go back</a></p>

<?php elseif (!empty($errors)): ?>

  <h3>Registration Failed. Please fix the errors below:</h3>
  <ul>
    <?php foreach ($errors as $error): ?>
      <li><?= htmlspecialchars($error) ?></li>
    <?php endforeach; ?>
  </ul>
  <a href="register.html">Go back</a>

<?php else: ?>

  <h3>Registration Successful!</h3>
  <p><strong>Full Name:</strong> <?= htmlspecialchars($full_name) ?></p>
  <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
  <p><strong>Username:</strong> <?= htmlspecialchars($username) ?></p>
  <p><strong>Age:</strong> <?= htmlspecialchars($age) ?></p>
  <p><strong>Gender:</strong> <?= htmlspecialchars($gender) ?></p>
  <p><strong>Course:</strong> <?= htmlspecialchars($course) ?></p>
  <br>
  <a href="register.html">Register another student</a>

<?php endif; ?>

</body>
</html>
