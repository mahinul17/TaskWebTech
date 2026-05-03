<?php
include "config.php";

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name            = $_POST["name"];
    $email           = $_POST["email"];
    $registration_no = $_POST["registration_no"];
    $department      = $_POST["department"];

    if (empty($name) || empty($email) || empty($registration_no) || empty($department)) {
        $error = "Please fill all the fields.";
    } else {
        $sql = "INSERT INTO students (name, email, registration_no, department)
                VALUES ('$name', '$email', '$registration_no', '$department')";

        if ($conn->query($sql) === TRUE) {
            $success = "Student record added successfully.";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f4f4; }
        h2   { color: #333; }
        form { background: #fff; padding: 24px; width: 380px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        label { display: block; margin-bottom: 4px; font-weight: bold; }
        input[type="text"], input[type="email"] {
            width: 100%; padding: 8px; margin-bottom: 14px;
            border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;
        }
        input[type="submit"] {
            background: #5cb85c; color: #fff; padding: 9px 20px;
            border: none; border-radius: 4px; cursor: pointer;
        }
        a { display: inline-block; margin-top: 10px; color: #4a90e2; }
        .msg-success { color: green; } .msg-error { color: red; }
    </style>
</head>
<body>

<h2>Add New Student</h2>

<p class="msg-success"><?php echo $success; ?></p>
<p class="msg-error"><?php echo $error; ?></p>

<form method="post" action="">

    <label>Student Name</label>
    <input type="text" name="name" placeholder="Enter student name">

    <label>Email</label>
    <input type="email" name="email" placeholder="Enter email">

    <label>Registration Number</label>
    <input type="text" name="registration_no" placeholder="e.g. 2021-CSE-001">

    <label>Department</label>
    <input type="text" name="department" placeholder="e.g. CSE">

    <input type="submit" value="Add Student">

</form>

<a href="index.php">&larr; Back to Student List</a>

</body>
</html>
