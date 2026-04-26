<?php
session_start();

$errors = [];
$success = false;

$full_name = '';
$email     = '';
$username  = '';
$age       = '';
$gender    = '';
$course    = '';

if (isset($_POST['register'])) {

    $full_name        = trim($_POST['full_name']);
    $email            = trim($_POST['email']);
    $username         = trim($_POST['username']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $age              = trim($_POST['age']);
    $gender           = isset($_POST['gender']) ? $_POST['gender'] : '';
    $course           = $_POST['course'];
    $terms            = isset($_POST['terms']) ? $_POST['terms'] : '';

    if ($full_name === '')        $errors['full_name']        = "Full Name is required.";
    if ($email === '')            $errors['email']            = "Email Address is required.";
    if ($username === '')         $errors['username']         = "Username is required.";
    if ($password === '')         $errors['password']         = "Password is required.";
    if ($confirm_password === '') $errors['confirm_password'] = "Confirm Password is required.";
    if ($age === '')              $errors['age']              = "Age is required.";
    if ($gender === '')           $errors['gender']           = "Gender must be selected.";
    if ($course === '')           $errors['course']           = "Course must be selected.";
    if ($terms !== '1')           $errors['terms']            = "You must accept the Terms & Conditions.";

    if ($full_name !== '' && !preg_match('/^[a-zA-Z ]+$/', $full_name)) {
        $errors['full_name'] = "Full Name must contain only letters and spaces.";
    }

    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email Address is not valid.";
    }

    if ($username !== '' && strlen($username) < 5) {
        $errors['username'] = "Username must be at least 5 characters long.";
    }

    if ($password !== '' && strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters long.";
    }

    if ($password !== '' && $confirm_password !== '' && $password !== $confirm_password) {
        $errors['confirm_password'] = "Password and Confirm Password do not match.";
    }

    if ($age !== '' && (int)$age < 18) {
        $errors['age'] = "Age must be 18 or above.";
    }

    if ($gender !== '' && !in_array($gender, ['Male', 'Female'])) {
        $errors['gender'] = "Gender selection is invalid.";
    }

    if (empty($errors)) {
        $success = true;

        $_SESSION['registered_user'] = array(
            'full_name' => $full_name,
            'email'     => $email,
            'username'  => $username,
            'age'       => $age,
            'gender'    => $gender,
            'course'    => $course
        );
        $_SESSION['registration_status'] = 'success';

        setcookie('last_registered_user', $username, time() + (7 * 24 * 60 * 60), '/');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration Result</title>
</head>
<body>

<h2>Student Registration Form</h2>

<?php if ($success): ?>

    <h3>Registration Successful!</h3>

    <?php
    if (isset($_SESSION['registered_user'])) {
        $user = $_SESSION['registered_user'];
    ?>
        <p><b>Full Name:</b> <?php echo htmlspecialchars($user['full_name']); ?></p>
        <p><b>Email:</b> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><b>Username:</b> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><b>Age:</b> <?php echo htmlspecialchars($user['age']); ?></p>
        <p><b>Gender:</b> <?php echo htmlspecialchars($user['gender']); ?></p>
        <p><b>Course:</b> <?php echo htmlspecialchars($user['course']); ?></p>
    <?php } ?>

    <?php

    if (isset($_COOKIE['last_registered_user'])) {
        echo '<p><i>Cookie saved: Welcome back next time, <b>' . htmlspecialchars($_COOKIE['last_registered_user']) . '</b>! Your username has been remembered for 7 days.</i></p>';
    }
    ?>

    <br>
    <a href="register.html">Go back to Register</a>

<?php else: ?>

    <?php
    if (isset($_COOKIE['last_registered_user'])) {
        echo '<p><i>Welcome back, <b>' . htmlspecialchars($_COOKIE['last_registered_user']) . '</b>! (Remembered by cookie)</i></p>';
    }
    ?>

    <?php if (isset($_POST['register']) && !empty($errors)): ?>
        <p style="color:red;">Please fix the errors below and try again.</p>
    <?php endif; ?>

    <form method="POST" action="register.php">

    <table border="0" cellpadding="5">

        <tr>
            <td>Full Name:</td>
            <td>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>">
                <?php if (isset($errors['full_name'])) echo '<span style="color:red;">' . $errors['full_name'] . '</span>'; ?>
            </td>
        </tr>

        <tr>
            <td>Email Address:</td>
            <td>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <?php if (isset($errors['email'])) echo '<span style="color:red;">' . $errors['email'] . '</span>'; ?>
            </td>
        </tr>

        <tr>
            <td>Username:</td>
            <td>
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
                <?php if (isset($errors['username'])) echo '<span style="color:red;">' . $errors['username'] . '</span>'; ?>
            </td>
        </tr>

        <tr>
            <td>Password:</td>
            <td>
                <input type="password" name="password">
                <?php if (isset($errors['password'])) echo '<span style="color:red;">' . $errors['password'] . '</span>'; ?>
            </td>
        </tr>

        <tr>
            <td>Confirm Password:</td>
            <td>
                <input type="password" name="confirm_password">
                <?php if (isset($errors['confirm_password'])) echo '<span style="color:red;">' . $errors['confirm_password'] . '</span>'; ?>
            </td>
        </tr>

        <tr>
            <td>Age:</td>
            <td>
                <input type="number" name="age" value="<?php echo htmlspecialchars($age); ?>">
                <?php if (isset($errors['age'])) echo '<span style="color:red;">' . $errors['age'] . '</span>'; ?>
            </td>
        </tr>

        <tr>
            <td>Gender:</td>
            <td>
                <input type="radio" name="gender" value="Male" <?php if($gender === 'Male') echo 'checked'; ?>> Male
                <input type="radio" name="gender" value="Female" <?php if($gender === 'Female') echo 'checked'; ?>> Female
                <?php if (isset($errors['gender'])) echo '<span style="color:red;">' . $errors['gender'] . '</span>'; ?>
            </td>
        </tr>

        <tr>
            <td>Course Selection:</td>
            <td>
                <select name="course">
                    <option value="">-- Select Course --</option>
                    <option value="Computer Science"        <?php if($course === 'Computer Science')        echo 'selected'; ?>>Computer Science</option>
                    <option value="Electrical Engineering"  <?php if($course === 'Electrical Engineering')  echo 'selected'; ?>>Electrical Engineering</option>
                    <option value="Business Administration" <?php if($course === 'Business Administration') echo 'selected'; ?>>Business Administration</option>
                    <option value="Mechanical Engineering"  <?php if($course === 'Mechanical Engineering')  echo 'selected'; ?>>Mechanical Engineering</option>
                    <option value="Civil Engineering"       <?php if($course === 'Civil Engineering')       echo 'selected'; ?>>Civil Engineering</option>
                    <option value="Medicine"                <?php if($course === 'Medicine')                echo 'selected'; ?>>Medicine</option>
                    <option value="Law"                     <?php if($course === 'Law')                     echo 'selected'; ?>>Law</option>
                </select>
                <?php if (isset($errors['course'])) echo '<span style="color:red;">' . $errors['course'] . '</span>'; ?>
            </td>
        </tr>

        <tr>
            <td>Terms &amp; Conditions:</td>
            <td>
                <input type="checkbox" name="terms" value="1"> I agree to the Terms &amp; Conditions
                <?php if (isset($errors['terms'])) echo '<span style="color:red;">' . $errors['terms'] . '</span>'; ?>
            </td>
        </tr>

        <tr>
            <td></td>
            <td><input type="submit" name="register" value="Register"></td>
        </tr>

    </table>

    </form>

<?php endif; ?>

</body>
</html>
