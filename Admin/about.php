<?php
include('../includes/auth.php');
include('../includes/db.php');

/* =========================================
   GET ABOUT DATA
========================================= */
$about = $conn->query("SELECT * FROM about LIMIT 1")->fetch_assoc();


/* =========================================
   UPDATE ABOUT
========================================= */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_about'])) {

    $full_name   = $_POST['full_name'];
    $headline    = $_POST['headline'];
    $short_bio   = $_POST['short_bio'];
    $full_bio    = $_POST['full_bio'];

    $email       = $_POST['email'];
    $whatsapp    = $_POST['whatsapp'];
    $github      = $_POST['github'];
    $behance     = $_POST['behance'];
    $linkedin    = $_POST['linkedin'];
    $instagram   = $_POST['instagram'];

    $location    = $_POST['location'];

    /* PROFILE IMAGE */
    $profile_image = $about['profile_image'];

    if (!empty($_FILES['profile_image']['name'])) {

        $targetDir = "../uploads/profile/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES["profile_image"]["name"]);
        $targetFile = $targetDir . $fileName;

        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile);

        $profile_image = "uploads/profile/" . $fileName;
    }

    $stmt = $conn->prepare("
        UPDATE about SET
        full_name=?,
        headline=?,
        short_bio=?,
        full_bio=?,
        profile_image=?,
        email=?,
        whatsapp=?,
        github=?,
        behance=?,
        linkedin=?,
        instagram=?,
        location=?
        WHERE id=1
    ");

    $stmt->bind_param(
        "ssssssssssss",
        $full_name,
        $headline,
        $short_bio,
        $full_bio,
        $profile_image,
        $email,
        $whatsapp,
        $github,
        $behance,
        $linkedin,
        $instagram,
        $location
    );

    $stmt->execute();

    header("Location: about.php?success=1");
    exit();
}


/* =========================================
   ADD SKILL
========================================= */
if (isset($_POST['add_skill'])) {

    $skill_name = $_POST['skill_name'];
    $category   = $_POST['category'];
    $level      = intval($_POST['level']);

    $stmt = $conn->prepare("
        INSERT INTO skills (skill_name, category, level)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param("ssi", $skill_name, $category, $level);
    $stmt->execute();

    header("Location: about.php?skill_added=1");
    exit();
}


/* =========================================
   DELETE SKILL
========================================= */
if (isset($_GET['delete_skill'])) {

    $id = intval($_GET['delete_skill']);

    $conn->query("DELETE FROM skills WHERE id=$id");

    header("Location: about.php?skill_deleted=1");
    exit();
}


/* =========================================
   GET SKILLS
========================================= */
$skills = $conn->query("SELECT * FROM skills ORDER BY level DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me — Zulius CMS</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            background: #0b0b0f;
            color: white;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #111;
            padding: 30px 20px;
        }

        .sidebar h2 {
            color: #3b82f6;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            margin-bottom: 18px;
        }

        .sidebar a:hover {
            color: white;
        }

        /* MAIN */
        .main {
            flex: 1;
            padding: 40px;
        }

        h1 {
            margin-bottom: 10px;
        }

        h2 {
            margin: 40px 0 20px;
            color: #3b82f6;
        }

        .success {
            color: #3b82f6;
            margin-bottom: 20px;
        }

        form {
            display: grid;
            gap: 14px;
            max-width: 900px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 14px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            color: white;
            border-radius: 8px;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        button {
            padding: 14px 24px;
            background: #3b82f6;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 8px;
            width: fit-content;
        }

        .profile-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 10px;
        }

        /* SKILLS */
        .skills-list {
            margin-top: 30px;
            display: grid;
            gap: 14px;
            max-width: 900px;
        }

        .skill-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
        }

        .skill-info h3 {
            margin-bottom: 4px;
        }

        .skill-info p {
            opacity: 0.65;
            font-size: 0.9rem;
        }

        .delete-btn {
            color: red;
            text-decoration: none;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Zulius CMS</h2>

    <a href="dashboard.php">Dashboard</a>
    <a href="about.php">About Me</a>
    <a href="projects.php">Projects</a>
    <a href="analytics.php">Analytics</a>
    <a href="logout.php">Logout</a>
</div>


<!-- MAIN -->
<div class="main">

    <h1>About Me</h1>

    <?php if(isset($_GET['success'])): ?>
        <p class="success">About updated successfully.</p>
    <?php endif; ?>

    <!-- ABOUT FORM -->
    <form method="POST" enctype="multipart/form-data">

        <?php if(!empty($about['profile_image'])): ?>
            <img src="../<?php echo $about['profile_image']; ?>" class="profile-preview">
        <?php endif; ?>

        <input type="file" name="profile_image">

        <input type="text" name="full_name" placeholder="Full Name"
            value="<?php echo htmlspecialchars($about['full_name']); ?>">

        <input type="text" name="headline" placeholder="Headline"
            value="<?php echo htmlspecialchars($about['headline']); ?>">

        <textarea name="short_bio" placeholder="Short Bio"><?php echo htmlspecialchars($about['short_bio']); ?></textarea>

        <textarea name="full_bio" placeholder="Full Bio"><?php echo htmlspecialchars($about['full_bio']); ?></textarea>

        <input type="email" name="email" placeholder="Email"
            value="<?php echo htmlspecialchars($about['email']); ?>">

        <input type="text" name="whatsapp" placeholder="WhatsApp"
            value="<?php echo htmlspecialchars($about['whatsapp']); ?>">

        <input type="text" name="github" placeholder="GitHub"
            value="<?php echo htmlspecialchars($about['github']); ?>">

        <input type="text" name="behance" placeholder="Behance"
            value="<?php echo htmlspecialchars($about['behance']); ?>">

        <input type="text" name="linkedin" placeholder="LinkedIn"
            value="<?php echo htmlspecialchars($about['linkedin']); ?>">

        <input type="text" name="instagram" placeholder="Instagram"
            value="<?php echo htmlspecialchars($about['instagram']); ?>">

        <input type="text" name="location" placeholder="Location"
            value="<?php echo htmlspecialchars($about['location']); ?>">

        <button type="submit" name="save_about">Save About</button>
    </form>


    <!-- SKILLS -->
    <h2>Skills</h2>

    <form method="POST">
        <input type="text" name="skill_name" placeholder="Skill Name" required>

        <input type="text" name="category" placeholder="Category (Design / Strategy / Development)" required>

        <input type="number" name="level" placeholder="Level (0-100)" min="0" max="100" required>

        <button type="submit" name="add_skill">Add Skill</button>
    </form>


    <!-- SKILLS LIST -->
    <div class="skills-list">

        <?php while($skill = $skills->fetch_assoc()): ?>
            <div class="skill-card">

                <div class="skill-info">
                    <h3><?php echo htmlspecialchars($skill['skill_name']); ?> — <?php echo $skill['level']; ?>%</h3>
                    <p><?php echo htmlspecialchars($skill['category']); ?></p>
                </div>

                <a class="delete-btn"
                   href="about.php?delete_skill=<?php echo $skill['id']; ?>"
                   onclick="return confirm('Delete this skill?')">
                   Delete
                </a>

            </div>
        <?php endwhile; ?>

    </div>

</div>

</body>
</html>