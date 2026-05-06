<?php
include('../includes/auth.php');
include('../includes/db.php');

/* TOTAL PROJECTS */
$totalProjects = $conn->query("SELECT COUNT(*) as total FROM projects")->fetch_assoc()['total'];

/* FEATURED PROJECTS */
$featuredProjects = $conn->query("SELECT COUNT(*) as total FROM projects WHERE featured = 1")->fetch_assoc()['total'];

/* TOTAL SKILLS */
$totalSkills = $conn->query("SELECT COUNT(*) as total FROM skills")->fetch_assoc()['total'];

/* TOTAL PAGE VIEWS */
$totalViews = $conn->query("SELECT COUNT(*) as total FROM analytics WHERE type IN ('page_view','project_view')")->fetch_assoc()['total'];

/* WHATSAPP CLICKS */
$whatsappClicks = $conn->query("SELECT COUNT(*) as total FROM analytics WHERE type = 'whatsapp_click'")->fetch_assoc()['total'];

/* EMAIL CLICKS */
$emailClicks = $conn->query("SELECT COUNT(*) as total FROM analytics WHERE type = 'email_click'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Zulius CMS</title>

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
            margin-bottom: 40px;
            color: #3b82f6;
        }

        .sidebar a {
            display: block;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: white;
        }

        /* MAIN */
        .main {
            flex: 1;
            padding: 40px;
        }

        .main h1 {
            margin-bottom: 10px;
        }

        .main p {
            opacity: 0.6;
            margin-bottom: 40px;
        }

        /* CARDS */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
            gap: 20px;
        }

        .card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            padding: 24px;
            border-radius: 14px;
        }

        .card h3 {
            font-size: 0.95rem;
            opacity: 0.65;
            margin-bottom: 12px;
        }

        .card h2 {
            font-size: 2.2rem;
            color: #3b82f6;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Zulius CMS</h2>

    <a href="dashboard.php">Dashboard</a>
    <a href="about.php">About Me</a>
    <a href="skills.php">Skills</a>
    <a href="projects.php">Projects</a>
    <a href="analytics.php">Analytics</a>
    <a href="logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">
    <h1>Welcome Back, <?php echo $_SESSION['admin_username']; ?></h1>
    <p>Your personal creative operating system overview.</p>

    <div class="cards">

        <div class="card">
            <h3>Total Projects</h3>
            <h2><?php echo $totalProjects; ?></h2>
        </div>

        <div class="card">
            <h3>Featured Projects</h3>
            <h2><?php echo $featuredProjects; ?></h2>
        </div>

        <div class="card">
            <h3>Total Skills</h3>
            <h2><?php echo $totalSkills; ?></h2>
        </div>

        <div class="card">
            <h3>Total Views</h3>
            <h2><?php echo $totalViews; ?></h2>
        </div>

        <div class="card">
            <h3>WhatsApp Clicks</h3>
            <h2><?php echo $whatsappClicks; ?></h2>
        </div>

        <div class="card">
            <h3>Email Clicks</h3>
            <h2><?php echo $emailClicks; ?></h2>
        </div>

    </div>
</div>

</body>
</html>