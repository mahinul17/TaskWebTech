<?php
include "config.php";

$success = $error = "";

if (isset($_GET["id"])) {
    $id     = $_GET["id"];
    $result = $conn->query("SELECT * FROM students WHERE id='$id'");
    $row    = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id         = $_POST["id"];
    $name       = $_POST["name"];
    $email      = $_POST["email"];
    $department = $_POST["department"];

    if (empty($name) || empty($email) || empty($department)) {
        $error = "Please fill all the fields.";
    } else {
        $sql = "UPDATE students
                SET name='$name', email='$email', department='$department'
                WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            $success = "Student record updated successfully.";

            $result = $conn->query("SELECT * FROM students WHERE id='$id'");
            $row    = $result->fetch_assoc();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
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
            background: #f0ad4e; color: #fff; padding: 9px 20px;
            border: none; border-radius: 4px; cursor: pointer;
        }
        a { display: inline-block; margin-top: 10px; color: #4a90e2; }
        .msg-success { color: green; } .msg-error { color: red; }
    </style>
</head>
<body>

<h2>Edit Student Record</h2>

<p class="msg-success"><?php echo $success; ?></p>
<p class="msg-error"><?php echo $error; ?></p>

<form method="post" action="">

    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <label>Student Name</label>
    <input type="text" name="name" value="<?php echo $row['name']; ?>">

    <label>Email</label>
    <input type="email" name="email" value="<?php echo $row['email']; ?>">

    <label>Registration Number (cannot be changed)</label>
    <input type="text" value="<?php echo $row['registration_no']; ?>" disabled>

    <label>Department</label>
    <input type="text" name="department" value="<?php echo $row['department']; ?>">

    <input type="submit" value="Update Student">

</form>

<a href="index.php">&larr; Back to Student List</a>

</body>
</html>
