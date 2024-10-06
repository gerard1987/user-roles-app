<div class="box">
    <h2>Login</h2>
    <form action="login" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>

    <p><a href="/authorization/register">Or create a account here!</a></p>
    </br>
    <p class="error-message"><?= $content['message'] ?></p>
</div>