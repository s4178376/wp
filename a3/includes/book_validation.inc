<?php
// Shared server validation for book forms. Browser checks can be bypassed.
function validate_book_fields($input) {
    $values = [];
    $errors = [];
    $limits = ['title' => 255, 'author' => 255, 'genre' => 100,
        'publication_year' => 4, 'isbn' => 20, 'price' => 9,
        'book_condition' => 20, 'status' => 20, 'description' => 10000];
    foreach ($limits as $field => $limit) {
        $raw = $input[$field] ?? '';
        $label = ucfirst(str_replace('_', ' ', $field));
        if (!is_string($raw) || strlen($raw) > $limit * 4 ||
            preg_match('//u', $raw) !== 1 || strpos($raw, "\0") !== false) {
            $values[$field] = '';
            $errors[] = $label . ' contains invalid input or is too long.';
            continue;
        }
        $value = trim($raw);
        if ($value === '' || preg_match_all('/./us', $value) > $limit) {
            $errors[] = $label . ' is required and must fit within ' . $limit . ' characters.';
            $value = '';
        }
        $values[$field] = $value;
    }
    $year = filter_var($values['publication_year'], FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1000, 'max_range' => (int) date('Y')]]);
    if ($year === false) $errors[] = 'Choose a publication year from 1000 to ' . date('Y') . '.';
    $isbn = str_replace([' ', '-'], '', $values['isbn']);
    // This checks ISBN format, not its checksum; it matches the existing form.
    if (!preg_match('/\A(?:[0-9]{9}[0-9Xx]|[0-9]{13})\z/', $isbn)) {
        $errors[] = 'Enter a 10- or 13-character ISBN; only ISBN-10 may end in X.';
    }
    if (!preg_match('/\A[0-9]{1,6}(?:\.[0-9]{1,2})?\z/', $values['price']) ||
        (float) $values['price'] < 0.01 || (float) $values['price'] > 999999.99) {
        $errors[] = 'Enter a price from $0.01 to $999,999.99 with at most two decimal places.';
    }
    if (!in_array($values['book_condition'], ['New', 'Gently Used', 'Fair'], true)) {
        $errors[] = 'Choose a listed book condition.';
    }
    if (!in_array($values['status'], ['Available', 'Reserved', 'Sold'], true)) {
        $errors[] = 'Choose a listed availability status.';
    }
    return [$values, array_unique($errors)];
}

// Inspect actual uploaded bytes, never the browser-supplied MIME type.
function validate_book_cover($file) {
    if (!is_array($file) || !isset($file['error']) || !is_int($file['error'])) {
        throw new InvalidArgumentException('Choose a cover image.');
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $messages = [
            UPLOAD_ERR_INI_SIZE => 'The cover exceeds the server upload limit. Choose a smaller image.',
            UPLOAD_ERR_FORM_SIZE => 'The cover exceeds the upload limit.',
            UPLOAD_ERR_PARTIAL => 'The cover only uploaded partially. Please select it again.',
            UPLOAD_ERR_NO_FILE => 'Choose a cover image.',
        ];
        throw new InvalidArgumentException($messages[$file['error']] ?? 'The server could not receive the cover. Please try again.');
    }
    $temporary = $file['tmp_name'] ?? null;
    $original = $file['name'] ?? null;
    if (!is_string($temporary) || !is_string($original) || !is_uploaded_file($temporary)) {
        throw new InvalidArgumentException('Choose a valid uploaded image.');
    }
    $size = filesize($temporary);
    if ($size === false || $size < 1 || $size > 5 * 1024 * 1024) {
        throw new InvalidArgumentException('Choose a non-empty image no larger than 5 MiB.');
    }
    $types = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png',
        'gif' => 'image/gif', 'webp' => 'image/webp'];
    $extension = strtolower(pathinfo($original, PATHINFO_EXTENSION));
    $info = @getimagesize($temporary);
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($temporary);
    if (!isset($types[$extension]) || $mime !== $types[$extension] ||
        $info === false || ($info['mime'] ?? '') !== $types[$extension]) {
        throw new InvalidArgumentException('Choose a real JPG, JPEG, PNG, GIF or WEBP image matching its extension.');
    }
    return [$temporary, $extension === 'jpeg' ? 'jpg' : $extension];
}
