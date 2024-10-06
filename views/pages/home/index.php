<div class="row">
    <div class="box">    
        <h1>Hallo, <?= $userData->username; ?></h1>
        <p><i>Role: <?= $userData->role; ?></i></p>
    </div>
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

        <p class="error-message-<?= !empty($content['message']) ? 'active' : '' ?>"><?= $content['message'] ?? null; ?></p>
    </div>
</div>