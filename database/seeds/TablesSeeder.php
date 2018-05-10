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
use App\CourseModule;
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
        $privateDoctor = Role::firstOrCreate(['name' => config('constants.roles.private_doctor'), 'description' => config('constants.roles.private_doctor')]);
        $publicDoctor = Role::firstOrCreate(['name' => config('constants.roles.public_doctor'), 'description' => config('constants.roles.public_doctor')]);
        $pharmacyDoctor = Role::firstOrCreate(['name' => config('constants.roles.pharmacy_doctor'), 'description' => config('constants.roles.pharmacy_doctor')]);
        $reporter = Role::firstOrCreate(['name' => config('constants.roles.reporter'), 'description' => config('constants.roles.reporter')]);
        $admin = Role::firstOrCreate(['name' => config('constants.roles.admin'), 'description' => config('constants.roles.admin')]);
        $tester = Role::firstOrCreate(['name' => config('constants.roles.tester'), 'description' => config('constants.roles.tester')]);
        $teacher = Role::firstOrCreate(['name' => config('constants.roles.teacher'), 'description' => config('constants.roles.teacher')]);

        $ascription = Ascription::firstOrCreate(['name' => 'Paec México', 'slug' => 'paec-mexico', 'description' => 'Sección principal']);
        $ascription2 = Ascription::firstOrCreate(['name' => 'Benavides', 'slug' => 'benavides', 'description' => 'Sección para la farmacia benavides', 'is_pharmacy' => 1]);
        $category = Category::firstOrCreate(['name'=>'Sistema Nervioso Central', 'description' => 'Sistema Nervioso Central']);
        $category2 = Category::firstOrCreate(['name'=>'Endocrinología', 'description' => 'Sistema Nervioso Central']);
        $category3 = Category::firstOrCreate(['name'=>'Cardiología', 'description' => 'Sistema Nervioso Central']);
        $course = Course::firstOrCreate(['name' => 'Insomnio', 'description' => 'Ejemplo de texto de descripción', 
            'start_date' => '2009-10-04', 'end_date'=>'2018-04-01', 'has_constancy' => 1]);
        $course2 = Course::firstOrCreate(['name' => 'Diabetes', 'description' => 'Ejemplo de texto de descripción', 
            'start_date' => '2009-10-04', 'end_date'=>'2018-04-01']);
        $course3 = Course::firstOrCreate(['name' => 'Hipertensión', 'description' => 'Ejemplo de texto de descripción', 
            'start_date' => '2009-10-04', 'end_date'=>'2018-04-01', 'has_constancy' => 1]);
        CategoryCourse::firstOrCreate(['category_id' => $category->id, 'course_id' => $course->id]);
        CategoryCourse::firstOrCreate(['category_id' => $category2->id, 'course_id' => $course2->id]);
        CategoryCourse::firstOrCreate(['category_id' => $category3->id, 'course_id' => $course3->id]);
        AscriptionCourse::firstOrCreate(['ascription_id' => $ascription->id, 'course_id' => $course->id]);
        AscriptionCourse::firstOrCreate(['ascription_id' => $ascription->id, 'course_id' => $course2->id]);
        AscriptionCourse::firstOrCreate(['ascription_id' => $ascription->id, 'course_id' => $course3->id]);
        AscriptionCourse::firstOrCreate(['ascription_id' => $ascription2->id, 'course_id' => $course2->id]);
        AscriptionCourse::firstOrCreate(['ascription_id' => $ascription2->id, 'course_id' => $course3->id]);
        $user1 = User::firstOrCreate(['email'=>'juan.huerta@subitus.com', 'password'=>config('constants.default_password'),
            'firstname'=>'Juan', 'lastname'=>'Huerta', 'birthday' => '2000/01/01', 'role_id' => $admin->id]);
        $user2 = User::firstOrCreate(['email'=>'miguel.villegas@subitus.com', 'password'=>config('constants.default_password'),
            'firstname'=>'Miguel', 'lastname'=>'Villegas', 'birthday' => '2000/01/01', 'role_id' => $admin->id]);
        $user3 = User::firstOrCreate(['email'=>'ricardo.allende@subitus.com', 'password'=>config('constants.default_password'),
            'firstname'=>'Ricardo', 'lastname'=>'Allende', 'birthday' => '2000/01/01', 'role_id' => $admin->id]);
        AscriptionUser::firstOrCreate(['ascription_id' => $ascription->id, 'user_id' => $user1->id]);
        AscriptionUser::firstOrCreate(['ascription_id' => $ascription->id, 'user_id' => $user2->id]);
        AscriptionUser::firstOrCreate(['ascription_id' => $ascription->id, 'user_id' => $user3->id]);
        $tag1 = Tag::firstOrCreate(['tag'=>'Sueño']);
        $tag2 = Tag::firstOrCreate(['tag'=>'Glándulas']);
        $tag3 = Tag::firstOrCreate(['tag'=>'Corazón']);
        CourseTag::firstOrCreate(['tag_id'=> $tag1->id, 'course_id'=>$course->id]);
        CourseTag::firstOrCreate(['tag_id'=> $tag2->id, 'course_id'=>$course2->id]);
        CourseTag::firstOrCreate(['tag_id'=> $tag3->id, 'course_id'=>$course3->id]);
        $module1 = Module::firstOrCreate(['name' => 'Introducción', 'description' => 'Este curso ...', 'start_date' => '2000-01-01', 'end_date' => '2020-01-01']);
        $module2 = Module::firstOrCreate(['name' => 'Lección 1', 'description' => 'Este curso ...', 'start_date' => '2000-01-01', 'end_date' => '2020-01-01']);
        $module3 = Module::firstOrCreate(['name' => 'Caso clínico', 'description' => 'Este curso ...', 'start_date' => '2000-01-01', 'end_date' => '2020-01-01']);
        $module4 = Module::firstOrCreate(['name' => 'Lección final', 'description' => 'Este curso ...', 'start_date' => '2000-01-01', 'end_date' => '2020-01-01']);
        CourseModule::firstOrCreate(['course_id' => $course->id, 'module_id' => $module1->id]);
        CourseModule::firstOrCreate(['course_id' => $course->id, 'module_id' => $module3->id]);
        CourseModule::firstOrCreate(['course_id' => $course->id, 'module_id' => $module4->id]);
        CourseModule::firstOrCreate(['course_id' => $course2->id, 'module_id' => $module3->id]);
        CourseModule::firstOrCreate(['course_id' => $course2->id, 'module_id' => $module4->id]);
        $evaluation1 = Evaluation::firstOrCreate(['module_id' => $module1->id, 'name'=>'Arsenal terapéutico', 'type' => 'd']);
        $evaluation2 = Evaluation::firstOrCreate(['module_id' => $course->id, 'name'=>'Conociendo los diferentes tipos de insulina', 'type' => 'd']);
        $evaluation3 = Evaluation::firstOrCreate(['module_id' => $ascription->id, 'name'=>'Arsenal terapéutico', 'type' => 'd']);
        $evaluation4 = Evaluation::firstOrCreate(['module_id' => $module2->id, 'name'=>'Cómo favorecer el tratamiento de insulina', 'type' => 'd']);
        $evaluation5 = Evaluation::firstOrCreate(['module_id' => $course2->id, 'name'=>'Hipoglucemia', 'type' => 'd']);
        $evaluation6 = Evaluation::firstOrCreate(['module_id' => $module2->id, 'name'=>'Conociendo los diferentes tipos de insulina', 'type' => 'd']);
        $question1 =  Question::firstOrCreate(['evaluation_id' => 1, 'name'=>'Pregunta 1', 'content'=>'No siempre se programó en computadoras.']);
        $question2 =  Question::firstOrCreate(['evaluation_id' => 2, 'name'=>'Pregunta 2', 'content'=>'Windows está disponible sólo en 32 bits']);
        $question3 =  Question::firstOrCreate(['evaluation_id' => 1, 'name'=>'Pregunta 3', 'content' => '¿Cuántas horas tiene un día?']);
        $question4 =  Question::firstOrCreate(['evaluation_id' => 2, 'name'=>'Pregunta 4', 'content' => '¿Qué significa RGB?']);
        $question5 =  Question::firstOrCreate(['evaluation_id' => 1, 'name'=>'Pregunta 5', 'content'=>'No siempre se programó en computadoras.']);
        $question6 =  Question::firstOrCreate(['evaluation_id' => 2, 'name'=>'Pregunta 6', 'content'=>'Windows está disponible sólo en 32 bits']);
        $question7 =  Question::firstOrCreate(['evaluation_id' => 1, 'name'=>'Pregunta 7', 'content' => '¿Cuántas horas tiene un día?']);
        $question8 =  Question::firstOrCreate(['evaluation_id' => 2, 'name'=>'Pregunta 8', 'content' => '¿Qué significa RGB?']);
        Option::firstOrCreate(['question_id' => $question1->id, 'content' => 'Una opción adecuada', 'score' => 1]);
        Option::firstOrCreate(['question_id' => $question1->id, 'content' => 'Algo incorrecto', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question1->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question2->id, 'content' => 'Una opción adecuada', 'score' => 1]);
        Option::firstOrCreate(['question_id' => $question2->id, 'content' => 'Algo incorrecto', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question2->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question3->id, 'content' => 'Una opción adecuada', 'score' => 1]);
        Option::firstOrCreate(['question_id' => $question3->id, 'content' => 'Algo incorrecto', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question3->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question4->id, 'content' => 'Una opción adecuada', 'score' => 1]);
        Option::firstOrCreate(['question_id' => $question4->id, 'content' => 'Algo incorrecto', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question4->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question5->id, 'content' => 'Una opción adecuada', 'score' => 1]);
        Option::firstOrCreate(['question_id' => $question5->id, 'content' => 'Algo incorrecto', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question5->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question6->id, 'content' => 'Una opción adecuada', 'score' => 1]);
        Option::firstOrCreate(['question_id' => $question6->id, 'content' => 'Algo incorrecto', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question6->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question7->id, 'content' => 'Una opción adecuada', 'score' => 1]);
        Option::firstOrCreate(['question_id' => $question7->id, 'content' => 'Algo incorrecto', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question7->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question8->id, 'content' => 'Una opción adecuada', 'score' => 1]);
        Option::firstOrCreate(['question_id' => $question8->id, 'content' => 'Algo incorrecto', 'score' => 0]);
        Option::firstOrCreate(['question_id' => $question8->id, 'content' => 'Otra cosa fuera de lugar', 'score' => 0]);

        CourseUser::firstOrCreate(['user_id' => $user1->id, 'course_id' => $course->id, 'status' => config('constants.status.passed')]);
        CourseUser::firstOrCreate(['user_id' => $user1->id, 'course_id' => $course2->id, 'status' => config('constants.status.failed')]);
        CourseUser::firstOrCreate(['user_id' => $user2->id, 'course_id' => $course->id, 'status' => config('constants.status.passed')]);
        CourseUser::firstOrCreate(['user_id' => $user2->id, 'course_id' => $course2->id, 'status' => config('constants.status.failed')]);
        CourseUser::firstOrCreate(['user_id' => $user3->id, 'course_id' => $course->id, 'status' => config('constants.status.passed')]);
        CourseUser::firstOrCreate(['user_id' => $user3->id, 'course_id' => $course2->id, 'status' => config('constants.status.failed')]);

        EvaluationUser::firstOrCreate(['user_id' => $user1->id, 'evaluation_id' => $evaluation1->id, 'status' => config('constants.status.failed')]);
        EvaluationUser::firstOrCreate(['user_id' => $user1->id, 'evaluation_id' => $evaluation2->id, 'status' => config('constants.status.passed')]);
        EvaluationUser::firstOrCreate(['user_id' => $user2->id, 'evaluation_id' => $evaluation1->id, 'status' => config('constants.status.failed')]);
        EvaluationUser::firstOrCreate(['user_id' => $user2->id, 'evaluation_id' => $evaluation2->id, 'status' => config('constants.status.passed')]);
        EvaluationUser::firstOrCreate(['user_id' => $user3->id, 'evaluation_id' => $evaluation1->id, 'status' => config('constants.status.failed')]);
        EvaluationUser::firstOrCreate(['user_id' => $user3->id, 'evaluation_id' => $evaluation2->id, 'status' => config('constants.status.passed')]);

        RecommendedCourse::firstOrCreate(['course_id'=>$course->id, 'user_id'=>$user1->id]);
        RecommendedCourse::firstOrCreate(['course_id'=>$course->id, 'user_id'=>$user2->id]);
        RecommendedCourse::firstOrCreate(['course_id'=>$course->id, 'user_id'=>$user3->id]);
        
        // $attachment = Attachment::firstOrCreate(['name' => 'Archivo adjunto', 'type' => config('constants.attachments.manual')]);
        // $resource1 = Resource::firstOrCreate(['attachment_id'=>$attachment, 'type' => config('constants.resources.manual')]);
        // $resource2 = Resource::firstOrCreate(['attachment_id'=>$attachment, 'type' => config('constants.resources.manual')]);
        // $resource3 = Resource::firstOrCreate(['attachment_id'=>$attachment, 'type' => config('constants.resources.manual')]);
        // $resource4 = Resource::firstOrCreate(['attachment_id'=>$attachment, 'type' => config('constants.resources.manual')]);

        

    }
}
