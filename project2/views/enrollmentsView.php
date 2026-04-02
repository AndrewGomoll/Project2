<html>
<head>
    <meta charset="UTF-8">
</head>

<nav>
    <?php include 'nav.php'; ?>
</nav>

<body>
    <h1>Enrollment Records</h1>

    <table>
        <tr>
            <th>Student</th>
            <th>Section</th>
            <th>Grade</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($enrollments as $enroll) : ?>
            <tr>
                <td><?php
                    foreach ($students as $s) {
                        if ($s->getId() == $enroll->getStudentId()) echo htmlspecialchars($s->getName());
                    }
                ?></td>
                <td><?php
                    foreach ($sections as $sec) {
                        if ($sec->getId() == $enroll->getSectionId()) echo htmlspecialchars($sec->getId());
                    }
                ?></td>
                <td><?php echo htmlspecialchars($enroll->getGrade()); ?></td>
                <td>
                    <form method="post" action="enrollments.php">
                        <input type="hidden" name="updateEnrollment" value="<?php echo htmlspecialchars($enroll->getId()); ?>">
                        <button type="submit" name="editEnrollment">Edit</button>
                    </form>
                    <form method="post" action="enrollments.php">
                        <input type="hidden" name="deleteEnrollment" value="<?php echo htmlspecialchars($enroll->getId()); ?>">
                        <button type="submit" name="deleteEnrollment">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2><?php echo $editingEnrollment ? 'Edit Enrollment' : 'Add Enrollment'; ?></h2>

    <form method="post" action="enrollments.php">
        <input type="hidden" name="originalId" value="<?php echo isset($editingEnrollment['id']) ? htmlspecialchars($editingEnrollment['id']) : ''; ?>">

        <label>Student:</label>
        <select name="student_id" required>
            <option value="">Select Student</option>
            <?php foreach ($students as $s) : ?>
                <option value="<?php echo htmlspecialchars($s->getId()); ?>" <?php echo (isset($editingEnrollment['student_id']) && $editingEnrollment['student_id'] == $s->getId()) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($s->getName()); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Section:</label>
        <select name="section_id" required>
            <option value="">Select Section</option>
            <?php foreach ($sections as $sec) : ?>
                <option value="<?php echo htmlspecialchars($sec->getId()); ?>" <?php echo (isset($editingEnrollment['section_id']) && $editingEnrollment['section_id'] == $sec->getId()) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($sec->getId()); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Grade:</label>
        <input type="text" name="grade" value="<?php echo isset($editingEnrollment['grade']) ? htmlspecialchars($editingEnrollment['grade']) : ''; ?>">

        <button type="submit" name="addEnrollment"><?php echo $editingEnrollment ? 'Update' : 'Add'; ?></button>
    </form>

</body>

</html>