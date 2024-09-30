<h1><?= ucfirst($title) ?></h1>
<div class="login-container">
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
        <div class="error-message" id="error-message"></div>
    </form>
</div>