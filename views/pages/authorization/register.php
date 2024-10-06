<div class="box">
    <h2>Create a account</h2>
    <form action="register" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Register">
    </form>

    <p class="error-message-<?= !empty($content['message']) ? 'active' : '' ?>"><?= $content['message'] ?? null; ?></p>
</div>