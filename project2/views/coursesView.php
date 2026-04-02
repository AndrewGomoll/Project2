<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <nav>
        <?php include 'nav.php'; ?>
    </nav>

    <h1>Courses</h1>

    <table>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Description</th>
            <th>Credits</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($courses as $course) : ?>
            <tr>
                <td><?php echo htmlspecialchars($course->getCode()); ?></td>
                <td><?php echo htmlspecialchars($course->getName()); ?></td>
                <td><?php echo htmlspecialchars($course->getDescription()); ?></td>
                <td><?php echo htmlspecialchars($course->getCredits()); ?></td>
                <td>
                    <form method="post" action="courses.php">
                        <input type="hidden" name="updateCourse" value="<?php echo htmlspecialchars($course->getCode()); ?>">
                        <button type="submit" name="editCourse">Edit</button>
                    </form>

                    <form method="post" action="courses.php">
                        <input type="hidden" name="deleteCourse" value="<?php echo htmlspecialchars($course->getCode()); ?>">
                        <button type="submit" name="deleteCourse">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2><?php echo $editingCourse ? 'Edit Course' : 'Add New Course'; ?></h2>

    <form action="courses.php" method="post">
        <input type="hidden" name="originalCode" value="<?php echo htmlspecialchars($editingCourse['code'] ?? ''); ?>" />

        <label>Course Code</label>
        <input type="text" name="code" value="<?php echo htmlspecialchars($editingCourse['code'] ?? ''); ?>" required />

        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($editingCourse['name'] ?? ''); ?>" required />

        <label>Description</label>
        <textarea name="description"><?php echo htmlspecialchars($editingCourse['description'] ?? ''); ?></textarea>

        <label>Credits</label>
        <input type="number" name="credits" value="<?php echo htmlspecialchars($editingCourse['credits'] ?? 0); ?>" />

        <button type="submit" name="saveCourse">
            <?php echo $editingCourse ? 'Update Course' : 'Add Course'; ?>
        </button>
    </form>
</body>
</html>