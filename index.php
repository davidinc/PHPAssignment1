<?php
    require_once("database.php");

    $action = filter_input(INPUT_POST, 'action');
    if ($action === 'delete_all') {
        $db->exec('DELETE FROM contacts');
        header("Location: index.php");
        exit();
    }

    $limit = 5;
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
    $offset = ($page - 1) * $limit;

    $totalContacts = $db->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
    $totalPages = ceil($totalContacts / $limit);

    $statement = $db->prepare('SELECT * FROM contacts ORDER BY lastName, firstName LIMIT :limit OFFSET :offset');
    $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
    $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();
    $contacts = $statement->fetchAll();
    $statement->closeCursor();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Contact Manager - Home</title>
        <link rel="stylesheet" type="text/css" href="css/contact.css">
    </head>
    <body>
        <?php include("header.php"); ?>
        <main>
            <h2>Contact List (<?php echo $totalContacts; ?> Total)</h2>
            <p><a href="add_contact_form.php">Add New Contact</a></p><br>

            <table>
                <thead>
                    <tr>
                        <th>Photo</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($contacts) > 0): foreach ($contacts as $contact) : ?>
                        <tr>
                            <td>
                                <?php 
                                    $img = $contact['imageName'];
                                    $img_src = empty($img) ? 'images/placeholder_100.jpg' : (strpos($img, 'http') === 0 ? $img : 'images/' . $img);
                                ?>
                                <img src="<?php echo htmlspecialchars($img_src); ?>" alt="Profile" width="50" height="50">
                            </td>
                            <td><?php echo htmlspecialchars($contact['firstName']); ?></td>
                            <td><?php echo htmlspecialchars($contact['lastName']); ?></td>
                            <td><a href="mailto:<?php echo htmlspecialchars($contact['emailAddress']); ?>"><?php echo htmlspecialchars($contact['emailAddress']); ?></a></td>
                            <td><?php echo htmlspecialchars($contact['phone']); ?></td>
                            <td><?php echo htmlspecialchars($contact['status']); ?></td>
                            <td>
                                <a href="update_contact_form.php?contactID=<?php echo $contact['contactID']; ?>">Edit</a> &nbsp;|&nbsp;
                                <form action="delete_contact.php" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="contact_id" value="<?php echo $contact['contactID']; ?>">
                                    <input type="submit" value="Delete">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="7">No contacts found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if ($totalPages > 1): ?>
                <div style="text-align: center; margin-top: 20px;">
                    <?php if ($page > 1): ?> <a href="?page=<?php echo $page - 1; ?>">Previous</a> <?php endif; ?>
                    <span>&nbsp;Page <?php echo $page; ?> of <?php echo max(1, $totalPages); ?>&nbsp;</span>
                    <?php if ($page < $totalPages): ?> <a href="?page=<?php echo $page + 1; ?>">Next</a> <?php endif; ?>
                </div>
            <?php endif; ?>
            <br><hr><br>
            <form action="index.php" method="POST" onsubmit="return confirm('Are you sure?');">
                <input type="hidden" name="action" value="delete_all">
                <input type="submit" value="Delete All Records">
            </form>
        </main>
        <?php include("footer.php"); ?>
    </body>
</html>