<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Module;

class ModulesController extends Controller
{
    public function getResources(Request $request){
        $module = Module::find($request->idModule);

        $resources = $module->resources;
        foreach ($resources as $resource) {
          $resource['url']=$resource->url();
          $resource['name_module'] = $module->name;
          $resource['references_module'] = $module->references;
        }
        //dd($resources);
        return $resources;
    }
}
