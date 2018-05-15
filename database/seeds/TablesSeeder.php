<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\Course;
use App\CustomField;
use App\CustomFieldUser;
use App\Tag;
use App\CourseTag;
use App\Module;
use App\Attachment;
use App\Resource;
use App\ModuleResource;
use App\Evaluation;
use App\Question;
use App\Option;
use App\RoleUser;
use App\Ascription;
use App\AscriptionUser;
use App\Category;
use App\CategoryCourse;
use App\AscriptionCourse;
use App\EvaluationUser;
use App\CourseUser;
use App\RecommendedCourse;
use App\Expert;
use App\Specialty;
use App\ExpertSpecialty;
use App\ExpertModule;

class TablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // https://lion.app.box.com/s/h9eoa8837p01c8uenq66wgfrmg930lk3/file/285174501391
        $privateDoctor = Role::create(['name' => config('constants.roles.private_doctor'), 'description' => config('constants.roles.private_doctor')]);
        $publicDoctor = Role::create(['name' => config('constants.roles.public_doctor'), 'description' => config('constants.roles.public_doctor')]);
        $pharmacyDoctor = Role::create(['name' => config('constants.roles.pharmacy_doctor'), 'description' => config('constants.roles.pharmacy_doctor')]);
        $reporter = Role::create(['name' => config('constants.roles.reporter'), 'description' => config('constants.roles.reporter')]);
        $admin = Role::create(['name' => config('constants.roles.admin'), 'description' => config('constants.roles.admin')]);
        $tester = Role::create(['name' => config('constants.roles.tester'), 'description' => config('constants.roles.tester')]);
        $teacher = Role::create(['name' => config('constants.roles.teacher'), 'description' => config('constants.roles.teacher')]);

        $ascription = Ascription::create(['name' => 'Paec México', 'slug' => 'paec-mexico', 'description' => 'Sección principal']);
        $ascription2 = Ascription::create(['name' => 'Farmacia Benavides', 'slug' => 'benavides', 'description' => 'Sección para la farmacia benavides', 'is_pharmacy' => 1]);
        $ascription3 = Ascription::create(['name' => 'Farmacia del ahorro', 'slug' => 'del-ahorro', 'description' => 'Sección para la farmacia benavides', 'is_pharmacy' => 1]);
        $ascription4 = Ascription::create(['name' => 'Farmacia Femsa', 'slug' => 'femsa', 'description' => 'Sección para la farmacia benavides', 'is_pharmacy' => 1]);
        $ascription5 = Ascription::create(['name' => 'Farmacia San pablo', 'slug' => 'san-pablo', 'description' => 'Sección para la farmacia benavides', 'is_pharmacy' => 1]);
        $ascription6 = Ascription::create(['name' => 'Súper Farmacias', 'slug' => 'guadalajara', 'description' => 'Sección para la farmacia benavides', 'is_pharmacy' => 1]);
        $ascription7 = Ascription::create(['name' => 'Farmacia Nadro', 'slug' => 'nadro', 'description' => 'Sección para la farmacia benavides', 'is_pharmacy' => 1]);
        $category = Category::create(['name'=>'Sistema Nervioso Central', 'description' => 'Sistema Nervioso Central']);
        $category2 = Category::create(['name'=>'Endocrinología', 'description' => 'Sistema Nervioso Central']);
        $category3 = Category::create(['name'=>'Cardiología', 'description' => 'Sistema Nervioso Central']);
        $specialty1 = Specialty::create(['name' => 'Alergólogo']);
        $specialty2 = Specialty::create(['name' => 'Cardiólogo']);
        $specialty3 = Specialty::create(['name' => 'Cirujano plástico']);
        $course = Course::create(['name' => 'Insomnio', 'description' => 'Ejemplo de texto de descripción', 
            'start_date' => '2009-10-04', 'end_date'=>'2018-04-01', 'has_constancy' => 1]);
        $course2 = Course::create(['name' => 'Diabetes', 'description' => 'Ejemplo de texto de descripción', 
            'start_date' => '2009-10-04', 'end_date'=>'2018-04-01']);
        $course3 = Course::create(['name' => 'Hipertensión', 'description' => 'Ejemplo de texto de descripción', 
            'start_date' => '2009-10-04', 'end_date'=>'2018-04-01', 'has_constancy' => 1]);
        CategoryCourse::create(['category_id' => $category->id, 'course_id' => $course->id]);
        CategoryCourse::create(['category_id' => $category2->id, 'course_id' => $course2->id]);
        CategoryCourse::create(['category_id' => $category3->id, 'course_id' => $course3->id]);
        AscriptionCourse::create(['ascription_id' => $ascription->id, 'course_id' => $course->id]);
        AscriptionCourse::create(['ascription_id' => $ascription->id, 'course_id' => $course2->id]);
        AscriptionCourse::create(['ascription_id' => $ascription->id, 'course_id' => $course3->id]);
        AscriptionCourse::create(['ascription_id' => $ascription2->id, 'course_id' => $course2->id]);
        AscriptionCourse::create(['ascription_id' => $ascription2->id, 'course_id' => $course3->id]);
        $user1 = User::create(['email'=>'juan.huerta@subitus.com', 'password'=>config('constants.default_password'),
            'firstname'=>'Juan', 'lastname'=>'Huerta', 'birthday' => '2000/01/01', 'role_id' => $admin->id]);
        $user2 = User::create(['email'=>'miguel.villegas@subitus.com', 'password'=>config('constants.default_password'),
            'firstname'=>'Miguel', 'lastname'=>'Villegas', 'birthday' => '2000/01/01', 'role_id' => $admin->id]);
        $user3 = User::create(['email'=>'ricardo.allende@subitus.com', 'password'=>config('constants.default_password'),
            'firstname'=>'Ricardo', 'lastname'=>'Allende', 'birthday' => '2000/01/01', 'role_id' => $admin->id]);
        AscriptionUser::create(['ascription_id' => $ascription->id, 'user_id' => $user1->id]);
        AscriptionUser::create(['ascription_id' => $ascription->id, 'user_id' => $user2->id]);
        AscriptionUser::create(['ascription_id' => $ascription->id, 'user_id' => $user3->id]);
        $tag1 = Tag::create(['tag'=>'Sueño']);
        $tag2 = Tag::create(['tag'=>'Glándulas']);
        $tag3 = Tag::create(['tag'=>'Corazón']);
        
        $module1 = Module::create(['name' => 'Ajustando las necesidades del cliente', 'description' => 'Este curso ...', 'start_date' => '2000-01-01', 'end_date' => '2020-01-01', 'course_id' => $course->id]);
        $module2 = Module::create(['name' => 'Estadísticas y necesidades de los pacientes', 'description' => 'Este curso ...', 'start_date' => '2000-01-01', 'end_date' => '2020-01-01', 'course_id' => $course->id]);
        $module3 = Module::create(['name' => 'Caso clínico', 'description' => 'Este curso ...', 'start_date' => '2000-01-01', 'end_date' => '2020-01-01', 'course_id' => $course2->id]);
        $module4 = Module::create(['name' => 'Lección final', 'description' => 'Este curso ...', 'start_date' => '2000-01-01', 'end_date' => '2020-01-01', 'course_id' => $course2->id]);
        $module5 = Module::create(['name' => 'Introducción', 'description' => 'Este curso ...', 'start_date' => '2000-01-01', 'end_date' => '2020-01-01', 'course_id' => $course3->id]);
        $module6 = Module::create(['name' => 'Hipoglucemia en contexto', 'description' => 'Este curso ...', 'start_date' => '2000-01-01', 'end_date' => '2020-01-01', 'course_id' => $course3->id]);
        
        // Relations
            CourseTag::create(['tag_id'=> $tag1->id, 'course_id'=>$course->id]);
            CourseTag::create(['tag_id'=> $tag2->id, 'course_id'=>$course2->id]);
            CourseTag::create(['tag_id'=> $tag3->id, 'course_id'=>$course3->id]);
        
        // Evaluations
            $evaluation1 = Evaluation::create(['module_id' => $module1->id, 'name'=>'Arsenal terapéutico', 'type' => 'f']);
            $evaluation2 = Evaluation::create(['module_id' => $course->id, 'name'=>'Conociendo los diferentes tipos de insulina', 'type' => 'f']);
            $evaluation3 = Evaluation::create(['module_id' => $ascription->id, 'name'=>'Arsenal terapéutico', 'type' => 'f']);
            $evaluation4 = Evaluation::create(['module_id' => $module2->id, 'name'=>'Cómo favorecer el tratamiento de insulina', 'type' => 'f']);
            $evaluation5 = Evaluation::create(['module_id' => $course2->id, 'name'=>'Hipoglucemia', 'type' => 'f']);
            $evaluation6 = Evaluation::create(['module_id' => $module2->id, 'name'=>'Conociendo los diferentes tipos de insulina', 'type' => 'f']);
            $question1 =  Question::create(['evaluation_id' => 1, 'name'=>'Pregunta 1', 'content'=>'No siempre se programó en computadoras.']);
            $question2 =  Question::create(['evaluation_id' => 2, 'name'=>'Pregunta 2', 'content'=>'Windows está disponible sólo en 32 bits']);
            $question3 =  Question::create(['evaluation_id' => 1, 'name'=>'Pregunta 3', 'content' => '¿Cuántas horas tiene un día?']);
            $question4 =  Question::create(['evaluation_id' => 2, 'name'=>'Pregunta 4', 'content' => '¿Qué significa RGB?']);
            $question5 =  Question::create(['evaluation_id' => 1, 'name'=>'Pregunta 5', 'content'=>'El español proviene de México']);
            $question6 =  Question::create(['evaluation_id' => 2, 'name'=>'Pregunta 6', 'content'=>'Linux está disponible sólo en 32 bits']);
            $question7 =  Question::create(['evaluation_id' => 1, 'name'=>'Pregunta 7', 'content' => '¿Cuántas días tiene un año?']);
            $question8 =  Question::create(['evaluation_id' => 2, 'name'=>'Pregunta 8', 'content' => '¿Qué significa SMTP?']);
            Option::create(['question_id' => $question1->id, 'content' => 'Una opción adecuada', 'score' => 1]);
            Option::create(['question_id' => $question1->id, 'content' => 'Algo incorrecto', 'score' => 0]);
            Option::create(['question_id' => $question1->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
            Option::create(['question_id' => $question2->id, 'content' => 'Una opción adecuada', 'score' => 1]);
            Option::create(['question_id' => $question2->id, 'content' => 'Algo incorrecto', 'score' => 0]);
            Option::create(['question_id' => $question2->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
            Option::create(['question_id' => $question3->id, 'content' => 'Una opción adecuada', 'score' => 1]);
            Option::create(['question_id' => $question3->id, 'content' => 'Algo incorrecto', 'score' => 0]);
            Option::create(['question_id' => $question3->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
            Option::create(['question_id' => $question4->id, 'content' => 'Una opción adecuada', 'score' => 1]);
            Option::create(['question_id' => $question4->id, 'content' => 'Algo incorrecto', 'score' => 0]);
            Option::create(['question_id' => $question4->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
            Option::create(['question_id' => $question5->id, 'content' => 'Una opción adecuada', 'score' => 1]);
            Option::create(['question_id' => $question5->id, 'content' => 'Algo incorrecto', 'score' => 0]);
            Option::create(['question_id' => $question5->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
            Option::create(['question_id' => $question6->id, 'content' => 'Una opción adecuada', 'score' => 1]);
            Option::create(['question_id' => $question6->id, 'content' => 'Algo incorrecto', 'score' => 0]);
            Option::create(['question_id' => $question6->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
            Option::create(['question_id' => $question7->id, 'content' => 'Una opción adecuada', 'score' => 1]);
            Option::create(['question_id' => $question7->id, 'content' => 'Algo incorrecto', 'score' => 0]);
            Option::create(['question_id' => $question7->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
            Option::create(['question_id' => $question8->id, 'content' => 'Una opción adecuada', 'score' => 1]);
            Option::create(['question_id' => $question8->id, 'content' => 'Algo incorrecto', 'score' => 0]);
            Option::create(['question_id' => $question8->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);


        CourseUser::create(['user_id' => $user1->id, 'course_id' => $course->id]);
        CourseUser::create(['user_id' => $user1->id, 'course_id' => $course2->id]);
        CourseUser::create(['user_id' => $user1->id, 'course_id' => $course3->id]);
        CourseUser::create(['user_id' => $user2->id, 'course_id' => $course->id]);
        CourseUser::create(['user_id' => $user2->id, 'course_id' => $course2->id]);
        CourseUser::create(['user_id' => $user2->id, 'course_id' => $course3->id]);
        CourseUser::create(['user_id' => $user3->id, 'course_id' => $course->id]);
        CourseUser::create(['user_id' => $user3->id, 'course_id' => $course2->id]);
        CourseUser::create(['user_id' => $user2->id, 'course_id' => $course3->id]);

        EvaluationUser::create(['user_id' => $user1->id, 'evaluation_id' => $evaluation1->id, 
            'status' => config('constants.status.failed'), 'score' => 7.6]);
        EvaluationUser::create(['user_id' => $user1->id, 'evaluation_id' => $evaluation2->id, 
            'status' => config('constants.status.passed'), 'score' => 8.1]);
        EvaluationUser::create(['user_id' => $user1->id, 'evaluation_id' => $evaluation3->id, 
            'status' => config('constants.status.failed'), 'score' => 5.9]);
        EvaluationUser::create(['user_id' => $user1->id, 'evaluation_id' => $evaluation4->id, 
            'status' => config('constants.status.passed'), 'score' => 10]);
        
        EvaluationUser::create(['user_id' => $user2->id, 'evaluation_id' => $evaluation1->id, 
            'status' => config('constants.status.failed'), 'score' => 6.5]);
        EvaluationUser::create(['user_id' => $user2->id, 'evaluation_id' => $evaluation2->id, 
            'status' => config('constants.status.passed'), 'score' => 9]);
        EvaluationUser::create(['user_id' => $user3->id, 'evaluation_id' => $evaluation1->id, 
            'status' => config('constants.status.failed'), 'score' => 7.95]);
        EvaluationUser::create(['user_id' => $user3->id, 'evaluation_id' => $evaluation2->id, 
            'status' => config('constants.status.passed'), 'score' => 8]);

        RecommendedCourse::create(['course_id'=>$course->id, 'user_id'=>$user1->id]);
        RecommendedCourse::create(['course_id'=>$course->id, 'user_id'=>$user2->id]);
        RecommendedCourse::create(['course_id'=>$course->id, 'user_id'=>$user3->id]);
        $summary = "is a doctor with it all: he's successful, he's rich, extremely self centred and he has no problems.... until he is diagnosed with throat cancer. Now that he has seen medicine, hospitals, and doctors from a patient's perspective, he realises tha";
        $expert1 = Expert::create(['name' => 'Dr Ricardo Allende', 'summary' => $summary]);
        $expert2 = Expert::create(['name' => 'Dr Juan Huerta', 'summary' => $summary]);
        $expert3 = Expert::create(['name' => 'Dr Miguel Villegas', 'summary' => $summary]);
        ExpertSpecialty::create(['expert_id' => $expert1->id, 'specialty_id' => $specialty1->id]);
        ExpertSpecialty::create(['expert_id' => $expert1->id, 'specialty_id' => $specialty2->id]);
        ExpertSpecialty::create(['expert_id' => $expert1->id, 'specialty_id' => $specialty3->id]);

        ExpertModule::create(['expert_id' => $expert1->id, 'module_id' => $module1->id]);
        ExpertModule::create(['expert_id' => $expert1->id, 'module_id' => $module2->id]);
        ExpertModule::create(['expert_id' => $expert1->id, 'module_id' => $module3->id]);
        ExpertModule::create(['expert_id' => $expert1->id, 'module_id' => $module4->id]);

        $course->saveAdvanceForAllUsers();
        $course2->saveAdvanceForAllUsers();
        $course3->saveAdvanceForAllUsers();


        factory(User::class, 30)->create()->each(function ($u){
            $u->ascriptions()->attach(rand(1, 7));
            Course::find(1)->enrolUser($u->id);
        });

        factory(User::class, 30)->create()->each(function ($u){
            $u->ascriptions()->attach(rand(1, 7));
            Course::find(2)->enrolUser($u->id);
        });

        factory(User::class, 30)->create()->each(function ($u){
            $u->ascriptions()->attach(rand(1, 7));
            Course::find(3)->enrolUser($u->id);
        });

        // ExpertSpecialty::create(['expert_id' => $expert1->id, 'specialty_id' => 1]);
        // ExpertSpecialty::create(['expert_id' => $expert1->id, 'specialty_id' => 2]);
        // ExpertSpecialty::create(['expert_id' => $expert1->id, 'specialty_id' => 3]);
        
        
        // $attachment = Attachment::create(['name' => 'Archivo adjunto', 'type' => config('constants.attachments.manual')]);
        // $resource1 = Resource::create(['attachment_id'=>$attachment, 'type' => config('constants.resources.manual')]);
        // $resource2 = Resource::create(['attachment_id'=>$attachment, 'type' => config('constants.resources.manual')]);
        // $resource3 = Resource::create(['attachment_id'=>$attachment, 'type' => config('constants.resources.manual')]);
        // $resource4 = Resource::create(['attachment_id'=>$attachment, 'type' => config('constants.resources.manual')]);
        // use Illuminate\Support\Facades\DB;
        // $q3 = $q2->concat($q1)
        // DB::table('evaluation_user')->select(DB::raw('max(score) as score'))->where('user_id', 1)->groupBy('evaluation_id')->get()->avg('score')
        // select avg(score) from (select max(score) as score from evaluation_user where user_id = 1 group by evaluation_id) as t1;
        // select avg(score) from (select max(score) as score from evaluation_user where user_id = 1 AND evaluation_id IN (1,3,4) group by evaluation_id) as t1;

    }
}
