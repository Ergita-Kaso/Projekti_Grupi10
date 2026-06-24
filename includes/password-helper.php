<?php
function dreamPasswordHash($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function dreamPasswordMatches($password, $storedPassword) {
    if (password_verify($password, $storedPassword)) {
        return true;
    }

    return hash_equals((string) $storedPassword, (string) $password);
}

function dreamPasswordNeedsUpgrade($storedPassword) {
    return password_needs_rehash($storedPassword, PASSWORD_DEFAULT);
}
?>
