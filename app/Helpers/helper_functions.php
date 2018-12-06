<?php
function string_to_array($fields){
    $fields = espace_string($fields);
    $fields = espace_string($fields);
    $fields = explode(',', $fields);
    return $fields;
}
function espace_string($string) {
    $string = str_replace(' ', '', $string);
    $string = str_replace('[', '', $string);
    $string = str_replace(']', '', $string);
    $string = str_replace('{', '', $string);
    $string = str_replace('}', '', $string);
    return $string;
}

function getSearchFields($availableFields, $string) {
    $fields = string_to_array($string);
    $availableFields = collect($availableFields);
    $selection = $availableFields->intersect($fields);
    $selection = $selection->toArray();
    $selection = array_values($selection);
    return $selection;
}
// getSearchFields(['firstname', 'lastname', 'e'], '[e,otra cosa, something, firstname]');