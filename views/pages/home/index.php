<h1>Hallo, <?= $userData->username; ?></h1>

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