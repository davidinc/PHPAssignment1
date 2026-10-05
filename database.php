<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $dsn = 'mysql:host=localhost;dbname=contact_manager_2026_am';
    $username = 'root';
    
    // On Mac, MAMP usually requires the password to be 'root' instead of blank.
    // If you are using XAMPP, leave it as ''.
    $password = ''; 

    try {
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        // This will force the actual error to print on your screen instantly
        die("<h3 style='color:red;'>REAL ERROR: " . $e->getMessage() . "</h3>");
    }
?>