<?php include "core/init.php"; ?>
<?php include "templates/includes/head.php" ?>

<link rel="stylesheet" href="/static/css/login.css">
<div class="content">
    <h1 class="page-title">Register an account</h1>
    <form action="/api/register.php" method="post">
        <input type="text" name="username" placeholder="username" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="password" name="password2" placeholder="confirm password" required>
        <input type="submit" value="Register"/>
    </form>
</div>

<?php include "templates/includes/footer.php" ?>