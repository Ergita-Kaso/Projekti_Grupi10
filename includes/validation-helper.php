<?php
function dreamCleanInput($value) {
    return trim((string) $value);
}

function dreamTextLength($value, $min, $max) {
    $length = strlen($value);
    return $length >= $min && $length <= $max;
}

function dreamValidName($value) {
    return dreamTextLength($value, 2, 80) && preg_match('/^[\p{L}\s.\'-]+$/u', $value);
}

function dreamValidPhone($value) {
    return preg_match('/^[0-9+()\-\s]{7,20}$/', $value);
}

function dreamValidEmail($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL) && strlen($value) <= 120;
}

function dreamValidPassword($value) {
    return strlen($value) >= 6 && strlen($value) <= 72;
}

function dreamValidDateValue($value) {
    $date = DateTime::createFromFormat('Y-m-d', $value);
    return $date && $date->format('Y-m-d') === $value;
}

function dreamValidPositivePrice($value) {
    return preg_match('/^\d+(\.\d{1,2})?$/', $value) && (float) $value > 0 && (float) $value <= 999999.99;
}

function dreamAllowedValue($value, $allowedValues) {
    return in_array($value, $allowedValues, true);
}

function dreamValidateUploadedImage($file, &$safeName, &$error) {
    $safeName = '';
    if (!isset($file) || !isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        $error = 'Ju lutemi zgjidhni nje foto te vlefshme.';
        return false;
    }
    if ($file['size'] <= 0 || $file['size'] > 2 * 1024 * 1024) {
        $error = 'Foto duhet te jete maksimumi 2MB.';
        return false;
    }

    $allowed = array(
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif'
    );
    $mime = mime_content_type($file['tmp_name']);
    if (!isset($allowed[$mime])) {
        $error = 'Lejohen vetem foto JPG, PNG, WEBP ose GIF.';
        return false;
    }

    $base = pathinfo($file['name'], PATHINFO_FILENAME);
    $base = preg_replace('/[^A-Za-z0-9_-]+/', '-', $base);
    $base = trim($base, '-');
    if ($base === '') {
        $base = 'package';
    }
    $safeName = $base . '-' . time() . '.' . $allowed[$mime];
    return true;
}
?>
