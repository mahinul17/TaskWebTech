<?php

$errors = [];
$success = false;

$full_name        = '';
$email            = '';
$username         = '';
$age              = '';
$gender           = '';
$course           = '';

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
  <title>Student Registration</title>
</head>
<body>

<h2>Student Registration Form</h2>

<?php if ($success): ?>

  <h3>Registration Successful!</h3>
  <p><strong>Full Name:</strong> <?= htmlspecialchars($full_name) ?></p>
  <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
  <p><strong>Username:</strong> <?= htmlspecialchars($username) ?></p>
  <p><strong>Age:</strong> <?= htmlspecialchars($age) ?></p>
  <p><strong>Gender:</strong> <?= htmlspecialchars($gender) ?></p>
  <p><strong>Course:</strong> <?= htmlspecialchars($course) ?></p>

<?php else: ?>

  <?php if (!empty($errors)): ?>
    <h3>Please fix the following errors:</h3>
    <ul>
      <?php foreach ($errors as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form action="register.php" method="POST">

    <label>Full Name:</label><br>
    <input type="text" name="full_name" value="<?= htmlspecialchars($full_name) ?>"><br><br>

    <label>Email Address:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>"><br><br>

    <label>Username:</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <label>Confirm Password:</label><br>
    <input type="password" name="confirm_password"><br><br>

    <label>Age:</label><br>
    <input type="number" name="age" value="<?= htmlspecialchars($age) ?>"><br><br>

    <label>Gender:</label><br>
    <input type="radio" name="gender" value="Male" <?= ($gender === 'Male') ? 'checked' : '' ?>> Male
    <input type="radio" name="gender" value="Female" <?= ($gender === 'Female') ? 'checked' : '' ?>> Female<br><br>

    <label>Course Selection:</label><br>
    <select name="course">
      <option value="">-- Select Course --</option>
      <option value="Computer Science"       <?= ($course === 'Computer Science')       ? 'selected' : '' ?>>Computer Science</option>
      <option value="Electrical Engineering" <?= ($course === 'Electrical Engineering') ? 'selected' : '' ?>>Electrical Engineering</option>
      <option value="Business Administration"<?= ($course === 'Business Administration')? 'selected' : '' ?>>Business Administration</option>
      <option value="Mechanical Engineering" <?= ($course === 'Mechanical Engineering') ? 'selected' : '' ?>>Mechanical Engineering</option>
      <option value="Civil Engineering"      <?= ($course === 'Civil Engineering')      ? 'selected' : '' ?>>Civil Engineering</option>
      <option value="Medicine"               <?= ($course === 'Medicine')               ? 'selected' : '' ?>>Medicine</option>
      <option value="Law"                    <?= ($course === 'Law')                    ? 'selected' : '' ?>>Law</option>
    </select><br><br>

    <input type="checkbox" name="terms" value="1"> I agree to the Terms &amp; Conditions<br><br>

    <input type="submit" name="register" value="Register">

  </form>

<?php endif; ?>

</body>
</html>