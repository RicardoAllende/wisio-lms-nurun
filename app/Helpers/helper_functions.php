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

/*

*/
function getSearchFields($availableFields, $string) {
    $fields = string_to_array($string);
    // if($request->filled('fields')){
        // echo "Existe el campo fields";
        // $fields = $request->fields;
        // dd($fields);
        // $temporalUser = new Course;
        // $availableFields = collect($temporalUser->getFillable());
        $availableFields = collect($availableFields);
        // $availableFields = $availableFields->concat($temporalUser->getFillable());
        // dd($availableFields);
        // $temporalUser = null; // Limpiando el espacio
        $selection = $availableFields->intersect($fields);
        // $selection = array_values($selection);
        $selection = $selection->toArray();
        $selection = array_values($selection);
        return $selection;
}
// getSearchFields(['firstname', 'lastname', 'e'], '[e,otra cosa, something, firstname]');