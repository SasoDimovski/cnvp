<?php
function highlightSearch($text, $searchKey, $style) {
    $searchTerm = app('request')->input($searchKey);
    if (!$searchTerm || strlen($searchTerm) === 0) {
        return $text;
    }
    return str_replace($searchTerm, "<b style='{$style}'>{$searchTerm}</b>", $text);
}
 ?><?php /**PATH /var/www/Modules/Activities/resources/views/activities/_include-functions/function-highlight-search.blade.php ENDPATH**/ ?>