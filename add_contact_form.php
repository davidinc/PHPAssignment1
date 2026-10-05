<?php require_once("database.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add Contact</title>
        <link rel="stylesheet" type="text/css" href="css/contact.css" />
    </head>
    <body>
        <?php include("header.php"); ?>
        <main>
            <h2>Add Contact</h2>
            <form action="add_contact.php" method="post" enctype="multipart/form-data">
                <div id="data">
                    <label>First Name:</label><input type="text" name="firstName" required /><br />
                    <label>Last Name:</label><input type="text" name="lastName" required /><br />
                    <label>Email Address:</label><input type="email" name="emailAddress" required /><br />
                    <label>Phone Number:</label><input type="text" name="phone" /><br />
                    <label>Status:</label>
                    <select name="status">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select><br />
                    <label>Upload Image:</label><input type="file" name="file1" accept="image/*" /><br />
                    <label>OR Image URL:</label><input type="text" name="image_url" placeholder="https://..." /><br />
                </div>
                <div id="buttons">
                    <label>&nbsp;</label><input type="submit" value="Save Contact" /><br />
                </div>
            </form>
            <p><a href="index.php">View Contact List</a></p>
        </main>
        <?php include("footer.php"); ?>
    </body>
</html>