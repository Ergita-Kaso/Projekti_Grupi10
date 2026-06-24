<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

include(__DIR__ . '/includes/config.php');
include_once(__DIR__ . '/includes/password-helper.php');

function passwordColumnCanStoreHash($dbh, $table) {
    $sql = "SELECT CHARACTER_MAXIMUM_LENGTH
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = :table
              AND COLUMN_NAME = 'Password'";
    $query = $dbh->prepare($sql);
    $query->bindParam(':table', $table, PDO::PARAM_STR);
    $query->execute();
    $length = $query->fetchColumn();

    return $length === false || (int) $length >= 60;
}

function storedPasswordIsHashed($password) {
    $info = password_get_info((string) $password);
    return !empty($info['algo']);
}

foreach (array('tblusers', 'admin') as $table) {
    if (!passwordColumnCanStoreHash($dbh, $table)) {
        exit("Password column in {$table} must be at least 60 characters before migration.\n");
    }
}

$updatedUsers = 0;
$updatedAdmins = 0;

$dbh->beginTransaction();

$users = $dbh->query("SELECT id, Password FROM tblusers")->fetchAll(PDO::FETCH_OBJ);
foreach ($users as $user) {
    if ($user->Password !== '' && !storedPasswordIsHashed($user->Password)) {
        $hashedPassword = dreamPasswordHash($user->Password);
        $update = $dbh->prepare("UPDATE tblusers SET Password=:password WHERE id=:id");
        $update->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $update->bindParam(':id', $user->id, PDO::PARAM_INT);
        $update->execute();
        $updatedUsers++;
    }
}

$admins = $dbh->query("SELECT UserName, Password FROM admin")->fetchAll(PDO::FETCH_OBJ);
foreach ($admins as $admin) {
    if ($admin->Password !== '' && !storedPasswordIsHashed($admin->Password)) {
        $hashedPassword = dreamPasswordHash($admin->Password);
        $update = $dbh->prepare("UPDATE admin SET Password=:password WHERE UserName=:username");
        $update->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $update->bindParam(':username', $admin->UserName, PDO::PARAM_STR);
        $update->execute();
        $updatedAdmins++;
    }
}

$dbh->commit();

echo "Migrated {$updatedUsers} user password(s) and {$updatedAdmins} admin password(s).\n";
?>
