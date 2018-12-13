<?php
function string_to_array($fields){
    if($fields == ''){
        return [];
    }
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
    return $selection;
}

function isPositiveNumber($number, $default_number) {
    if(is_numeric($number)){
        if($number > 0){
            return $number;
        }
    }
    return $default_number;
}

// function readConditions(){
//     $conditions = "firstname=ricardo&&lastname=allende||id=3";
//     $next = false;
//     $result = [];
//     if($conditions == ''){
//         return $result;
//     }
//     do{
//         $position = 0;
//         $orPosition = strpos('||', $conditions);
//         if( $orPosition !== false ) {
//             $or = true;
//         }
//         $andPosition = strpos('&&', $conditions);
//         if( $andPosition !== false ) {
//             $and = true;
//             if($orPosition){
//                 if( $andPosition > $orPosition ) { 
//                     $position = $orPosition;
//                 } else {
//                     $position == $andPosition;
//                 }
//             }
//         }
//         if($or || $and){
//             $currrentCondition = 
//             array_push($result, $currentContidion);
//             var_dump(substr($conditions, 0, $position ));
//         }else { $or = $and = false; }
//     }while($or || $and);
//     return $conditions;
// }

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
    return (intval($offset / $limit) + 1);
}

function buildQuery($eloquentModel, $getParameters, $resourceName) {
    $orderBy = false;
    $temp = new $eloquentModel;
    $fillable = $temp->getFillable();
    $temp = null;
    $totalElements = $eloquentModel::count();

    $paginationParameters = getPaginationParameters($getParameters, $totalElements);

    if($paginationParameters === false){
        return 0;
    }    
    if($paginationParameters['page'] > $paginationParameters['pages']){
        return $paginationParameters['page'];
    }
    
    if(array_key_exists('select', $getParameters)){
        $selection = getSearchFields($fillable, $getParameters['select']);
    }else{
        $selection = $fillable;
    }
    
    $eloquentModel = $eloquentModel::select($selection)->offset($paginationParameters['offset'])->limit($paginationParameters['limit']);
    
    if(array_key_exists('where', $getParameters)){
        $eloquentModel = addWhereParameters($eloquentModel, $getParameters['where'], $fillable);
    }
    
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

    $page = 1;
    if(array_key_exists('page', $paginationParameters)){
        $page = $paginationParameters['page'];
        if($page == 0){
            return false;
        }
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

function addWhereParameters($eloquentModel, $inputs, $availableFields) {
    $conditions = string_to_array($inputs);
    $conditions = getConditions($conditions, $availableFields);
    $first = false;
    foreach($conditions as $condition){
        if(!$first){
            if(gettype($eloquentModel) == "string"){ // a php class
                $eloquentModel = $eloquentModel->where($condition[0], $condition[1], $condition[2]);
            } elseif (gettype($eloquentModel) == "object") {
                $eloquentModel = $eloquentModel::where($condition[0], $condition[1], $condition[2]);                
            }
            $first = true;
        }else{
            $eloquentModel = $eloquentModel->where($condition[0], $condition[1], $condition[2]);
        }
    }
    return $eloquentModel;
}

function getConditions($conditions, $fillable) {
    $operators = ['>', '<', '==', '=', '>=', '<=', 'like'];
    $results = [];
    foreach ($conditions as $stringCondition) {
        foreach($operators as $operator) {
            if(strpos($stringCondition, $operator) !== false){
                $condition = explode($operator, $stringCondition);
                if(count($condition) == 2){
                    if(in_array($condition[0], $fillable)){
                        if($operator == '==') $operator = "="; 
                        array_push($results, [$condition[0], $operator, $condition[1]]);
                    }
                }
                break;
            }
        }
    }
    return $results;
}

function insertElement($input, $model){
    try {
        $conditions = $model::getConditions();
        $errors = validateFields($model, $input);
        if(array_key_exists('email', $input) !== false){
            if(filter_var($input['email'], FILTER_VALIDATE_EMAIL) === false){
                array_push($errors, "email << {$input['email']} >> is not valid");
            }
        }
        if( ! empty($errors) ){
            $temp = new $model;
            $elementName = str_singular($temp->getTable());
            $temp = null;
            return [
                'status' => false,
                'message' => $elementName." cannot be created",
                'errors' => $errors
            ];
        }else{
            if(array_key_exists('password', $input)){
                $input['password'] = bcrypt($input['password']);
            }
            $newElement = $model::create($input);
            $elementName = str_singular($newElement->getTable());
            return [
                $elementName => $newElement,
                'message' => $elementName.' created successfully',
                'status' => true
            ];
        }
    } catch (\Throwable $th) {
        dd($th);
        return $th;
    }
}

function validateFields($model, $input){
    $conditions = $model::getConditions();
    $requiredAttributes = $conditions['required'];
    $uniqueAttributes = $conditions['unique'];
    $errors = [];
    if( ! in_array('id', $requiredAttributes) ) {
        array_push($uniqueAttributes, 'id');
    }
    if( in_array('slug', $requiredAttributes) ) {
        $requiredAttributes['slug'] = str_slug($requiredAttributes['slug']);
    }
    foreach ($uniqueAttributes as $attribute) {
        if(array_key_exists($attribute, $input)){
            if( empty($input[$attribute]) ){
                array_push($errors, "<< {$attribute} >> attribute cannot be null");
            }else{
                if($model::where($attribute, $input[$attribute])->count() > 0 ) {
                    array_push($errors, "Duplicate << {$input[$attribute]} >> for {$attribute}");
                }
            }
        }
    }
    foreach ($requiredAttributes as $attribute ) {
        if(array_key_exists($attribute, $input)){
            if( empty($input[$attribute]) ){
                array_push($errors, "<< {$attribute} >> attribute cannot be null");
            }
        }else{
            array_push($errors, "<< {$attribute} >> attribute cannot be null");
        }
    }
    return array_unique($errors);
}

function updateElements($model, $inputs, $scopes){
    $temp = new $model;
    $fillable = $temp->getFillable();
    $temp = null;
    if(array_key_exists($input['where'])){
        $model = addWhereParameters($model, $inputs['where'], $fillable);
    }
    $fieldsToUpdate = intersectArrayWithKeys($fillable, $inputs);
    $fieldsUpdated = $model->update($fieldsToUpdate);
    addWhereParameters($eloquentModel, $inputs, $availableFields);
}

function intersectArrayWithKeys($availableFields, $inputs) {
    // $fields = string_to_array($stringSelection);
    $result = [];
    foreach($availableFields as $field) {
        if(array_key_exists($field, $inputs)) {
            // array_push($result, $inputs[$field]);
            $result[$field] = $inputs[$field];
        }
    }
    return $result;
    $availableFields = collect($availableFields);
    $selection = $availableFields->intersect($fields);
    if($selection->isEmpty()){
        $selection = $availableFields;
    }
    $selection = $selection->toArray();
    $selection = array_values($selection);
    return $selection;
}
