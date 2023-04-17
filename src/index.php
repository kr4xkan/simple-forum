<?php
include "core/init.php";

if (isLoggedIn()) {
    include "templates/home.php";
} else {
    include "templates/unauthorized.php";
}
