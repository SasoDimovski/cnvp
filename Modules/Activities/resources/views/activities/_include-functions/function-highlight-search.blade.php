<?php
function highlightSearch($text, $searchKey, $style) {
    $searchTerm = app('request')->input($searchKey);
    if (!$searchTerm || strlen($searchTerm) === 0) {
        return $text;
    }
    return str_replace($searchTerm, "<b style='{$style}'>{$searchTerm}</b>", $text);
}
