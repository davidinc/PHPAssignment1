<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact Manager - Database Error</title>
        <link rel="stylesheet" href="css/contact.css">
    </head>
    <body>
        <header>
            <h1>Contact Manager System</h1>
        </header>

        <main>
            <div class="error-card">
                <h2>Database Error</h2>
                <p>There was an error connecting to the database.</p>
                <p>The database must be installed.</p>
                <p>MySQL must be running.</p>
                <p class="error-detail">
                    <strong>Error Message:</strong> 
                    <?php 
                        if (isset($_SESSION["database_error"])) {
                            echo htmlspecialchars($_SESSION["database_error"]);
                            unset($_SESSION["database_error"]);
                        } else {
                            echo "Unknown database connection error.";
                        }
                    ?>
                </p>
                <p><a href="index.php" class="btn">View Contact List</a></p>
            </div>
        </main>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Contact Manager System</p>
        </footer>
    </body>
</html>