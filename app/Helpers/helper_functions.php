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

function getSearchFields($eloquentModel, $stringSelection) {
    $fields = string_to_array($stringSelection);
    $temp = new $eloquentModel;
    $availableFields = collect($temp->getFillable());
    $selection = $availableFields->intersect($fields);
    if($selection->isEmpty()){
        $selection = $availableFields;
    }
    $selection = $selection->toArray();
    $selection = array_values($selection);
    return $eloquentModel::select($selection);
}

function isPositiveNumber($number, $default_number) {
    if(is_numeric($number)){
        if($number > 0){
            return $number;
        }
    }
    return $default_number;
}

function addPaginationToModel($eloquentModel, $paginationParameters){
    $limit = config('constants.default_elements_per_page');
    if(array_key_exists('limit', $paginationParameters)){
        $limit = isPositiveNumber($paginationParameters['limit'], $limit);
    }

    $page = 0;
    if(array_key_exists('page', $paginationParameters)){
        $page = isPositiveNumber($paginationParameters['page'], $page);
    }

    $offset = 0;
    if(array_key_exists('offset', $paginationParameters)){
        $offset = isPositiveNumber($paginationParameters['offset'], $offset);
    }

    if($offset == 0){
        $offset = $page * $limit;
    }
    // return compact('offset', 'limit');
    if(gettype($eloquentModel) == "object"){
        return $eloquentModel->offset($offset)->limit($limit);
    }else{
        return $eloquentModel::offset($offset)->limit($limit);
    }
}
// getSearchFields(['firstname', 'lastname', 'e'], '[e,otra cosa, something, firstname]');