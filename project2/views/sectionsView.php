<html>
<head>
    <meta charset="UTF-8">
</head>

<nav>
    <?php include 'nav.php'; ?>
</nav>

<body>

<h1>Sections</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Course</th>
        <th>Faculty ID</th>
        <th>Semester</th>
        <th>Actions</th>
    </tr>
    <?php if (!empty($sections)) : ?>
        <?php foreach ($sections as $section) : ?>
            <tr>
                <td><?php echo htmlspecialchars($section->getId()); ?></td>
                <td><?php echo htmlspecialchars($section->getCourseCode()); ?></td>
                <td><?php echo htmlspecialchars($section->getFacultyId()); ?></td>
                <td><?php echo htmlspecialchars($section->getSemester()); ?></td>
                <td>
                    <form method="post" action="sections.php">
                        <input type="hidden" name="updateSection" value="<?php echo htmlspecialchars($section->getId()); ?>">
                        <button type="submit" name="editSection">Edit</button>
                    </form>

                    <form method="post" action="sections.php">
                        <input type="hidden" name="deleteSection" value="<?php echo htmlspecialchars($section->getId()); ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td>No sections found</td>
        </tr>
    <?php endif; ?>
</table>

<h2><?php echo $editingSection ? "Edit Section" : "Add Section"; ?></h2>

<form method="post" action="sections.php">
    <input type="hidden" name="originalId" value="<?php echo isset($editingSection['id']) ? htmlspecialchars($editingSection['id']) : ''; ?>">

    <label>Course:</label>
    <select name="course_code" required>
        <option value="">Select a course</option>
        <?php foreach ($courses as $course) : ?>
            <option value="<?php echo htmlspecialchars($course->getCode()); ?>" <?php echo (isset($editingSection['course_code']) && $editingSection['course_code'] == $course->getCode()) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($course->getDescription()); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <label>Faculty:</label>
    <select name="faculty_id" required>
        <option value="">Select a faculty</option>
        <?php foreach ($faculties as $faculty) : ?>
            <option value="<?php echo htmlspecialchars($faculty->getId()); ?>" <?php echo (isset($editingSection['faculty_id']) && $editingSection['faculty_id'] == $faculty->getId()) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($faculty->getName()); ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label>Semester:</label>
    <input type="text" name="semester" value="<?php echo isset($editingSection['semester']) ? htmlspecialchars($editingSection['semester']) : ''; ?>" required><br>

    <button type="submit" name="addSection"><?php echo $editingSection ? "Update" : "Add"; ?></button>
</form>

</body>
</html>