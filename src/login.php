<?php include "core/init.php"; ?>
<?php include "templates/includes/head.php" ?>

<link rel="stylesheet" href="/static/css/login.css">
<div class="content">
    <h1 class="page-title">Login</h1>
    <form action="/api/login.php" method="post">
        <input type="text" name="username" placeholder="username" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="submit" value="Login"/>
    </form>
</div>

<?php include "templates/includes/footer.php" ?>