<html>
<head>
    <meta charset="UTF-8">
</head>

<nav>
    <?php include 'nav.php'; ?>
</nav>

<body>

<h1>Faculty List</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php if (!empty($faculties)) : ?>
        <?php foreach ($faculties as $faculty) : ?>
            <tr>
                <td><?php echo htmlspecialchars($faculty->getId()); ?></td>
                <td><?php echo htmlspecialchars($faculty->getName()); ?></td>
                <td><?php echo htmlspecialchars($faculty->getEmail()); ?></td>
                <td>
                    <form method="post" action="faculty.php">
                        <input type="hidden" name="updateFaculty" value="<?php echo htmlspecialchars($faculty->getId()); ?>">
                        <button type="submit" name="editFaculty">Edit</button>
                    </form>

                    <form method="post" action="faculty.php">
                        <input type="hidden" name="deleteFaculty" value="<?php echo htmlspecialchars($faculty->getId()); ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td>No faculty found.</td>
        </tr>
    <?php endif; ?>
</table>

<h2><?php echo $editingFaculty ? "Edit Faculty" : "Add Faculty"; ?></h2>

<form method="post" action="faculty.php">
    <input type="hidden" name="originalId" value="<?php echo htmlspecialchars($editingFaculty['id'] ?? ''); ?>">

    <label>Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($editingFaculty['name'] ?? ''); ?>" required><br>

    <label>Email:</label>
    <input type="text" name="email" value="<?php echo htmlspecialchars($editingFaculty['email'] ?? ''); ?>"><br>

    <button type="submit" name="addFaculty"><?php echo $editingFaculty ? "Update" : "Add"; ?></button>
</form>

</body>
</html>