<?php
$fullname = $email = $phone = $gender = $field = '';
$error_message = [];
$file_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Registration form handling
    if (isset($_POST['register'])) {
        $fullname = htmlspecialchars(trim($_POST['fullname']));
        $email = htmlspecialchars(trim($_POST['email']));
        $phone = htmlspecialchars(trim($_POST['phone']));
        $gender = htmlspecialchars(trim($_POST['gender']));
        $field = htmlspecialchars(trim($_POST['field']));

        // Validation for registration
        if (!preg_match("/^[a-zA-Z\s]+$/", $fullname)) {
            $error_message[] = "Full name must contain only letters and spaces.";
        }
        if (!is_numeric($phone) || strlen($phone) < 10) {
            $error_message[] = "Phone number must be at least 10 digits long.";
        }
        if (!filter_var($email, filter: FILTER_VALIDATE_EMAIL)) {
            $error_message[] = "Invalid email format.";
        }
        if (strpos($fullname, $phone) !== false) {
            $error_message[] = "Full name should not contain the phone number.";
        }
        if (strpos($email, $fullname) !== false) {
            $error_message[] = "Email should not contain the full name.";
        }

        if (empty($error_message)) {
            // Display the submitted information
            echo "<h1>Registration Successful</h1>";
            echo "<p>Full Name: $fullname</p>";
            echo "<p>Email: $email</p>";
            echo "<p>Phone Number: $phone</p>";
            echo "<p>Gender: $gender</p>";
            echo "<p>Field of Study: $field</p>";
            exit;
        }
    }

    // File handling section
    if (isset($_POST['upload'])) {
        // Define allowed file types and maximum file size
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $max_file_size = 500000; // 500 KB
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = true;

        // Validate file existence, size, and type
        if (file_exists($target_file)) {
            $file_message = "Sorry, file already exists.";
            $uploadOk = false;
        } elseif ($_FILES["fileToUpload"]["size"] > $max_file_size) {
            $file_message = "Sorry, your file is too large.";
            $uploadOk = false;
        } elseif (!in_array($fileType, $allowed_types)) {
            $file_message = "Sorry, only " . implode(", ", $allowed_types) . " files are allowed.";
            $uploadOk = false;
        }

        // Attempt to upload if all validations pass
        if ($uploadOk && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $file_message = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        } else {
            $file_message = "Sorry, there was an error uploading your file.";
        }
    }

    // File operations (delete and rename)
    if (isset($_POST['delete']) && !empty($_POST['filename'])) {
        $filename = htmlspecialchars(trim($_POST['filename']));
        if (file_exists($filename)) {
            unlink($filename);
            $file_message = "File $filename has been deleted.";
        } else {
            $file_message = "File not found.";
        }
    }

    if (isset($_POST['rename']) && !empty($_POST['oldname']) && !empty($_POST['newname'])) {
        $oldname = htmlspecialchars(trim($_POST['oldname']));
        $newname = htmlspecialchars(trim($_POST['newname']));
        if (file_exists($oldname)) {
            rename($oldname, $newname);
            $file_message = "File $oldname has been renamed to $newname.";
        } else {
            $file_message = "File not found.";
        }
    }

    // Reading files
    if (isset($_POST['read']) && !empty($_POST['filename'])) {
        $filename = htmlspecialchars(trim($_POST['filename']));
        if (file_exists($filename)) {
            $file_content = file_get_contents($filename);
            $file_message = "Contents of $filename:<br><pre>" . htmlspecialchars($file_content) . "</pre>";
        } else {
            $file_message = "File not found.";
        }
    }

    // Writing to files
    if (isset($_POST['write']) && !empty($_POST['filename']) && !empty($_POST['content'])) {
        $filename = htmlspecialchars(trim($_POST['filename']));
        $content = htmlspecialchars(trim($_POST['content']));
        file_put_contents($filename, $content);
        $file_message = "Content written to $filename.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Student Registration Form</h1>
    <form id="registrationForm" method="POST" action="">
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>" required>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male" <?php if ($gender == 'male') echo 'selected'; ?>>Male</option>
            <option value="female" <?php if ($gender == 'female') echo 'selected'; ?>>Female</option>
            <option value="other" <?php if ($gender == 'other') echo 'selected'; ?>>Other</option>
        </select>

        <label for="field">Field of Study:</label>
        <select id="field" name="field" required>
            <option value="IT" <?php if ($field == 'IT') echo 'selected'; ?>>IT</option>
            <option value="CS" <?php if ($field == 'CS') echo 'selected'; ?>>Computer Science</option>
            <option value="IS" <?php if ($field == 'IS') echo 'selected'; ?>>Information Systems</option>
            <option value="SE" <?php if ($field == 'SE') echo 'selected'; ?>>Software Engineering</option>
        </select>
    </form>

    <h1>File Management</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="fileToUpload">Upload File:</label>
        <input type="file" name="fileToUpload" id="fileToUpload" required>
        <button type="submit" name="upload">Upload</button>
    </form>

    <form method="POST">
        <label for="filename">Delete File:</label>
        <input type="text" name="filename" id="filename" placeholder="Enter filename to delete" required>
        <button type="submit" name="delete">Delete</button>
    </form>

    <form method="POST">
        <label for="oldname">Rename File:</label>
        <input type="text" name="oldname" id="oldname" placeholder="Old filename" required>
        <input type="text" name="newname" id="newname" placeholder="New filename" required>
        <button type="submit" name="rename">Rename</button>
    </form>

    <form method="POST">
        <label for="filename">Read File:</label>
        <input type="text" name="filename" id="filename" placeholder="Enter filename to read" required>
        <button type="submit" name="read">Read</button>
    </form>

    <form method="POST">
        <label for="filename">Write to File:</label>
        <input type="text" name="filename" id="filename" placeholder="Filename" required>
        <textarea name="content" placeholder="Content to write" required></textarea>
        <button type="submit" name="write">Write</button>
    </form>

    <div style="color: green;">
        <?php echo $file_message; ?>
    </div>

    <div style="color: red;">
        <?php 
        if (!empty($error_message)) {
            foreach ($error_message as $error) {
                echo "<p>$error</p>";
            }
        }
        ?>
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" form="registrationForm" name="register">Submit Registration</button>
    </div>
</body>
</html>