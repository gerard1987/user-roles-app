<h1>Hallo, <?= Auth::isAdmin() ? 'Admin' : $userData->username; ?></h1>

<div class="row">
    <?php if (Auth::isAdmin()): ?>
    <div class="box">
        <!-- User Creation Form -->
        <h2>User aanmaken</h2>
        <form action="create_user" method="POST">
            <label for="create-username">Username:</label>
            <input type="text" id="create-username" name="username" required>

            <label for="create-password">Password:</label>
            <input type="password" id="create-password" name="password" required>

            <input type="submit" value="Create">
        </form>
    </div>
    <?php endif; ?>
</div>
<div class="row">
    <div class="box">
        <!-- User Update Form -->
        <h2>Wachtwoord resetten</h2>
        <form action="reset_password" method="POST">
            <label for="update-username">Username:</label>
            <input type="text" id="update-username" name="username" value="<?=$userData->username?>" disabled>

            <label for="update-password">New Password:</label>
            <input type="password" id="update-password" name="new_password" required>

            <input type="submit" value="Edit">
        </form>
    </div>
</div>