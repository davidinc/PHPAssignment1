<?php
    require_once("database.php");
    require_once("image_util.php");

    $contactID = filter_input(INPUT_POST, 'contactID', FILTER_VALIDATE_INT);
    $firstName = filter_input(INPUT_POST, 'firstName');
    $lastName = filter_input(INPUT_POST, 'lastName');
    $emailAddress = filter_input(INPUT_POST, 'emailAddress');
    $phone = filter_input(INPUT_POST, 'phone');
    $status = filter_input(INPUT_POST, 'status');
    $current_image = filter_input(INPUT_POST, 'current_image');
    $image_url = filter_input(INPUT_POST, 'image_url', FILTER_SANITIZE_URL);
    $image = $_FILES['file1'] ?? null;

    $base_dir = 'images/';
    $imageName = $current_image;

    if ($image && $image['error'] == UPLOAD_ERR_OK) {
        $original = basename($image['name']);
        move_uploaded_file($image['tmp_name'], $base_dir . $original);
        process_image($base_dir, $original);
        $dot_pos = strpos($original, '.');
        $imageName = substr($original, 0, $dot_pos) . '_100' . substr($original, $dot_pos);
    } elseif (!empty($image_url)) {
        $imageName = $image_url;
    }

    $query = 'UPDATE contacts SET firstName = :f, lastName = :l, emailAddress = :e, phone = :p, status = :s, imageName = :i WHERE contactID = :id';
    $stmt = $db->prepare($query);
    $stmt->execute([':f' => $firstName, ':l' => $lastName, ':e' => $emailAddress, ':p' => $phone, ':s' => $status, ':i' => $imageName, ':id' => $contactID]);

    header("Location: index.php");
    die();
?>