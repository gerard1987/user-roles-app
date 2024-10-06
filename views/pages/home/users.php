<div class="row">
    <div class="box">
        <!-- Users overview -->
        <h2>Users</h2>
        <br>
        <table style="width: 100%; text-align: left;">
            <th>Username</th>
            <th>Role</th>
                <?php foreach($content as $k => $user): ?>
                    <tr>
                        <td><?= $user->username; ?></td>
                        <td><?= $user->role; ?></td>
                    </tr>
                <?php endforeach; ?>
        </table>
    </div>
</div>
<div class="row">
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

        <p class="error-message-<?= !empty($content['message']) ? 'active' : '' ?>"><?= $content['message'] ?? null; ?></p>
    </div>
</div>