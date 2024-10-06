<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? '' ?></title>
    <link rel="stylesheet" href="/css/general.css">
    <?php 
        if (Auth::isAdmin()){
            echo '<style>header {background: #931212;}</style>';
        }
    ?>
</head>
<body>
<header>
    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li><a href="/home/index">Dashboard</a></li>
            <li><a href="/home/users">Users</a></li>
            <?php if (empty(Auth::getLoggedInUser())): ?>
            <li><a href="/authorization/login">Login</a></li>
            <?php else: ?>
            <li><a href="/authorization/logout">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>