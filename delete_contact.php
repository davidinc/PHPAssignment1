<?php
    require_once("database.php");
    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);

    $stmt = $db->prepare("SELECT imageName FROM contacts WHERE contactID = :id");
    $stmt->execute([':id' => $contact_id]);
    $contact = $stmt->fetch();

    if ($contact && !empty($contact['imageName'])) {
        $img = $contact['imageName'];
        if (strpos($img, 'placeholder') === false && strpos($img, 'http') !== 0) {
            $file_path = 'images/' . $img;
            if (file_exists($file_path)) unlink($file_path);
        }
    }

    $db->prepare("DELETE FROM contacts WHERE contactID = :id")->execute([':id' => $contact_id]);
    header("Location: index.php");
    die();
?>