<?php
    require('database.php');

    // Query all contacts from the database
    $queryContacts = 'SELECT * FROM contacts ORDER BY lastName, firstName';
    $statement = $db->prepare($queryContacts);
    $statement->execute();
    $contacts = $statement->fetchAll();
    $statement->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact Manager - Home</title>
        <link rel="stylesheet" href="css/contact.css">
    </head>
    <body>
        <header>
            <h1>Contact Manager System</h1>
        </header>

        <main>
            <div class="section-header">
                <h2>Contact List</h2>
                <span class="badge"><?php echo count($contacts); ?> Contacts</span>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Phone</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($contacts) > 0): ?>
                            <?php foreach ($contacts as $contact) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($contact['contactID']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['firstName']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['lastName']); ?></td>
                                    <td>
                                        <a href="mailto:<?php echo htmlspecialchars($contact['emailAddress']); ?>">
                                            <?php echo htmlspecialchars($contact['emailAddress']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($contact['phone']); ?></td>
                                    <td>
                                        <span class="status-pill status-<?php echo strtolower(htmlspecialchars($contact['status'])); ?>">
                                            <?php echo htmlspecialchars($contact['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="empty-row">No contacts found in the database.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Contact Manager System</p>
        </footer>
    </body>
</html>