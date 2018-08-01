<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Evaluation;
use App\Module;
use App\EvaluationUser;
use App\AttachmentEvaluation;
use App\Course;
use App\Question;
use App\Option;
use App\CertificateTemplate;

class EvaluationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evaluations = Evaluation::all();
        return view('evaluations/list', compact('evaluations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (isset($_GET['module_id'])) {
            $module_id = $_GET['module_id'];
            $module = Module::find($module_id);
            if( $module != null){
                return view('evaluations/form', compact('module'));
            }
        }
        $modules = Module::all();
        return view('evaluations/form', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $evaluation = Evaluation::create($input);
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            AttachmentEvaluation::create(['attachment_id' => $attach_id, 'evaluation_id' => $evaluation->id]);
        }
        return redirect()->route("evaluations.show", $evaluation->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evaluation = Evaluation::find($id);
        if($evaluation == null) { return redirect('evaluations.index'); }
        if($evaluation->isDiplomaEvaluation()){
            $course = $evaluation->course;
        }else{
            $course = $evaluation->module->course;
        }
        $approved = EvaluationUser::where('evaluation_id', $id)->where('score', '>=', $course->minimum_score)->count();
        return view('evaluations/show',compact('evaluation', 'approved'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $evaluation = Evaluation::find($id);
        return view('evaluations/form',compact('evaluation'));
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
        $evaluation = Evaluation::find($id);
        if($evaluation == null){ return redirect()->route('evaluations.index'); }
        $evaluation->name = $request->name;
        $evaluation->description = $request->description;
        $evaluation->maximum_attempts = $request->maximum_attempts;
        $evaluation->type = $request->type;
        $evaluation->save();
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            $this->dropImgAttachments($evaluation);
            AttachmentEvaluation::create(['attachment_id' => $attach_id, 'evaluation_id' => $evaluation->id]);
        }
        return redirect()->route("evaluations.show", $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evaluation = Evaluation::find($id);
        // dd($evaluation);
        if($evaluation != null){
            $evaluation->delete();
        }
        return back();
    }

    public function dropImgAttachments($evaluation){
        $images = $evaluation->attachments->where('type', 'main_img');
        foreach($images as $image){
            $image->delete();
        }
    }

    public function emptyEvaluations(){
        $evaluations = Evaluation::all();
        return view('empty-evaluations', compact('evaluations'));
    }

    public function createFinalEvaluation($course_id){
        $course = Course::find($course_id);
        if($course == null){
            return back()->withErrors(['error' => 'Problemas al encontrar el curso']);
        }
        return view('evaluations.form-final', compact('course'));
    }

    public function showDiplomaEvaluation($course_id, $evaluation_id){
        $course = Course::find($course_id);
        if($course == null){
            return back()->withErrors(['error' => 'Problemas al encontrar el curso']);
        }
        $evaluation = Evaluation::find($evaluation_id);
        if($evaluation == null){
            return back()->withErrors(['error' => 'No se encontró la evaluación']);
        }
        return view('evaluations.show', compact('evaluation', 'course'));
    }

    public function editFinalEvaluation($course_id, $evaluation_id){
        $course = Course::find($course_id);
        if($course == null){
            return back()->withErrors(['error' => 'Problemas al encontrar el curso']);
        }
        $evaluation = Evaluation::find($evaluation_id);
        if($evaluation == null){
            return back()->withErrors(['error' => 'No se encontró la evaluación']);
        }
        return view('evaluations.form-final', compact('course', 'evaluation'));
    }

    public function storeFinalEvaluation(Request $request, $course_id){
        $input = $request->input();
        // dd($input);
        $evaluation = Evaluation::create($input);
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            AttachmentEvaluation::create(['attachment_id' => $attach_id, 'evaluation_id' => $evaluation->id]);
        }
        $evaluation->type = 's';
        $evaluation->save();
        // $course = Course::find($course_id);
        // if($course == null){
        //     return back()->withErrors(['error' => 'Problemas al encontrar el curso']);
        // }
        return redirect()->route("show.diploma.evaluation", [$course_id, $evaluation->id]);
    }

    public function updateFinalEvaluation(Request $request, $course_id, $id){
        $evaluation = Evaluation::find($id);
        if($evaluation == null){ return redirect()->route('evaluations.index'); }
        $evaluation->name = $request->name;
        $evaluation->description = $request->description;
        $evaluation->maximum_attempts = $request->maximum_attempts;
        $evaluation->save();
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            $this->dropImgAttachments($evaluation);
            AttachmentEvaluation::create(['attachment_id' => $attach_id, 'evaluation_id' => $evaluation->id]);
        }
        $course = Course::find($course_id);
        if($course == null){
            return back()->withErrors(['error' => 'Problemas al encontrar el curso']);
        }
        return redirect()->route("show.diploma.evaluation", [$course_id, $evaluation->id]);
        // return redirect()->route("evaluations.show", $id);
    }

    public function diplomaInsomnioTemplate(){
        if(CertificateTemplate::where('name', 'Diploma Insomnio')->count() == 0){
            // Link: https://lion.app.box.com/s/s1a5117fal90ay0tn9l116q1wcjhjtqs
            CertificateTemplate::firstOrCreate(['name' => 'Diploma Insomnio', 'view_name' => 'users_pages.certificates.insomnio-diploma']);
            // Module::create([])
            $evaluation = Evaluation::create([
                'name' => 'Examen diplomado',
                'type' => 's',
                'description' => 'EXAMEN MODULO DR. LAVALLE',
                'maximum_attempts' => 2,
                'course_id' => 2
                
            ]);
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Cuál estudio de los comentados avala las cifras diagnósticas para la clasificación de la diabetes.',
                'content' => 'Cuál estudio de los comentados avala las cifras diagnósticas para la clasificación de la diabetes.'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'DECODE',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Océano pacífico e índico',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Funagata',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Whitehall',
                'score' => 0
            ]);
    
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Las insulinas basales disminuyen los niveles de  _________, mientras que los agonistas de GLP-1 de acción rápida se dirigen al control de_________:',
                'content' => 'Las insulinas basales disminuyen los niveles de  _________, mientras que los agonistas de GLP-1 de acción rápida se dirigen al control de_________:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Glucosa posprandial / glucosa de ayuno',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Hemoglobina glucosilada/ glucosa de ayuno',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Glucosa de ayuno/ glucosa posprandial',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Ninguna de las anteriores',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Mencione el o los mecanismos por los que se produce hiperglucemia:',
                'content' => 'Mencione el o los mecanismos por los que se produce hiperglucemia:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Disminución de efecto incretínico',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Resistencia a insulina hepática',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Defecto en célula alfa',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Todas las anteriores',
                'score' => 1
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Mencione las terapias que impactan en la glucosa posprandial:',
                'content' => 'Mencione las terapias que impactan en la glucosa posprandial:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Insulina basal ',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Metformina',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Agonistas del receptor de GLP-1 de acción prolongada',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Agonistas del receptor de GLP-1 de acción corta ',
                'score' => 1
            ]);
    
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Mencione las terapias que impactan en la glucosa de ayuno:',
                'content' => 'Mencione las terapias que impactan en la glucosa de ayuno:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Inhibidores de alfa glucosidasa, sulfonilureas',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Insulina basal, metformina',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Metformina, insulinas de acción prandial',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Inhibidores de SGLT2, insulinas de acción rápida',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Es conveniente usar terapias __________ que actúen sobre glucosa de ayuno y posprandial para lograr las metas de control en los pacientes con diabetes mellitus.',
                'content' => 'Es conveniente usar terapias __________ que actúen sobre glucosa de ayuno y posprandial para lograr las metas de control en los pacientes con diabetes mellitus.'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Únicas',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Combinadas',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Alternativas',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Indeterminadas',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Cuando se ha logrado el control de la glucosa de ayuno pero la hemoglobina glucosilada está fuera de meta, ¿a expensas de que factor ocurre este fenómeno?',
                'content' => 'Cuando se ha logrado el control de la glucosa de ayuno pero la hemoglobina glucosilada está fuera de meta, ¿a expensas de que factor ocurre este fenómeno?'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Glucosa en ayuno',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Niveles de insulina',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Glucosa posprandial',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Ninguna de las anteriores',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Que combinación es la más conveniente para pacientes con hiperglucemia en los que no deseamos una ganancia de peso:',
                'content' => 'Que combinación es la más conveniente para pacientes con hiperglucemia en los que no deseamos una ganancia de peso:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Insulina basal con agonistas GLP-1',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Insulina rápida e insulina basal',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Sulfonilureas con TZD',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Insulina premezclada',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Que combinación es la más conveniente para pacientes con hiperglucemia en los que no deseamos una ganancia de peso:',
                'content' => 'Que combinación es la más conveniente para pacientes con hiperglucemia en los que no deseamos una ganancia de peso:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Insulina basal con agonistas GLP-1',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Insulina rápida e insulina basal',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Sulfonilureas con TZD',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Insulina premezclada ',
                'score' => 0
            ]);
    
            
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'La variabilidad glucémica se define como cualquier fluctuación en los niveles de glucosa que ocurren a partir de picos  ____________ y depresiones _____________.',
                'content' => 'La variabilidad glucémica se define como cualquier fluctuación en los niveles de glucosa que ocurren a partir de picos  ____________ y depresiones _____________.'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Oxidativos / Fluctuantes',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Hipoglucémicos / celulares',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Hiperglucémicos / prolongadas',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Hiperglucémicos / hipoglucémicas',
                'score' => 1
            ]);
    
    
    
    
            // $evaluation = Evaluation::create([
            //     'name' => 'EXAMEN MODULO DR. GUILLERMO GONZÁLEZ GÁLVEZ',
            //     'type' => 's',
                
            //     'maximum_attempts' => 2
                
                
            // ]);
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Mencione la ventaja de utilizar la combinación de insulina basal con un agonista de receptor GLP-1',
                'content' => 'Mencione la ventaja de utilizar la combinación de insulina basal con un agonista de receptor GLP-1'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Control de glucosa posprandial y de glucosa plasmática en ayuno',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Bajo riesgo de hipoglucemia',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Alcanzar metas de hemoglobina glucosilada',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Todas las anteriores',
                'score' => 1
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => '¿Qué porcentaje de pacientes alcanzan metas de hemoglobina glucosilada con la combinación de insulina basal con un agonista de receptor GLP-1 después de falla a medicamentos orales (LixiLan-O)?',
                'content' => '¿Qué porcentaje de pacientes alcanzan metas de hemoglobina glucosilada con la combinación de insulina basal con un agonista de receptor GLP-1 después de falla a medicamentos orales (LixiLan-O)?'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '15 - 25%',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '30 - 40%',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '50 - 60%',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '70 – 80%',
                'score' => 1
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Mencione que pacientes son candidatos para utilizar la combinación de Lixisenatida con insulina glargina:',
                'content' => 'Mencione que pacientes son candidatos para utilizar la combinación de Lixisenatida con insulina glargina:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Pacientes con Diabetes Mellitus 1, no tratados con insulina.',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Pacientes con Diabetes Mellitus 2, no controlados con medicamentos orales o no controlados con insulina basal en combinación con ADOs.',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Pacientes con Diabetes Mellitus 2, con niveles de hemoglobina glucosilada <7%.',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'B y C son correctas.',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'La titulación de insulina basal se realiza con base en:',
                'content' => 'La titulación de insulina basal se realiza con base en:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Glucosa en ayuno',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Glucosa posprandial',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Hemoglobina glucosilada',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Todas las anteriores',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => '¿Qué porcentaje de pacientes alcanza una HbA1c menor a 7% sin hipoglucemia documentada en el estudio LixiLan-O?',
                'content' => '¿Qué porcentaje de pacientes alcanza una HbA1c menor a 7% sin hipoglucemia documentada en el estudio LixiLan-O?'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '25%',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '34%',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '32%',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '45%',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Qué porcentaje de pacientes alcanza una HbA1c menor a 7% sin aumento de peso:',
                'content' => 'Qué porcentaje de pacientes alcanza una HbA1c menor a 7% sin aumento de peso:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '18%',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '32%',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '43%',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '56%',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'La combinación de __________ y _________ provocó un control glucémico más temprano en comparación con la monoterapia.',
                'content' => 'La combinación de __________ y _________ provocó un control glucémico más temprano en comparación con la monoterapia.'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Insulina glulisina/Insulina glargina',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Metformina/Sulfonilurea',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Insulina basal/Premezcla',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Insulina glargina/ Lixisenatida',
                'score' => 1
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Ventajas de utilizar un agonista de GLP-1 en combinación con  insulina basal:',
                'content' => 'Ventajas de utilizar un agonista de GLP-1 en combinación con  insulina basal:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Neutraliza la ganancia de peso',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Dificultad para alcanzar metas de HbA1c',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Efecto antagónico al combinarlo con insulina basal',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Favorece la ganancia de peso',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'En el estudio LixiLan-L la introducción de iGlarLixi (±metformina) permitió lo siguiente: ',
                'content' => 'En el estudio LixiLan-L la introducción de iGlarLixi (±metformina) permitió lo siguiente: '
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Un mayor porcentaje (55%) de pacientes alcanzaron la meta de control glucémico <7% con una diminución del peso corporal (delta= -1.4Kg) y mismo riesgo de hipoglucemia que la insulina basal sola. ',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Solo un tercio de los pacientes alcanzaron metas de control glucémico, sin disminución de peso corporal y aumento el riesgo de hipoglucemia.',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Un 24% de los pacientes alcanzaron la meta de control glucémico <7%, con disminución del riesgo de hipoglucemia, con aumento de peso corporal (delta_+0.3Kg).',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'A y B son correctas',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Dentro de que categoría terapéutica encontramos a Lixisenatida:',
                'content' => 'Dentro de que categoría terapéutica encontramos a Lixisenatida:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Biguanida',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Sulfonilurea',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Agonista de receptor GLP-1',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Inhibidor del receptor GLP-1',
                'score' => 0
            ]);
    
    
    
    
            // $evaluation = Evaluation::create([
            //     'name' => 'EXAMEN MODULO DRA. ROSARIO ARECHAVALETA GRANELL',
            //     'type' => 's',
            //     'maximum_attempts' => 2
            // ]);
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Cuál es la definición de glucotoxicidad:',
                'content' => 'Cuál es la definición de glucotoxicidad:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Efectos adversos de la exposición aguda de glucosa en las células Beta pancreáticas.',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Proceso catabólico que hace referencia a la degradación de glucógeno a glucosa o glucosa 6-fosfato.',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Rol patogenético que tiene la hiperglucemia sobre múltiples órganos y sistemas susceptibles de ser dañados por la glucosa elevada.',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Proceso metabólico que convierte dos moléculas de piruvato en una de glucosa a través de 11 reacciones.',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Cuáles son las fases de secreción de insulina',
                'content' => 'Cuáles son las fases de secreción de insulina'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Fase aguda/ Fase crónica',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Primera Fase/Segunda Fase',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'A y B son correctas',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Fase anabólica/Fase catabólica',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'La __________ de la glucosa promueve la generación de superóxido y contribuye a la glucotoxicidad.',
                'content' => 'La __________ de la glucosa promueve la generación de superóxido y contribuye a la glucotoxicidad.'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Oxidación',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Degradación',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Almacenamiento',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Síntesis',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'El efecto tóxico de la glucosa tiene impacto en:',
                'content' => 'El efecto tóxico de la glucosa tiene impacto en:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Pérdida de la función de células Beta',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Desdiferenciación de la célula Beta',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Complicaciones crónicas de la diabetes',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Todas las anteriores',
                'score' => 1
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'La memoria metabólica se define como: El efecto ___________ de la hiperglucemia y las complicaciones microvasculares y macrovasculares que ya no se ___________aunque se controle la glucosa.',
                'content' => 'La memoria metabólica se define como: El efecto ___________ de la hiperglucemia y las complicaciones microvasculares y macrovasculares que ya no se ___________aunque se controle la glucosa.'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Pasajero/observa',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Duradero/revierten',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Inmediato/percibe',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Constante/reconoce',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Cuáles son los mecanismos que van generando complicaciones por la hiperglucemia sostenida:',
                'content' => 'Cuáles son los mecanismos que van generando complicaciones por la hiperglucemia sostenida:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Cambios repetidos agudos en el metabolismo celular',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Cambios acumulados en macromoléculas estables',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Daño en los órganos susceptibles a diabetes',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Todas las anteriores',
                'score' => 1
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Los siguientes son mecanismos fisiopatogénicos de la hiperglucemia crónica:',
                'content' => 'Los siguientes son mecanismos fisiopatogénicos de la hiperglucemia crónica:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Protección cardiovascular',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Cambios epigenéticos',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Alquilación de proteínas',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Inflamación aguda',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'La clave del tratamiento de la hiperglucemia crónica es:',
                'content' => 'La clave del tratamiento de la hiperglucemia crónica es:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Intervención temprana e intensificada',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Propiciar la memoria metabólica inapropiada',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Lograr HbA1c >10%',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'B y C son correctas',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Que órganos se ven más afectados por la glucotóxicidad:',
                'content' => 'Que órganos se ven más afectados por la glucotóxicidad:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Riñones, ojos, corazón',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Nervios',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Vasos Sanguíneos',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Todas las anteriores',
                'score' => 1
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'A la activación del estrés oxidativo, el aumento en las vías de hexosaminas, cambios en la expresión de los genes, son parte de:',
                'content' => 'A la activación del estrés oxidativo, el aumento en las vías de hexosaminas, cambios en la expresión de los genes, son parte de:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Mecanismos de toxicidad de la glucosa',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Mecanismos de autorregulación celular',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Mecanismos de apoptosis celular',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Mecanismos de reserva pancreática',
                'score' => 0
            ]);
    
            
    
    
    
            // $evaluation = Evaluation::create([
            //     'name' => 'EXAMEN MODULO DR. RAFAEL VIOLANTE',
            //     'type' => 's',
            //     'maximum_attempts' => 2
            // ]);
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Uno de los retos de la diabetes mellitus en México es que en la actualidad los pacientes que se encuentran en control metabólico son solo el:',
                'content' => 'Uno de los retos de la diabetes mellitus en México es que en la actualidad los pacientes que se encuentran en control metabólico son solo el:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '25% de los pacientes',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '57% de los pacientes',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '34% de los pacientes',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '12% de los pacientes',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => '¿Cuál es el motivo por el cual el paciente no se controla?',
                'content' => '¿Cuál es el motivo por el cual el paciente no se controla?'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Comprensión de la enfermedad',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Estado socioeconómico del paciente',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Inercia clínica',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Todas las anteriores',
                'score' => 1
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'El esquema __________ propicia la inercia clínica y evita que el paciente llegue a metas de control rápidamente.',
                'content' => 'El esquema __________ propicia la inercia clínica y evita que el paciente llegue a metas de control rápidamente.'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Combinado temprano',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Tradicional',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Intensificado',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Concomitante',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Que elementos componen la glucotriada:',
                'content' => 'Que elementos componen la glucotriada:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'HbA1c ',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Glucosa en ayuno',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Glucosa porprandial',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Todas las anteriores',
                'score' => 1
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Es necesario enfocarse en la _______ y __________ para proporcionar un control glucémico general en un amplio rango de niveles de HbA1c',
                'content' => 'Es necesario enfocarse en la _______ y __________ para proporcionar un control glucémico general en un amplio rango de niveles de HbA1c'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Glucosa en ayuno/Glucosa posprandial',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Glucosa posprandial/Perímetro abdominal',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Tensión arterial/Glucosa en ayuno',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Glucosa en ayuno/índice tobillo-brazo',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Puede definirse como cualquier fluctuación en los niveles de glucosa y los cambios celulares dañinos que ocurren a partir de picos hiperglucémicos y depresiones hipoglucémicas:',
                'content' => 'Puede definirse como cualquier fluctuación en los niveles de glucosa y los cambios celulares dañinos que ocurren a partir de picos hiperglucémicos y depresiones hipoglucémicas:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Memoria metabólica',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Variabilidad glucémica',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Glucotoxicidad',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Índice glucémico',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Si el paciente se encuentra con insulina basal y la HbA1c no se encuentra en metas de control, se sugiere inicialmente:',
                'content' => 'Si el paciente se encuentra con insulina basal y la HbA1c no se encuentra en metas de control, se sugiere inicialmente:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Añadir otro agente no insulínico',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Pasar a esquema basal-bolo',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Añadir 1 análogo del receptor GLP-1',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Cambiar a insulina premezclada 3 veces al día (desayuno, comida y cena)',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Según estudios oficiales, ¿en la actualidad cuantos pacientes se encuentran en metas de control metabólico?',
                'content' => 'Según estudios oficiales, ¿en la actualidad cuantos pacientes se encuentran en metas de control metabólico?'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '2 de cada 10 pacientes',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '1 de cada 3 pacientes',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '1 de cada 4 pacientes',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '2 de cada 4 pacientes',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Cuando se diagnostica diabetes mellitus aproximadamente ¿qué cantidad de células beta se ha perdido?',
                'content' => 'Cuando se diagnostica diabetes mellitus aproximadamente ¿qué cantidad de células beta se ha perdido?'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '30%',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '50%',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '40%',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '20%',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'En el estudio de registro de España el______ de pacientes que están bajo tratamiento con insulina basal tienen valores de glucosa en ayuno superiores a 130 mg/dL y HbA1c >7%',
                'content' => 'En el estudio de registro de España el______ de pacientes que están bajo tratamiento con insulina basal tienen valores de glucosa en ayuno superiores a 130 mg/dL y HbA1c >7%'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '51.3%',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '7.4%',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '17.8',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '23.5%',
                'score' => 0
            ]);
    
        
    
    
    
            // $evaluation = Evaluation::create([
            //     'name' => 'PREGUNTAS CASO CLINICO DR. GUILLERMO GONZALEZ',
            //     'type' => 's',
            //     'maximum_attempts' => 2
            // ]);
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Una vez que un paciente tiene una dosis adecuada de insulina basal pero no llega a meta de control de HbA1c, ¿Cuál sería el mejor tratamiento a adicionar a la terapéutica?',
                'content' => 'Una vez que un paciente tiene una dosis adecuada de insulina basal pero no llega a meta de control de HbA1c, ¿Cuál sería el mejor tratamiento a adicionar a la terapéutica?'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Añadir un inhibidor de la DPP-4',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Añadir un inhibidor de SGLT-2',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Añadir un agonista del receptor de GLP-1',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Incrementar la dosis de insulina basal',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Es una de las ventajas de añadir un agonista del receptor de GLP-1 cuando no se alcanza la meta de control aun cuando se ha tratado a los pacientes con insulina basal:',
                'content' => 'Es una de las ventajas de añadir un agonista del receptor de GLP-1 cuando no se alcanza la meta de control aun cuando se ha tratado a los pacientes con insulina basal:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Disminución del peso corporal',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Menor incidencia de eventos CV',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Misma eficacia en reducción de HbA1c',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Neutralidad en el peso corporal',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'La diferencia fundamental entre agregar insulina prandial o un agonista del receptor de GLP-1 en pacientes que no logran la meta de control glucémico radica en:',
                'content' => 'La diferencia fundamental entre agregar insulina prandial o un agonista del receptor de GLP-1 en pacientes que no logran la meta de control glucémico radica en:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'La disminución de excursiones postprandiales',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'La mejoría del control glucémico en ayuno',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'La disminución del riesgo de hipoglucemia y neutralidad en el peso corporal',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'El control de la HbA1c',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => '¿Cuál es el efecto de la combinación de proporción fija entre insulina glargina 100U/mL y Lixisenatida?',
                'content' => '¿Cuál es el efecto de la combinación de proporción fija entre insulina glargina 100U/mL y Lixisenatida?'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Una mayor reducción en los niveles de HbA1c',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Una reducción del riesgo de hipoglucemia',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'El control total de la glucosa en ayuno',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => 'Mayor selectividad en la célula beta',
                'score' => 0
            ]);
    
            $question = Question::create([
                'evaluation_id' => $evaluation->id,
                'name' => 'Es el porcentaje de pacientes que alcanzan la meta de control de HbA1c sin aumento en el riesgo de hipoglucemia y sin ganancia de peso con la utilización de la combinación de proporción fija de insulina glargina con Lixisenatida:',
                'content' => 'Es el porcentaje de pacientes que alcanzan la meta de control de HbA1c sin aumento en el riesgo de hipoglucemia y sin ganancia de peso con la utilización de la combinación de proporción fija de insulina glargina con Lixisenatida:'
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '20%',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '35%',
                'score' => 1
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '50%',
                'score' => 0
            ]);
            Option::create([
                'question_id' => $question->id,
                'content' => '55%',
                'score' => 0
            ]);
    
        }
        return redirect('/');
    }


}
