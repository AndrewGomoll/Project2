<html>
<head>
    <meta charset="UTF-8">
</head>
<nav>
    <?php include 'nav.php'; ?>
</nav>
<body>
    <h1>Students</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Major</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($students)) : ?>
            <?php foreach ($students as $student) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($student->getId()); ?></td>
                    <td><?php echo htmlspecialchars($student->getName()); ?></td>
                    <td><?php echo htmlspecialchars($student->getMajor()); ?></td>
                    <td>
                        <form method="post" action="students.php">
                            <input type="hidden" name="updateStudent" value="<?php echo htmlspecialchars($student->getId()); ?>">
                            <button type="submit" name="editStudent">Edit</button>
                        </form>

                        <form method="post" action="students.php">
                            <input type="hidden" name="deleteStudent" value="<?php echo htmlspecialchars($student->getId()); ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="4">No students found.</td>
            </tr>
        <?php endif; ?>
    </table>

    <h2><?php echo $editingStudent ? "Edit Student" : "Add Student"; ?></h2>

    <form method="post" action="students.php">
        <input type="hidden" name="id" value="<?php echo $editingStudent ? htmlspecialchars($editingStudent->getId()) : ''; ?>" />

        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $editingStudent ? htmlspecialchars($editingStudent->getName()) : ''; ?>" required />

        <label>Major:</label>
        <input type="text" name="major" value="<?php echo $editingStudent ? htmlspecialchars($editingStudent->getMajor()) : ''; ?>" required />

        <button type="submit" name="saveStudent"><?php echo $editingStudent ? "Update" : "Add"; ?></button>
    </form>
</body>

</html>