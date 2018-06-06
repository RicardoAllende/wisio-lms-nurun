<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ascription;
use App\AscriptionAttachment;
use App\Role;
use App\User;

class AscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ascriptions = Ascription::all();
        return view('ascriptions/list', ['ascriptions'=>$ascriptions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ascriptions/form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['name', 'description', 'slug']);
        $name = $request->name;
        $description = $request->description;
        $slug = str_slug($request->slug);
        if (Ascription::whereSlug($slug)->count() > 0) { // If slug exists
            return back()->withErrors(['error' => 'El slug ya existe']);
        }
        $ascription = Ascription::firstOrCreate($input);
        $ascription->slug = str_slug($ascription->slug);
        $ascription->save();
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            AscriptionAttachment::create(['attachment_id' => $attach_id, 'ascription_id' => $ascription->id]);
        }
        if($request->filled('calendar')){
            $attach_id = $request->input('calendar');
            AscriptionAttachment::create(['attachment_id' => $attach_id, 'ascription_id' => $ascription->id]);
        }
        return redirect()->route('ascriptions.show', $ascription->id); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ascription = Ascription::find($id);
        if($ascription != null){
            return view('ascriptions/show', ['ascription' => $ascription]);
            // return "Mostrando la adscripción número {$id}";
        }else{
            return redirect()->route('ascriptions.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ascription = Ascription::find($id);
        if($ascription != null){
            return view('ascriptions/form', compact('ascription'));
        }else{
            return redirect()->route('ascriptions.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ascription = Ascription::find($id);
        if($ascription != null){
            $ascription->name = $request->input('name');
            $ascription->description = $request->input('description');
            $slug = str_slug($request->slug);
            if($slug != $ascription->slug){
                if (Ascription::whereSlug($slug)->count() > 0) { // If slug exists
                    return back()->withErrors(['error' => 'El slug ya existe']);
                }
            }
            $ascription->slug = $slug;
            $ascription->is_pharmacy = $request->is_pharmacy;
            $ascription->has_constancy = $request->has_constancy;
            $ascription->save();
            if($request->filled('attachment')){
                $attach_id = $request->input('attachment');
                $this->dropImgAttachments($ascription);
                AscriptionAttachment::create(['attachment_id' => $attach_id, 'ascription_id' => $ascription->id]);
            }
            if($request->filled('calendar')){
                $attach_id = $request->calendar;
                $this->dropPreviousCalendars($ascription);
                AscriptionAttachment::create(['attachment_id' => $attach_id, 'ascription_id' => $ascription->id]);
            }
            $ascription = Ascription::find($ascription->id);
            return view('ascriptions/show', compact('ascription'));
        }else{
            return redirect()->route('ascriptions.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ascription = Ascription::find($id);
        if($ascription != null){
            $ascription->delete();
        }
        return redirect()->route('ascriptions.index');
    }

    public function dropImgAttachments($ascription){
        $images = $ascription->attachments->where('type', config('constants.attachments.main_img'));
        foreach($images as $image){
            $image->delete();
        }
    }

    public function dropPreviousCalendars($ascription){
        $calendars = $ascription->attachments->where('type', config('constants.attachments.calendar'));
        foreach ($calendars as $calendar) {
            $calendar->delete();
        }
    }

    public function disableAscription($ascription_id){
        $ascription = Ascription::find($ascription_id);
        if($ascription != null) {
            $ascription->enabled = 0;
            $ascription->save();
        }
        return back();
    }

    public function enableAscription($ascription_id){
        $ascription = Ascription::find($ascription_id);
        if($ascription != null) {
            $ascription->enabled = 1;
            $ascription->save();
        }
        return back();
    }

    public function showReportAllAscriptions(){
        $ascriptions = Ascription::all();
        return view('ascriptions/report-all', compact('ascriptions'));
    }

    public function showReport($ascription_id){
        $ascription = Ascription::find($ascription_id);
        if($ascription == null) { return redirect()->route('list.ascriptions.report'); }
        $users = $ascription->users;
        return view('ascriptions/report', compact('ascription', 'users'));
    }

    public function listDiplomados(){
        $ascriptions = Ascription::where('has_constancy', 1)->get(); // Diplomados
        return view('diplomados/list', compact('ascriptions'));
    }

    public function listUsersForDiplomado($ascription_id){
        $ascription = Ascription::find($ascription_id);
        if($ascription == null){ return redirect()->route('list.diplomados'); }
        $doctorRole = Role::where('name', config('constants.roles.doctor'))->pluck('id');
        $users = User::whereIn('role_id', $doctorRole)->get();
        return view('diplomados/list-users-to-enrol', compact('users', 'ascription'));
    }

}
