<?php
    require_once("database.php");
    require_once("image_util.php");

    $firstName = filter_input(INPUT_POST, 'firstName');
    $lastName = filter_input(INPUT_POST, 'lastName');
    $emailAddress = filter_input(INPUT_POST, 'emailAddress');
    $phone = filter_input(INPUT_POST, 'phone');
    $status = filter_input(INPUT_POST, 'status');
    $image_url = filter_input(INPUT_POST, 'image_url', FILTER_SANITIZE_URL);
    $image = $_FILES['file1'] ?? null;

    $base_dir = 'images/';
    if (!is_dir($base_dir)) mkdir($base_dir, 0777, true);

    $stmt = $db->prepare("SELECT * FROM contacts WHERE emailAddress = :email");
    $stmt->execute([':email' => $emailAddress]);
    if ($stmt->fetch()) {
        $_SESSION["add_error"] = "Duplicate Email Address.";
        header("Location: add_error.php");
        die();
    }

    $imageName = '';
    if ($image && $image['error'] == UPLOAD_ERR_OK) {
        $original = basename($image['name']);
        move_uploaded_file($image['tmp_name'], $base_dir . $original);
        
        // Skip the strict resize processing
        // process_image($base_dir, $original); 
        
        $imageName = $original; // Just save the exact file they uploaded
        $_SESSION["imageURL"] = $base_dir . $imageName;
    }

    $query = 'INSERT INTO contacts (firstName, lastName, emailAddress, phone, status, imageName)
              VALUES (:firstName, :lastName, :emailAddress, :phone, :status, :imageName)';
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':firstName' => $firstName, ':lastName' => $lastName, 
        ':emailAddress' => $emailAddress, ':phone' => $phone, 
        ':status' => $status, ':imageName' => $imageName
    ]);

    $_SESSION["fullName"] = "$firstName $lastName";
    header("Location: add_contact_confirmation.php");
    die();
?>