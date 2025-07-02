<?php
function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

function strip_bad_chars($input) {
    $output = preg_replace('/[^a-zA-Z0-9_-]/', '', $input);
    return $output;
}
?>
