<?php

include $_SERVER["DOCUMENT_ROOT"]."/core/db.php";
include $_SERVER["DOCUMENT_ROOT"]."/lib/utils.php";

$db = db();
$q = $db->query("SELECT value FROM site_settings WHERE name='is_setup'");
$is_setup = $q->fetch_row()[0] == 1;

if (!$is_setup) {
    redirect("/setup.php");
}

session_start();


update_last_seen_session();