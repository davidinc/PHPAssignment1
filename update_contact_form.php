<?php
    require_once("database.php");
    $contact_id = filter_input(INPUT_GET, 'contactID', FILTER_VALIDATE_INT);
    
    $stmt = $db->prepare("SELECT * FROM contacts WHERE contactID = :id");
    $stmt->execute([':id' => $contact_id]);
    $contact = $stmt->fetch();
    
    $types = $db->query("SELECT * FROM types")->fetchAll();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Update Contact</title>
        <link rel="stylesheet" type="text/css" href="css/contact.css" />
    </head>
    <body>
        <?php include("header.php"); ?>
        <main>
            <h2>Update Contact</h2>
            <form action="update_contact.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="contactID" value="<?php echo $contact['contactID']; ?>">
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($contact['imagePath']); ?>">
                <div id="data">
                    <label>First Name:</label><input type="text" name="first_name" value="<?php echo htmlspecialchars($contact['firstName']); ?>" required /><br />
                    <label>Last Name:</label><input type="text" name="last_name" value="<?php echo htmlspecialchars($contact['lastName']); ?>" required /><br />
                    <label>Email Address:</label><input type="email" name="email_address" value="<?php echo htmlspecialchars($contact['emailAddress']); ?>" required /><br />
                    <label>Phone Number:</label><input type="text" name="phone_number" value="<?php echo htmlspecialchars($contact['phoneNumber']); ?>" /><br />
                    <label>Birth Date:</label><input type="date" name="birth_date" value="<?php echo htmlspecialchars($contact['dob']); ?>" /><br />
                    <label>Contact Type:</label>
                    <select name="type_id">
                        <?php foreach($types as $type): ?>
                            <option value="<?php echo $type['typeID']; ?>" <?php if($contact['typeID'] == $type['typeID']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($type['contactType']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select><br />
                    <label>Upload New Image:</label><input type="file" name="file1" accept="image/*" /><br />
                    <label>OR New Image URL:</label><input type="text" name="image_url" /><br />
                </div>
                <div id="buttons">
                    <label>&nbsp;</label><input type="submit" value="Update Contact" /><br />
                </div>
            </form>
            <p><a href="index.php">Cancel and View Contact List</a></p>
        </main>
        <?php include("footer.php"); ?>
    </body>
</html>