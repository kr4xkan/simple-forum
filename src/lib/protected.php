<?php
if (!isLoggedIn()) {
    redirect("/login.php");
}