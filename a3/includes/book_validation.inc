<?php
/*
 * Shared Add/Edit validation returns safe form values plus a list of errors.
 * Image validation checks upload origin, actual size, extension, MIME and image metadata.
 */
// Shared server validation for book forms.
// Browser checks can be bypassed, so PHP checks every field again.
function validate_book_fields($input) {
    $values = [];
    $errors = [];

    $limits = [
        'title' => 255,
        'author' => 255,
        'genre' => 100,
        'publication_year' => 4,
        'isbn' => 20,
        // Allow extra trailing zeros before normalising the price.
        'price' => 64,
        'book_condition' => 20,
        'status' => 20,
        'description' => 10000
    ];

    foreach ($limits as $field => $limit) {
        $raw = $input[$field] ?? '';
        $label = ucfirst(str_replace('_', ' ', $field));

        if (
            !is_string($raw) ||
            strlen($raw) > $limit * 4 ||
            preg_match('//u', $raw) !== 1 ||
            strpos($raw, "\0") !== false
        ) {
            $values[$field] = '';
            $errors[] = $label . ' contains invalid input or is too long.';
            continue;
        }

        $value = trim($raw);

        if ($value === '' || preg_match_all('/./us', $value) > $limit) {
            $errors[] = $label . ' is required and must fit within '
                . $limit . ' characters.';
            $value = '';
        }

        $values[$field] = $value;
    }

    $year = filter_var(
        $values['publication_year'],
        FILTER_VALIDATE_INT,
        [
            'options' => [
                'min_range' => 1000,
                'max_range' => (int) date('Y')
            ]
        ]
    );

    if ($year === false) {
        $errors[] = 'Choose a publication year from 1000 to ' . date('Y') . '.';
    }

    // Check ISBN format, not its checksum.
    $isbn = str_replace([' ', '-'], '', $values['isbn']);

    if (!preg_match('/\A(?:[0-9]{9}[0-9Xx]|[0-9]{13})\z/', $isbn)) {
        $errors[] = 'Enter a 10- or 13-character ISBN; only ISBN-10 may end in X.';
    }

    /*
     * Normalise prices using strings, avoiding floating-point rounding.
     * 19.990 becomes 19.99, while 19.991 is rejected.
     */
    $price = $values['price'];
    $validPrice = false;

    if (preg_match('/\A[0-9]+(?:\.[0-9]+)?\z/', $price)) {
        $parts = explode('.', $price, 2);

        // Remove unnecessary leading zeros from the whole-dollar amount.
        $whole = ltrim($parts[0], '0');
        $whole = $whole === '' ? '0' : $whole;

        // Extra decimal digits are acceptable only when they are trailing zeros.
        $fraction = rtrim($parts[1] ?? '', '0');

        if (strlen($whole) <= 6 && strlen($fraction) <= 2) {
            $fraction = str_pad($fraction, 2, '0');

            // Reject zero; the maximum is limited by six whole-dollar digits.
            if ($whole !== '0' || $fraction !== '00') {
                $values['price'] = $whole . '.' . $fraction;
                $validPrice = true;
            }
        }
    }

    if (!$validPrice) {
        $errors[] = 'Enter a price from $0.01 to $999,999.99 '
            . 'without fractions of a cent.';
    }

    if (!in_array(
        $values['book_condition'],
        ['New', 'Gently Used', 'Fair'],
        true
    )) {
        $errors[] = 'Choose a listed book condition.';
    }

    if (!in_array(
        $values['status'],
        ['Available', 'Reserved', 'Sold'],
        true
    )) {
        $errors[] = 'Choose a listed availability status.';
    }

    return [$values, array_unique($errors)];
}

// Inspect actual uploaded bytes, never the browser-supplied MIME type.
function validate_book_cover($file) {
    if (
        !is_array($file) ||
        !isset($file['error']) ||
        !is_int($file['error'])
    ) {
        throw new InvalidArgumentException('Choose a cover image.');
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $messages = [
            UPLOAD_ERR_INI_SIZE =>
                'The cover exceeds the server upload limit. Choose a smaller image.',
            UPLOAD_ERR_FORM_SIZE =>
                'The cover exceeds the upload limit.',
            UPLOAD_ERR_PARTIAL =>
                'The cover only uploaded partially. Please select it again.',
            UPLOAD_ERR_NO_FILE =>
                'Choose a cover image.'
        ];

        throw new InvalidArgumentException(
            $messages[$file['error']]
                ?? 'The server could not receive the cover. Please try again.'
        );
    }

    $temporary = $file['tmp_name'] ?? null;
    $original = $file['name'] ?? null;

    if (
        !is_string($temporary) ||
        !is_string($original) ||
        !is_uploaded_file($temporary)
    ) {
        throw new InvalidArgumentException('Choose a valid uploaded image.');
    }

    $size = filesize($temporary);

    if ($size === false || $size < 1 || $size > 5 * 1024 * 1024) {
        throw new InvalidArgumentException(
            'Choose a non-empty image no larger than 5 MiB.'
        );
    }

    $types = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp'
    ];

    $extension = strtolower(pathinfo($original, PATHINFO_EXTENSION));
    $info = @getimagesize($temporary);
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($temporary);

    if (
        !isset($types[$extension]) ||
        $mime !== $types[$extension] ||
        $info === false ||
        ($info['mime'] ?? '') !== $types[$extension]
    ) {
        throw new InvalidArgumentException(
            'Choose a real JPG, JPEG, PNG, GIF or WEBP image matching its extension.'
        );
    }

    return [$temporary, $extension === 'jpeg' ? 'jpg' : $extension];
}