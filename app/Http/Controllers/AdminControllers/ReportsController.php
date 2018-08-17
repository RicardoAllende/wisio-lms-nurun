<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{

    public function reports(){
        return view('excel_reports.list');
    }

    public function reportInsomnioAcademia(){
        Excel::create('Insomnio_Academia_MC', function($excel) {

            $excel->sheet('Hoja1', function($sheet) {

                $result = DB::select("SELECT id, created_at, refered_code, firstname, lastname, gender, email, mobile_phone, professional_license, 
                (select name from specialties where id = users.specialty_id) as specialty, zip, city, address, 
                (select code from states where id = users.state_id) as state, 'INSOMNIO' AS course_name, 
                if( ( select count(*) from module_user where module_id = 3 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod1Progress,
                if( ( select count(*) from module_user where module_id = 1 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod2Progress,
                if( ( select count(*) from module_user where module_id = 2 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod3Progress,
                if( ( select count(*) from module_user where module_id = 4 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod4Progress,
                if( ( select count(*) from module_user where module_id = 141 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod5Progress,
                if( ( select count(*) from module_user where module_id = 5 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod6Progress,
                if( ( select count(*) from module_user where module_id = 13 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod7Progress,
                if( (select score from module_user where module_id = 3 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 3 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal1,
                if( (select score from module_user where module_id = 1 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 1 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal2,
                if( (select score from module_user where module_id = 2 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 2 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal3,
                if( (select score from module_user where module_id = 4 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 4 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal4,
                if( (select score from module_user where module_id = 141 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 141 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal5,
                if( (select score from module_user where module_id = 5 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 5 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal6,
                if( (select score from module_user where module_id = 13 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 13 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal7,

                if( (select score from course_user where course_id = 1 and user_id = users.id limit 1) is not null, (select score from course_user where course_id = 1 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as promedio,

                (select count(*) from evaluation_user where evaluation_id = 3 and user_id = users.id) as mod_1_tries,
                (select count(*) from evaluation_user where evaluation_id = 1 and user_id = users.id) as mod_2_tries,
                (select count(*) from evaluation_user where evaluation_id = 2 and user_id = users.id) as mod_3_tries,
                (select count(*) from evaluation_user where evaluation_id = 13 and user_id = users.id) as mod_4_tries,
                '1' as mod_5_tries,
                (select count(*) from evaluation_user where evaluation_id = 23 and user_id = users.id) as mod_6_tries,
                '1' as mod_7_tries
                FROM users where id in (select user_id from course_user where course_id = 1) and ascription_id = 1");
                
                $result = json_decode( json_encode($result), true);
                $sheet->fromArray($result);

            });
        })->export('xlsx');
        
    }

    public function reportDiabetesAcademia(){
        Excel::create('Diabetes_Academia_MC', function($excel) {

            $excel->sheet('Hoja1', function($sheet) {

                $result = DB::select("SELECT id, created_at, refered_code, firstname, lastname, gender, email, mobile_phone, professional_license, 
                (select name from specialties where id = users.specialty_id) as specialty, zip, city, address, 
                (select code from states where id = users.state_id) as state, 'DIABETES' AS course_name, 
                if( ( select count(*) from module_user where module_id = 6 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod1Progress,
                if( ( select count(*) from module_user where module_id = 7 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod2Progress,
                if( ( select count(*) from module_user where module_id = 12 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod3Progress,
                if( ( select count(*) from module_user where module_id = 14 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod4Progress,
                if( ( select count(*) from module_user where module_id = 15 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod5Progress,
                if( ( select count(*) from module_user where module_id = 16 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod6Progress,
                if( ( select count(*) from module_user where module_id = 17 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod7Progress,
                if( ( select count(*) from module_user where module_id = 18 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod8Progress,
                if( ( select count(*) from module_user where module_id = 19 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod9Progress,
                if( ( select count(*) from module_user where module_id = 20 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod10Progress,
                if( ( select count(*) from module_user where module_id = 8 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod11Progress,
                if( ( select count(*) from module_user where module_id = 11 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod12Progress,
                if( ( select count(*) from module_user where module_id = 9 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod13Progress,
                if( ( select count(*) from module_user where module_id = 10 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod14Progress,
                
                if( (select score from module_user where module_id = 6 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 6 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal1,
                if( (select score from module_user where module_id = 7 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 7 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal2,
                if( (select score from module_user where module_id = 12 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 12 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal3,
                if( (select score from module_user where module_id = 14 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 14 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal4,
                if( (select score from module_user where module_id = 15 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 15 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal5,
                if( (select score from module_user where module_id = 16 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 16 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal6,
                if( (select score from module_user where module_id = 17 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 17 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal7,
                if( (select score from module_user where module_id = 18 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 18 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal8,
                if( (select score from module_user where module_id = 19 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 19 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal9,
                if( (select score from module_user where module_id = 20 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 20 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal10,
                if( (select score from module_user where module_id = 8 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 8 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal11,
                if( (select score from module_user where module_id = 11 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 11 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal12,
                if( (select score from module_user where module_id = 9 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 9 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal13,
                if( (select score from module_user where module_id = 10 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 10 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal14,
                
                if( (select score from course_user where course_id = 2 and user_id = users.id limit 1) is not null, (select score from course_user where course_id = 2 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as promedio,

                (select count(*) from evaluation_user where evaluation_id = 7 and user_id = users.id) as mod_1_tries,
                (select count(*) from evaluation_user where evaluation_id = 6 and user_id = users.id) as mod_2_tries,
                (select count(*) from evaluation_user where evaluation_id = 11 and user_id = users.id) as mod_3_tries,
                (select count(*) from evaluation_user where evaluation_id = 16 and user_id = users.id) as mod_4_tries,
                (select count(*) from evaluation_user where evaluation_id = 18 and user_id = users.id) as mod_5_tries,
                (select count(*) from evaluation_user where evaluation_id = 20 and user_id = users.id) as mod_6_tries,
                (select count(*) from evaluation_user where evaluation_id = 22 and user_id = users.id) as mod_7_tries,
                (select count(*) from evaluation_user where evaluation_id = 25 and user_id = users.id) as mod_8_tries,
                (select count(*) from evaluation_user where evaluation_id = 27 and user_id = users.id) as mod_9_tries,
                (select count(*) from evaluation_user where evaluation_id = 29 and user_id = users.id) as mod_10_tries,
                (select count(*) from evaluation_user where evaluation_id = 30 and user_id = users.id) as mod_11_tries,
                '1' as mod_12_tries,
                (select count(*) from evaluation_user where evaluation_id = 31 and user_id = users.id) as mod_13_tries,
                (select count(*) from evaluation_user where evaluation_id = 32 and user_id = users.id) as mod_14_tries
                
                FROM users where id in (select user_id from course_user where course_id = 2) and ascription_id = 1");
                
                $result = json_decode( json_encode($result), true);
                $sheet->fromArray($result);

            });
        })->export('xlsx');
        
    }

    public function reportHipertensionAcademia(){
        Excel::create('Hipertension_Academia_MC', function($excel) {

            $excel->sheet('Hoja1', function($sheet) {

                $result = DB::select("SELECT id, created_at, refered_code, firstname, lastname, gender, email, mobile_phone, professional_license, 
                (select name from specialties where id = users.specialty_id) as specialty, zip, city, address, 
                (select code from states where id = users.state_id) as state, 'HIPERTENSION' AS course_name, 
                if( ( select count(*) from module_user where module_id = 21 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod1Progress,
                if( ( select count(*) from module_user where module_id = 22 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod2Progress,
                if( ( select count(*) from module_user where module_id = 23 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod3Progress,
                if( ( select count(*) from module_user where module_id = 27 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod4Progress,
                if( ( select count(*) from module_user where module_id = 24 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod5Progress,
                if( ( select count(*) from module_user where module_id = 25 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod6Progress,
                if( ( select count(*) from module_user where module_id = 26 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod7Progress,
                if( ( select count(*) from module_user where module_id = 28 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod8Progress,
                if( ( select count(*) from module_user where module_id = 29 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod9Progress,
                
                if( (select score from module_user where module_id = 21 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 21 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal1,
                if( (select score from module_user where module_id = 22 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 22 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal2,
                if( (select score from module_user where module_id = 23 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 23 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal3,
                if( (select score from module_user where module_id = 27 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 27 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal4,
                if( (select score from module_user where module_id = 24 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 24 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal5,
                if( (select score from module_user where module_id = 25 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 25 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal6,
                if( (select score from module_user where module_id = 26 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 26 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal7,
                if( (select score from module_user where module_id = 28 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 28 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal8,
                if( (select score from module_user where module_id = 29 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 29 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal9,
                
                if( (select score from course_user where course_id = 3 and user_id = users.id limit 1) is not null, (select score from course_user where course_id = 3 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as promedio,


                '1' as mod_1_tries,
                (select count(*) from evaluation_user where evaluation_id = 34 and user_id = users.id) as mod_2_tries,
                (select count(*) from evaluation_user where evaluation_id = 36 and user_id = users.id) as mod_3_tries,
                '1' as mod_4_tries,
                (select count(*) from evaluation_user where evaluation_id = 38 and user_id = users.id) as mod_5_tries,
                (select count(*) from evaluation_user where evaluation_id = 40 and user_id = users.id) as mod_6_tries,
                (select count(*) from evaluation_user where evaluation_id = 42 and user_id = users.id) as mod_7_tries,
                '1' as mod_8_tries,
                '1' as mod_9_tries
                FROM users where id in (select user_id from course_user where course_id = 3) and ascription_id = 1");
                
                $result = json_decode( json_encode($result), true);
                $sheet->fromArray($result);

            });
        })->export('xlsx');
        
    }

    public function reportDiabetesFarmacias(){
        Excel::create('Diabetes_Farmacias', function($excel) {

            $excel->sheet('Hoja1', function($sheet) {

                $result = DB::select("SELECT id, created_at, refered_code, firstname, lastname, gender, email, mobile_phone, professional_license, 
                (select name from specialties where id = users.specialty_id) as specialty, zip, city, address, 
                (select code from states where id = users.state_id) as state, 'DIABETES' AS course_name, 
                if( ( select count(*) from module_user where module_id = 6 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod1Progress,
                if( ( select count(*) from module_user where module_id = 7 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod2Progress,
                if( ( select count(*) from module_user where module_id = 12 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod3Progress,
                if( ( select count(*) from module_user where module_id = 14 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod4Progress,
                if( ( select count(*) from module_user where module_id = 15 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod5Progress,
                if( ( select count(*) from module_user where module_id = 16 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod6Progress,
                if( ( select count(*) from module_user where module_id = 17 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod7Progress,
                if( ( select count(*) from module_user where module_id = 18 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod8Progress,
                if( ( select count(*) from module_user where module_id = 19 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod9Progress,
                if( ( select count(*) from module_user where module_id = 20 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod10Progress,
                if( ( select count(*) from module_user where module_id = 8 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod11Progress,
                if( ( select count(*) from module_user where module_id = 11 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod12Progress,
                if( ( select count(*) from module_user where module_id = 9 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod13Progress,
                if( ( select count(*) from module_user where module_id = 10 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod14Progress,
                
                if( (select score from module_user where module_id = 6 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 6 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal1,
                if( (select score from module_user where module_id = 7 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 7 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal2,
                if( (select score from module_user where module_id = 12 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 12 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal3,
                if( (select score from module_user where module_id = 14 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 14 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal4,
                if( (select score from module_user where module_id = 15 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 15 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal5,
                if( (select score from module_user where module_id = 16 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 16 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal6,
                if( (select score from module_user where module_id = 17 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 17 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal7,
                if( (select score from module_user where module_id = 18 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 18 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal8,
                if( (select score from module_user where module_id = 19 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 19 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal9,
                if( (select score from module_user where module_id = 20 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 20 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal10,
                if( (select score from module_user where module_id = 8 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 8 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal11,
                if( (select score from module_user where module_id = 11 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 11 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal12,
                if( (select score from module_user where module_id = 9 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 9 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal13,
                if( (select score from module_user where module_id = 10 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 10 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal14,

                if( (select score from course_user where course_id = 2 and user_id = users.id limit 1) is not null, (select score from course_user where course_id = 2 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as promedio,
                
                (select count(*) from evaluation_user where evaluation_id = 7 and user_id = users.id) as mod_1_tries,
                (select count(*) from evaluation_user where evaluation_id = 6 and user_id = users.id) as mod_2_tries,
                (select count(*) from evaluation_user where evaluation_id = 11 and user_id = users.id) as mod_3_tries,
                (select count(*) from evaluation_user where evaluation_id = 16 and user_id = users.id) as mod_4_tries,
                (select count(*) from evaluation_user where evaluation_id = 18 and user_id = users.id) as mod_5_tries,
                (select count(*) from evaluation_user where evaluation_id = 20 and user_id = users.id) as mod_6_tries,
                (select count(*) from evaluation_user where evaluation_id = 22 and user_id = users.id) as mod_7_tries,
                (select count(*) from evaluation_user where evaluation_id = 25 and user_id = users.id) as mod_8_tries,
                (select count(*) from evaluation_user where evaluation_id = 27 and user_id = users.id) as mod_9_tries,
                (select count(*) from evaluation_user where evaluation_id = 29 and user_id = users.id) as mod_10_tries,
                (select count(*) from evaluation_user where evaluation_id = 30 and user_id = users.id) as mod_11_tries,
                '1' as mod_12_tries,
                (select count(*) from evaluation_user where evaluation_id = 31 and user_id = users.id) as mod_13_tries,
                (select count(*) from evaluation_user where evaluation_id = 32 and user_id = users.id) as mod_14_tries
                
                FROM users where id in (select user_id from course_user where course_id = 2) and ascription_id != 1");
                
                $result = json_decode( json_encode($result), true);
                $sheet->fromArray($result);

            });
        })->export('xlsx');
        
    }

    public function reportHipertensionFarmacias(){
        Excel::create('Hipertension_Farmacias', function($excel) {

            $excel->sheet('Hoja1', function($sheet) {

                $result = DB::select("SELECT id, created_at, refered_code, firstname, lastname, gender, email, mobile_phone, professional_license, 
                (select name from specialties where id = users.specialty_id) as specialty, zip, city, address, 
                (select code from states where id = users.state_id) as state, 'HIPERTENSION' AS course_name, 
                if( ( select count(*) from module_user where module_id = 21 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod1Progress,
                if( ( select count(*) from module_user where module_id = 22 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod2Progress,
                if( ( select count(*) from module_user where module_id = 23 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod3Progress,
                if( ( select count(*) from module_user where module_id = 27 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod4Progress,
                if( ( select count(*) from module_user where module_id = 24 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod5Progress,
                if( ( select count(*) from module_user where module_id = 25 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod6Progress,
                if( ( select count(*) from module_user where module_id = 26 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod7Progress,
                if( ( select count(*) from module_user where module_id = 28 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod8Progress,
                if( ( select count(*) from module_user where module_id = 29 AND user_id = users.id) > 0, 'TERMINADO' , 'NO TERMINADO' ) as mod9Progress,
                
                if( (select score from module_user where module_id = 21 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 21 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal1,
                if( (select score from module_user where module_id = 22 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 22 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal2,
                if( (select score from module_user where module_id = 23 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 23 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal3,
                if( (select score from module_user where module_id = 27 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 27 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal4,
                if( (select score from module_user where module_id = 24 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 24 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal5,
                if( (select score from module_user where module_id = 25 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 25 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal6,
                if( (select score from module_user where module_id = 26 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 26 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal7,
                if( (select score from module_user where module_id = 28 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 28 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal8,
                if( (select score from module_user where module_id = 29 and user_id = users.id limit 1) is not null, (select score from module_user where module_id = 29 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as cal9,
                
                if( (select score from course_user where course_id = 3 and user_id = users.id limit 1) is not null, (select score from course_user where course_id = 3 and user_id = users.id limit 1), 'SIN CALIFICACION' ) as promedio,                

                '1' as mod_1_tries,
                (select count(*) from evaluation_user where evaluation_id = 34 and user_id = users.id) as mod_2_tries,
                (select count(*) from evaluation_user where evaluation_id = 36 and user_id = users.id) as mod_3_tries,
                '1' as mod_4_tries,
                (select count(*) from evaluation_user where evaluation_id = 38 and user_id = users.id) as mod_5_tries,
                (select count(*) from evaluation_user where evaluation_id = 40 and user_id = users.id) as mod_6_tries,
                (select count(*) from evaluation_user where evaluation_id = 42 and user_id = users.id) as mod_7_tries,
                '1' as mod_8_tries,
                '1' as mod_9_tries
                FROM users where id in (select user_id from course_user where course_id = 3) and ascription_id != 1;");
                
                $result = json_decode( json_encode($result), true);
                $sheet->fromArray($result);

            });
        })->export('xlsx');
        
    }
}
