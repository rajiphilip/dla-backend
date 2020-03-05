<?php

if (!isset($_SESSION['username'])) {
    header('location: ' . URL . '/logout');
}

if (in_array($_SESSION['type'], PERMITTED_ROLES)) {
    return true;
} else {
    return false;
}