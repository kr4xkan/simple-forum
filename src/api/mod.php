<?php
include $_SERVER["DOCUMENT_ROOT"]."/core/init.php";
include $_SERVER["DOCUMENT_ROOT"]."/lib/protected.php";

if (!array_key_exists("id", $_REQUEST)) {
    redirect("/settings.php?view=users");
}

if ($_REQUEST["id"] == $_SESSION["user_id"]) {
    redirect("/settings.php");
}

$db = db();
$q = $db->prepare("SELECT role FROM users WHERE id=?");
$q->bind_param("s", $_REQUEST["id"]);
$q->execute();

$new_role = "moderator";
if ($q->get_result()->fetch_row()[0] == "moderator") {
    $new_role = "user";
}

$q = $db->prepare("UPDATE users SET role=? WHERE id=?");
$q->bind_param("ss", $new_role, $_REQUEST["id"]);
$q->execute();

redirect("/settings.php?view=users");