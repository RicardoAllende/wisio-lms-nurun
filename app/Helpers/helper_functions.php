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

function getSearchFields($availableFields, $stringSelection) {
    $fields = string_to_array($stringSelection);
    $availableFields = collect($availableFields);
    $selection = $availableFields->intersect($fields);
    if($selection->isEmpty()){
        $selection = $availableFields;
    }
    $selection = $selection->toArray();
    $selection = array_values($selection);
    return($selection);
}

function isPositiveNumber($number, $default_number) {
    if(is_numeric($number)){
        if($number > 0){
            return $number;
        }
    }
    return $default_number;
}

function getDbLimit($parameter) {
    return isPositiveNumber($parameter, config('constants.default_elements_per_page'));
}

function getTotalPages($limit, $numRows) {
    if($limit > 0){
        return ceil($numRows / $limit);
    }
    return 0;
}

function addPaginationToModel($eloquentModel, $paginationParameters){
    if(gettype($eloquentModel) == "object"){
        return $eloquentModel->offset($offset)->limit($limit);
    }else{
        return $eloquentModel::offset($offset)->limit($limit);
    }
}

function getPage($offset, $limit) {
    $offset--;
    return (intval($offset / $limit) + 1);
}

function buildQuery($eloquentModel, $getParameters, $resourceName) {
    $orderBy = false;
    $temp = new $eloquentModel;
    $fillable = $temp->getFillable();
    $temp = null;
    $totalElements = $eloquentModel::count();

    $paginationParameters = getPaginationParameters($getParameters, $totalElements);
    
    if($paginationParameters['page'] > $paginationParameters['pages']){
        return false;
    }

    if(array_key_exists('select', $getParameters)){
        $selection = getSearchFields($fillable, $getParameters['select']);
    }else{
        $selection = $fillable;
    }
    
    $eloquentModel = $eloquentModel::select($selection)->offset($paginationParameters['offset'])->limit($paginationParameters['limit']);

    if(array_key_exists('orderby', $getParameters)){
        $orderBy = in_array($getParameters['orderby'], $fillable);
        $orderByName = $getParameters['orderby'];
        $orderby = true; $orderbydesc = false;
    }

    if(array_key_exists('orderbydesc', $getParameters)){
        if(in_array($getParameters['orderbydesc'], $fillable)){
            $orderByName = $getParameters['orderbydesc'];
            $orderBy = true; $orderbydesc = true;
        }
    }

    if($orderBy){
        if($orderbydesc){
            $eloquentModel = $eloquentModel->orderByDesc($orderByName);
        }else{
            $eloquentModel = $eloquentModel->orderBy($orderByName);
        }
    }

    if(array_key_exists('where', $getParameters)){
        $eloquentModel = addWhereParameters($eloquentModel, $getParameters['where'], $fillable);
    }

    return [
        'pagination_parameters' => $paginationParameters,
        $resourceName => $eloquentModel->get()
    ];
}

function getPaginationParameters($paginationParameters, $num_rows){
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
        $offset = ($page - 1) * $limit;
    }
    $page = getPage($offset, $limit);
    $pages = getTotalPages($limit, $num_rows);
    return compact('limit', 'page', 'offset', 'page', 'pages', 'num_rows');
}

function addWhereParameters($eloquentModel, $inputs, $available) {
    $results = [];
    $parameters = array_keys($inputs);
    // var_dump($available);
    foreach ($parameters as $parameter) {
        // return $parameter;
        // var_dump($parameter);
        if(array_search($parameter, $available) !== false){
            // return "Encontrado";
            dd($inputs[$parameter]);
            array_push($results, $parameter);
        }
    }
    return $results;
}

function getCondition($string) {

}

function getOperator($string){
    // if()
}