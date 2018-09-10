<?php

namespace App\Http\Controllers\Users_Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ascription;
use App\Diploma;
use Illuminate\Support\Facades\Auth;
use App\DiplomaUser;

class DiplomasController extends Controller
{
    public function show($ascription_slug, $diploma_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        $diploma = Diploma::whereSlug($diploma_slug)->first();
        if($ascription == null || $diploma == null){
            return redirect('/');
        }
        if(Auth::check()){
            $user = Auth::user();
            if($user->diplomas->contains($diploma->id)){ // user is enrolled in course
                $enrollment = $user->diplomas->find($diploma->id);
                // dd($enrollment->evaluation);
                if($enrollment->pivot->status){ // User has the diploma evaluation finished
                    $finished = true;
                    $finalEvaluation = $diploma->evaluation;
                    if($user->hasAnotherAttemptInEvaluation($finalEvaluation->id)){
                        if( $user->scoreInEvaluation($finalEvaluation->id) >= $diploma->minimum_score ){
                            // dd('Con evaluación '.$user->scoreInEvaluation($finalEvaluation->id));
                            return view('users_pages.diplomas.show', compact('ascription', 'diploma', 'enrollment', 'finished'));
                        }else{
                            $chance = true;
                            return view('users_pages.diplomas.show', compact('ascription', 'diploma', 'enrollment', 'finished', 'chance'));
                        }
                    }else{
                        return view('users_pages.diplomas.show', compact('ascription', 'diploma', 'enrollment', 'finished'));
                    }
                }else{
                    $chance = true;
                    return view('users_pages.diplomas.show', compact('ascription', 'diploma', 'enrollment', 'chance'));
                }
                if($enrollment->hasDiplomaEvaluation()){
                    $chance = true;
                    return view('users_pages.diplomas.show', compact('ascription', 'diploma', 'enrollment', 'chance'));
                }
            }
            if( $diploma->verifyUser($user->id) ){
                $invitation = true;
                return view('users_pages.diplomas.show', compact('ascription', 'diploma', 'invitation'));
            }
            return view('users_pages.diplomas.show', compact('ascription', 'diploma'));
        }
        return view('users_pages.diplomas.show', compact('ascription', 'diploma'));
        dd($diploma);
    }

    public function showDiplomaResult(Request $request, $ascription_slug, $diploma_slug){
        dd($request->input());
    }

    public function enrolUserInDiplomado($ascription_slug, $diploma_slug){
        $ascription = Ascription::whereSlug($ascription_slug)->first();
        $diploma = Diploma::whereSlug($diploma_slug)->first();
        if($ascription == null || $diploma == null){
            return redirect('/');
        }
        $user = Auth::user();
        if(DiplomaUser::where('diploma_id', $diploma->id)->where('user_id', $user->id)->count() == 0){
            $user->diplomas()->attach($diploma->id);
        }
        return back();
    }

}
