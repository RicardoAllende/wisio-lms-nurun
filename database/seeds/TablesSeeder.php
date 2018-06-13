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
use App\AscriptionCourse;
use App\EvaluationUser;
use App\CourseUser;
use App\RecommendedCourse;
use App\Expert;
use App\Specialty;
use App\ExpertSpecialty;
use App\ExpertModule;
use App\Reference;
use App\State;
use App\AttachmentModule;
use App\AttachmentCourse;
use App\AscriptionAttachment;


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
        // $doctor = Role::firstOrCreate(['name' => config('constants.roles.doctor'), 'description' => 'Médico']);
        // $reporter = Role::create(['name' => config('constants.roles.reporter'), 'description' => 'Reportero']);
        // $admin = Role::firstOrCreate(['name' => config('constants.roles.admin'), 'description' => 'Administrador']);
        // $tester = Role::create(['name' => config('constants.roles.tester'), 'description' => 'Tester']);
        // $teacher = Role::create(['name' => config('constants.roles.teacher'), 'description' => 'Profesor']);
        $doctor = Role::find(1);
        $admin = Role::find(2);

        $ascription = Ascription::create(['id' => 1, 'name' => 'Paec México', 'slug' => 'academia-mc', 'description' => 'Sección principal', 'is_main_ascription' => 1]);
        $ascription2 = Ascription::create(['id' => 7, 'code' => 'PAECBENAVIDES', 'name' => 'Farmacia Benavides', 'slug' => 'benavides', 'description' => 'Sección para la farmacia benavides', 'is_pharmacy' => 1]);
        $ascription3 = Ascription::create(['id' => 8, 'code' => 'PAECDELAHORRO', 'name' => 'Farmacia del ahorro', 'slug' => 'del-ahorro', 'description' => 'Sección para la farmacia benavides', 'is_pharmacy' => 1]);
        $ascription4 = Ascription::create(['id' => 9, 'code' => 'PAECYZA', 'name' => 'Farmacia Femsa', 'slug' => 'femsa', 'description' => 'Sección para la farmacia benavides', 'is_pharmacy' => 1]);
        $ascription5 = Ascription::create(['id' => 10, 'code' => 'PAECSANPABLO', 'name' => 'Farmacia San pablo', 'slug' => 'san-pablo', 'description' => 'Sección para la farmacia benavides', 'is_pharmacy' => 1]);
        $ascription6 = Ascription::create(['id' => 11, 'code' => 'PAECFRAGUA', 'name' => 'Súper Farmacias', 'slug' => 'guadalajara', 'description' => 'Sección para la farmacia benavides', 'is_pharmacy' => 1]);
        $ascription7 = Ascription::create(['id' => 12, 'code' => 'PAECCIRCULO', 'name' => 'Farmacia Nadro', 'slug' => 'nadro', 'description' => 'Sección para la farmacia benavides', 'is_pharmacy' => 1]);
        $diplomado = Ascription::create(['id' => 13, 'code' => '', 'name' => 'Diplomado Universidad la Salle', 'slug' => 'diplomado-universidad-la-salle', 'description' => 'Sección del diplomado', 'has_constancy' => 1]);
        $category = Category::create(['name'=>'Sistema Nervioso Central', 'description' => 'Sistema Nervioso Central']);
        $category2 = Category::create(['name'=>'Endocrinología', 'description' => 'Sistema Nervioso Central']);
        $category3 = Category::create(['name'=>'Cardiología', 'description' => 'Sistema Nervioso Central']);
        


        $course1 = Course::create(['id' => 1, 'name' => 'PAEC Insomnio', 'slug' => 'insomnio', 'has_constancy' => 1, 'category_id' => $category->id]);
        $course2 = Course::create(['id' => 2, 'name' => 'PAEC Diabetes', 'slug' => 'diabetes', 'has_constancy' => 1, 'category_id' => $category->id]);
        $course3 = Course::create(['id' => 3, 'name' => 'PAEC Hipertensión', 'slug' => 'hipertension', 'has_constancy' => 0, 'category_id' => $category->id]);
        $course4 = Course::create(['id' => 4, 'name' => 'PAEC Trombosis', 'slug' => 'trombosis', 'has_constancy' => 0, 'category_id' => $category->id]);
        $course5 = Course::create(['id' => 5, 'name' => 'PAEC Lipid Leaders', 'slug' => 'lipid-leader', 'has_constancy' => 0, 'category_id' => $category->id]);
        $course6 = Course::create(['id' => 6, 'name' => 'PAEC Esclerosis Múltiple', 'slug' => 'esclerosis-multiple', 'has_constancy' => 0, 'category_id' => $category->id]);

        $course7 = Course::create(['id' => 7, 'name' => 'Paec diabetes', 'slug' => 'diabetes-', 'has_constancy' => 1, 'category_id' => $category->id]);
        $course8 = Course::create(['id' => 8, 'name' => 'Paec Hipertensión', 'slug' => 'hipertension-', 'has_constancy' => 0, 'category_id' => $category->id]);
        
        $ascription->courses()->attach([$course1->id, $course2->id, $course3->id, $course4->id, $course5->id, $course6->id]);
        $ascription2->courses()->attach($course7->id);
        $ascription3->courses()->attach($course7->id);
        $ascription4->courses()->attach($course8->id);
        $ascription5->courses()->attach($course8->id);
        $ascription6->courses()->attach($course8->id);
        $ascription7->courses()->attach($course7->id);
        

        // $student = User::create(['email'=>'doctor@sanofi.com', 'password'=>config('constants.default_password'),
        // 'firstname'=>'Mario', 'lastname'=>'Mendoza', 'cedula' => '13245678', 'mobile_phone' => '123456789', 'birthday' => '2000/01/01', 'role_id' => $doctor->id]);
        // $student2 = User::create(['email'=>'doctor@benavides.com', 'password'=>config('constants.default_password'),
        // 'firstname'=>'Ángel', 'lastname'=>'Ortegón', 'cedula' => '13245678', 'mobile_phone' => '123456789', 'birthday' => '2000/01/01', 'role_id' => $doctor->id]);
        // $user = User::create(['email'=>'soporte@paecmexico.com', 'password'=>config('constants.default_password'),
        // 'firstname'=>'Christian', 'lastname'=>'George', 'cedula' => '13245678', 'mobile_phone' => '123456789', 'role_id' => $admin->id]);
        // $user1 = User::create(['email'=>'juan.huerta@subitus.com', 'password'=>config('constants.default_password'),
        //     'firstname'=>'Juan', 'lastname'=>'Huerta', 'role_id' => $admin->id]);
        // $user2 = User::create(['email'=>'miguel.villegas@subitus.com', 'cedula' => '13245678', 'mobile_phone' => '123456789', 'password'=>config('constants.default_password'),
        //     'firstname'=>'Miguel', 'lastname'=>'Villegas', 'role_id' => $admin->id]);
        // $user3 = User::create(['email'=>'ricardo.allende@subitus.com', 'password'=>config('constants.default_password'),
        //     'firstname'=>'Ricardo', 'lastname'=>'Allende', 'cedula' => '13245678', 'mobile_phone' => '123456789', 'role_id' => $admin->id]);
        
        // $course1->enrolUser($student->id);
        // $course2->enrolUser($student2->id);

        // AscriptionUser::create(['ascription_id' => $ascription->id, 'user_id' => $user1->id]);
        // AscriptionUser::create(['ascription_id' => $ascription->id, 'user_id' => $user2->id]);
        // AscriptionUser::create(['ascription_id' => $ascription->id, 'user_id' => $user3->id]);
        // AscriptionUser::create(['ascription_id' => $ascription->id, 'user_id' => $student->id]);
        // AscriptionUser::create(['ascription_id' => $ascription2->id, 'user_id' => $student2->id]);
        
        $module1 = Module::create(['id' => '1', 'name' => 'Prevalencia y diagnóstico', 'course_id' => 1]);
        $module2 = Module::create(['id' => '2', 'name' => 'Opciones terapéuticas', 'course_id' => 1]);
        $module3 = Module::create(['id' => '3', 'name' => 'Insomnio en la mujer', 'course_id' => 1]);
        $module4 = Module::create(['id' => '4', 'name' => 'Paciente con insomnio', 'course_id' => 1]);
        $module5 = Module::create(['id' => '5', 'name' => 'Comorbilidades psiquiátricas', 'course_id' => 1]);
        $module6 = Module::create(['id' => '6', 'name' => 'Ajustando a la necesidad del paciente', 'course_id' => 2]);
        $module7 = Module::create(['id' => '7', 'name' => 'Estadísticas de DM y necesidades de los pacientes', 'course_id' => 2]);
        $module8 = Module::create(['id' => '8', 'name' => 'Pie diabético', 'course_id' => 2]);
        $module9 = Module::create(['id' => '9', 'name' => 'Retinopatia', 'course_id' => 2]);
        $module10 = Module::create(['id' => '10', 'name' => 'Nefropatia Diabética ', 'course_id' => 2]);
        $module11 = Module::create(['id' => '11', 'name' => 'Obesidad', 'course_id' => 2]);
        $module12 = Module::create(['id' => '12', 'name' => 'Recomendaciones para DMT1 Y T2', 'course_id' => 2]);
        $module13 = Module::create(['id' => '13', 'name' => 'Webcast Dr. Edilberto Peña', 'course_id' => 1]);
        $module14 = Module::create(['id' => '14', 'name' => 'Arsenal terapéutico oral en diabetes', 'course_id' => 2]);
        $module15 = Module::create(['id' => '15', 'name' => 'Conociendo los diferentes tipos de insulinas', 'course_id' => 2]);
        $module16 = Module::create(['id' => '16', 'name' => '¿Cómo favorecer el inicio del tratamiento con insulina?', 'course_id' => 2]);
        $module17 = Module::create(['id' => '17', 'name' => 'Insulinas de acción ultra-rápida, beneficios en Tipo 1 y Tipo 2', 'course_id' => 2]);
        $module18 = Module::create(['id' => '18', 'name' => 'Titulación correcta para llegar a metas', 'course_id' => 2]);
        $module19 = Module::create(['id' => '19', 'name' => 'Hipoglucemia en contexto ', 'course_id' => 2]);
        $module20 = Module::create(['id' => '20', 'name' => 'Seguridad CV y legado', 'course_id' => 2]);
        $module21 = Module::create(['id' => '21', 'name' => 'Introducción Dr. Luis Alcocer Díaz Barreiro', 'course_id' => 3]);
        $module22 = Module::create(['id' => '22', 'name' => 'Generalidades de hipertensión', 'course_id' => 3]);
        $module23 = Module::create(['id' => '23', 'name' => 'Toma correcta de la presión arterial', 'course_id' => 3]);
        $module24 = Module::create(['id' => '24', 'name' => 'Modificaciones al estilo de vida en hipertensión (Obesidad y Alimentación)', 'course_id' => 3]);
        $module25 = Module::create(['id' => '25', 'name' => 'Comorbilidades del paciente con hipertensión', 'course_id' => 3]);
        $module26 = Module::create(['id' => '26', 'name' => 'Creación de plan estratégico para hipertensión', 'course_id' => 3]);
        $module27 = Module::create(['id' => '27', 'name' => 'Caso Clinico Dr. Diaz (Módulo 2)', 'course_id' => 3]);
        $module28 = Module::create(['id' => '28', 'name' => 'Caso Clinico Dr. Ramos (Módulo 5)', 'course_id' => 3]);
        $module29 = Module::create(['id' => '29', 'name' => 'Caso clínico: Entrevista Dr. Alcocer y Dr. Figueroa', 'course_id' => 3]);
        $module30 = Module::create(['id' => '30', 'name' => 'Trombosis en cifras', 'course_id' => 4]);
        $module31 = Module::create(['id' => '31', 'name' => 'Evaluación de riesgo y tratamiento', 'course_id' => 4]);
        $module32 = Module::create(['id' => '32', 'name' => 'Tromboembolia Venosa', 'course_id' => 4]);
        $module33 = Module::create(['id' => '33', 'name' => 'Tomboembolia Pulmonar', 'course_id' => 4]);
        $module34 = Module::create(['id' => '34', 'name' => 'Sindromes coronarios agudos', 'course_id' => 4]);
        $module35 = Module::create(['id' => '35', 'name' => 'Tratamiento del paciente postinfarto', 'course_id' => 4]);
        $module36 = Module::create(['id' => '36', 'name' => 'Infarto agudo', 'course_id' => 4]);
        $module37 = Module::create(['id' => '37', 'name' => 'Carga de las dislipidemias en México', 'course_id' => 5]);
        $module38 = Module::create(['id' => '38', 'name' => 'Hipercolesterolemia: Necesidades no cubiertas', 'course_id' => 5]);
        $module39 = Module::create(['id' => '39', 'name' => 'Biotecnología en hipercolesterolemia', 'course_id' => 5]);
        $module40 = Module::create(['id' => '40', 'name' => 'Guías de tratamiento clínico: inhibidores de PCSK9', 'course_id' => 5]);
        $module41 = Module::create(['id' => '41', 'name' => 'Pacientes con hipercolesterolemia resistente al tratamiento', 'course_id' => 5]);
        $module42 = Module::create(['id' => '42', 'name' => 'Caso Clínico: Paciente con alto riesgo cardiovascular', 'course_id' => 5]);
        $module43 = Module::create(['id' => '43', 'name' => 'Hipercolesterolemia en paciente con diabetes', 'course_id' => 5]);
        $module44 = Module::create(['id' => '44', 'name' => '¿Cómo identificar y tratar la Hipercolesterolemia Familiar Heterocigota?', 'course_id' => 5]);
        $module45 = Module::create(['id' => '45', 'name' => 'Caso Clínico: Paciente con alto riesgo cardiovascular e Hipercolesterolemia Familiar Heterocigota', 'course_id' => 5]);
        $module46 = Module::create(['id' => '46', 'name' => 'Pacientes intolerantes a estatinas con hipercolesterolemia: tratamiento', 'course_id' => 5]);
        $module47 = Module::create(['id' => '47', 'name' => 'EM leve a moderada', 'course_id' => 6]);
        $module48 = Module::create(['id' => '48', 'name' => 'EM severa/ altamente activa', 'course_id' => 6]);
        $module49 = Module::create(['id' => '49', 'name' => 'Sesión 3', 'course_id' => 6]);

        $module50 = Module::create(['id' => '71', 'name' => 'Ajustando la necesidad del paciente', 'course_id' => 7]);
        $module51 = Module::create(['id' => '72', 'name' => 'Estadisticas de DM y necesidades de los pacientes', 'course_id' => 7]);
        $module52 = Module::create(['id' => '73', 'name' => 'Recomendaciones para DMT1 Y T2', 'course_id' => 7]);
        $module53 = Module::create(['id' => '74', 'name' => 'Arsenal terapéutico oral en DM', 'course_id' => 7]);
        $module54 = Module::create(['id' => '75', 'name' => 'Conociendo los diferentes tipos de insulinas', 'course_id' => 7]);
        $module55 = Module::create(['id' => '76', 'name' => '¿Cómo favorecer el inicio del tratamiento con insulina?', 'course_id' => 7]);
        $module56 = Module::create(['id' => '77', 'name' => 'Insulinas de acción ultra-rápida, beneficios en Tipo 1 y Tipo 2', 'course_id' => 7]);
        $module57 = Module::create(['id' => '78', 'name' => 'Titulación correcta para llegar a metas', 'course_id' => 7]);
        $module58 = Module::create(['id' => '79', 'name' => 'Hipoglucemia en contexto', 'course_id' => 7]);
        $module59 = Module::create(['id' => '80', 'name' => 'Seguridad CV y legado', 'course_id' => 7]);
        $module60 = Module::create(['id' => '124', 'name' => 'Pie diabético', 'course_id' => 7]);
        $module61 = Module::create(['id' => '125', 'name' => 'Retinopatía', 'course_id' => 7]);
        $module62 = Module::create(['id' => '126', 'name' => 'Nefropatía Diabética', 'course_id' => 7]);
        $module63 = Module::create(['id' => '132', 'name' => 'Introducción Dr. Luis Alcocer Díaz Barreiro', 'course_id' => 8]);
        $module64 = Module::create(['id' => '133', 'name' => 'Generalidades de hipertensión', 'course_id' => 8]);
        $module65 = Module::create(['id' => '134', 'name' => 'Toma correcta de la presión arterial', 'course_id' => 8]);
        $module66 = Module::create(['id' => '135', 'name' => 'Modificaciones al estilo de vida en hipertensión (Obesidad y Alimentación)', 'course_id' => 8]);
        $module67 = Module::create(['id' => '136', 'name' => 'Comorbilidades del paciente con hipertensión', 'course_id' => 8]);
        $module68 = Module::create(['id' => '137', 'name' => 'Creación de plan estratégico para hipertensión', 'course_id' => 8]);
        $module69 = Module::create(['id' => '138', 'name' => 'Caso Clinico Dr. Diaz (Módulo 2)', 'course_id' => 8]);
        $module70 = Module::create(['id' => '139', 'name' => 'Caso Clinico Dr. Ramos (Módulo 5)', 'course_id' => 8]);
        $module71 = Module::create(['id' => '140', 'name' => 'Caso clínico: Entrevista Dr. Alcocer y Dr. Figueroa', 'course_id' => 8]);


        /** Vídeos de los cursos */
        $attach1 = Attachment::create(['type' => 'video', 'url' => 'storage/video/Dr-Alejandro-Jimenez-Stilnox-parte1.mp4', 'name' => 'Dr-Alejandro-Jimenez-Stilnox-parte1.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 1, "attachment_id" => $attach1->id, "type" => "video"]);
        $attach2 = Attachment::create(['type' => 'video', 'url' => 'storage/video/Dr-Alejandro-Jimenez-Stilnox-parte2.mp4', 'name' => 'Dr-Alejandro-Jimenez-Stilnox-parte2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 1, "attachment_id" => $attach2->id, "type" => "video"]);
        $attach3 = Attachment::create(['type' => 'video', 'url' => 'storage/video/insomnio/M02_1.mp4', 'name' => 'M02_1.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 2, "attachment_id" => $attach3->id, "type" => "video"]);
        $attach4 = Attachment::create(['type' => 'video', 'url' => 'storage/video/insomnio/M02_2.mp4', 'name' => 'M02_2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 2, "attachment_id" => $attach4->id, "type" => "video"]);
        $attach5 = Attachment::create(['type' => 'video', 'url' => 'storage/video/insomnio/M03_1.mp4', 'name' => 'M03_1.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 3, "attachment_id" => $attach5->id, "type" => "video"]);
        $attach6 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/1a_PAEC_SANOFI_08JUN17.mp4', 'name' => '1a_PAEC_SANOFI_08JUN17.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 6, "attachment_id" => $attach6->id, "type" => "video"]);
        $attach7 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/1b_PAEC_SANOFI_08JUN17.mp4', 'name' => '1b_PAEC_SANOFI_08JUN17.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 6, "attachment_id" => $attach7->id, "type" => "video"]);
        $attach8 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/1c_PAEC_SANOFI_08JUN17.mp4', 'name' => '1c_PAEC_SANOFI_08JUN17.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 6, "attachment_id" => $attach8->id, "type" => "video"]);
        $attach9 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/2a_PAEC_SANOFI_06JUN17.mp4', 'name' => '2a_PAEC_SANOFI_06JUN17.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 7, "attachment_id" => $attach9->id, "type" => "video"]);
        $attach10 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/2b_PAEC_SANOFI_06JUN17.mp4', 'name' => '2b_PAEC_SANOFI_06JUN17.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 7, "attachment_id" => $attach10->id, "type" => "video"]);
        $attach11 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Pie_Diabetico_001.mp4', 'name' => 'Pie_Diabetico_001.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 8, "attachment_id" => $attach11->id, "type" => "video"]);
        $attach12 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Pie_Diabetico_002.mp4', 'name' => 'Pie_Diabetico_002.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 8, "attachment_id" => $attach12->id, "type" => "video"]);
        $attach13 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/1a_Retinopatia_pt1.mp4', 'name' => '1a_Retinopatia_pt1.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 9, "attachment_id" => $attach13->id, "type" => "video"]);
        $attach14 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/1b_Retinopatia_pt2.mp4', 'name' => '1b_Retinopatia_pt2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 9, "attachment_id" => $attach14->id, "type" => "video"]);
        $attach15 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_001.mp4', 'name' => 'Nefropatia_001.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 10, "attachment_id" => $attach15->id, "type" => "video"]);
        $attach16 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_002.mp4', 'name' => 'Nefropatia_002.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 10, "attachment_id" => $attach16->id, "type" => "video"]);
        $attach17 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_003.mp4', 'name' => 'Nefropatia_003.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 10, "attachment_id" => $attach17->id, "type" => "video"]);
        $attach18 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_004.mp4', 'name' => 'Nefropatia_004.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 10, "attachment_id" => $attach18->id, "type" => "video"]);
        $attach19 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_005.mp4', 'name' => 'Nefropatia_005.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 10, "attachment_id" => $attach19->id, "type" => "video"]);
        $attach20 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Obesidad_001.mp4', 'name' => 'Obesidad_001.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 11, "attachment_id" => $attach20->id, "type" => "video"]);
        $attach21 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Obesidad_002.mp4', 'name' => 'Obesidad_002.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 11, "attachment_id" => $attach21->id, "type" => "video"]);
        $attach22 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Obesidad_003.mp4', 'name' => 'Obesidad_003.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 11, "attachment_id" => $attach22->id, "type" => "video"]);
        $attach23 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Obesidad_004.mp4', 'name' => 'Obesidad_004.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 11, "attachment_id" => $attach23->id, "type" => "video"]);
        $attach24 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Pie_Diabetico_003.mp4', 'name' => 'Pie_Diabetico_003.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 8, "attachment_id" => $attach24->id, "type" => "video"]);
        $attach25 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Pie_Diabetico_004.mp4', 'name' => 'Pie_Diabetico_004.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 8, "attachment_id" => $attach25->id, "type" => "video"]);
        $attach26 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/modulo3a_paec.mp4', 'name' => 'modulo3a_paec.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 12, "attachment_id" => $attach26->id, "type" => "video"]);
        $attach27 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/modulo3b_paec.mp4', 'name' => 'modulo3b_paec.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 12, "attachment_id" => $attach27->id, "type" => "video"]);
        $attach28 = Attachment::create(['type' => 'video', 'url' => 'storage/video/insomnio/M04_01.mp4', 'name' => 'M04_01.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 4, "attachment_id" => $attach28->id, "type" => "video"]);
        $attach29 = Attachment::create(['type' => 'video', 'url' => 'storage/video/insomnio/webcast/webcast1parte1.mp4', 'name' => 'webcast1parte1.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 13, "attachment_id" => $attach29->id, "type" => "video"]);
        $attach30 = Attachment::create(['type' => 'video', 'url' => 'storage/video/insomnio/webcast/webcast1parte2.mp4', 'name' => 'webcast1parte2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 13, "attachment_id" => $attach30->id, "type" => "video"]);
        $attach31 = Attachment::create(['type' => 'video', 'url' => 'storage/video/insomnio/M05.mp4', 'name' => 'M05.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 5, "attachment_id" => $attach31->id, "type" => "video"]);
        $attach32 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod4.mp4', 'name' => 'mod4.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 14, "attachment_id" => $attach32->id, "type" => "video"]);
        $attach33 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod5.mp4', 'name' => 'mod5.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 15, "attachment_id" => $attach33->id, "type" => "video"]);
        $attach34 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod6.mp4', 'name' => 'mod6.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 16, "attachment_id" => $attach34->id, "type" => "video"]);
        $attach35 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod7parte1.mp4', 'name' => 'mod7parte1.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 17, "attachment_id" => $attach35->id, "type" => "video"]);
        $attach36 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod7parte2.mp4', 'name' => 'mod7parte2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 17, "attachment_id" => $attach36->id, "type" => "video"]);
        $attach37 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod8.mp4', 'name' => 'mod8.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 18, "attachment_id" => $attach37->id, "type" => "video"]);
        $attach38 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod_9_Dr_Rene_Rodriguez_baja.mp4', 'name' => 'mod_9_Dr_Rene_Rodriguez_baja.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 19, "attachment_id" => $attach38->id, "type" => "video"]);
        $attach39 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod10.mp4', 'name' => 'mod10.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 20, "attachment_id" => $attach39->id, "type" => "video"]);
        $attach40 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/PAEC_Sincronizacion_IntroHiptertension_11agosto2017.mp4', 'name' => 'PAEC_Sincronizacion_IntroHiptertension_11agosto2017.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 21, "attachment_id" => $attach40->id, "type" => "video"]);
        $attach41 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/DR_Fernandez_hipertension_Generalidades_12sep.mp4', 'name' => 'DR_Fernandez_hipertension_Generalidades_12sep.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 22, "attachment_id" => $attach41->id, "type" => "video"]);
        $attach42 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/DR_Fernandez_hipertension_12sep.mp4', 'name' => 'DR_Fernandez_hipertension_12sep.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 22, "attachment_id" => $attach42->id, "type" => "video"]);
        $attach43 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/cardio_modulo2.mp4', 'name' => 'cardio_modulo2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 23, "attachment_id" => $attach43->id, "type" => "video"]);
        $attach44 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/cardio_m3.mp4', 'name' => 'cardio_m3.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 24, "attachment_id" => $attach44->id, "type" => "video"]);
        $attach45 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/cardio_m4.mp4', 'name' => 'cardio_m4.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 25, "attachment_id" => $attach45->id, "type" => "video"]);
        $attach46 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/cardio_m4_2_caso_clinico.mp4', 'name' => 'cardio_m4_2_caso_clinico.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 25, "attachment_id" => $attach46->id, "type" => "video"]);
        $attach47 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/hipertension_mod5.mp4', 'name' => 'hipertension_mod5.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 26, "attachment_id" => $attach47->id, "type" => "video"]);
        $attach48 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/mod2_Hipertension_Caso_clinico_Dr_Diaz.mp4', 'name' => 'mod2_Hipertension_Caso_clinico_Dr_Diaz.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 27, "attachment_id" => $attach48->id, "type" => "video"]);
        $attach49 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/modulo_que_hago_con_mi_paciente_con_HTA.mp4', 'name' => 'modulo_que_hago_con_mi_paciente_con_HTA.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 28, "attachment_id" => $attach49->id, "type" => "video"]);
        $attach50 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/cierre_modulo.mp4', 'name' => 'cierre_modulo.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 29, "attachment_id" => $attach50->id, "type" => "video"]);
        $attach51 = Attachment::create(['type' => 'video', 'url' => 'storage/video/trombosis/mod1_ricardo.mp4', 'name' => 'mod1_ricardo.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 30, "attachment_id" => $attach51->id, "type" => "video"]);
        $attach52 = Attachment::create(['type' => 'video', 'url' => 'storage/video/trombosis/mod2_TROMBOSISM2_IZAGUIRRE.mp4', 'name' => 'mod2_TROMBOSISM2_IZAGUIRRE.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 31, "attachment_id" => $attach52->id, "type" => "video"]);
        $attach53 = Attachment::create(['type' => 'video', 'url' => 'storage/video/trombosis/mod3_trombosis.mp4', 'name' => 'mod3_trombosis.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 32, "attachment_id" => $attach53->id, "type" => "video"]);
        $attach54 = Attachment::create(['type' => 'video', 'url' => 'storage/video/trombosis/mod4_TROMBOSIS.mp4', 'name' => 'mod4_TROMBOSIS.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 33, "attachment_id" => $attach54->id, "type" => "video"]);
        $attach55 = Attachment::create(['type' => 'video', 'url' => 'storage/video/trombosis/mod5_PAEC_Trombosis.mp4', 'name' => 'mod5_PAEC_Trombosis.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 34, "attachment_id" => $attach55->id, "type" => "video"]);
        $attach56 = Attachment::create(['type' => 'video', 'url' => 'storage/video/trombosis/mod6_trombosis.mp4', 'name' => 'mod6_trombosis.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 35, "attachment_id" => $attach56->id, "type" => "video"]);
        $attach57 = Attachment::create(['type' => 'video', 'url' => 'storage/video/trombosis/mod7_TROMBOSISM7_pena_duque.mp4', 'name' => 'mod7_TROMBOSISM7_pena_duque.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 36, "attachment_id" => $attach57->id, "type" => "video"]);
        $attach58 = Attachment::create(['type' => 'video', 'url' => 'storage/video/lipid/mod1.mp4', 'name' => 'mod1.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 37, "attachment_id" => $attach58->id, "type" => "video"]);
        $attach59 = Attachment::create(['type' => 'video', 'url' => 'storage/video/lipid/mod2.mp4', 'name' => 'mod2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 38, "attachment_id" => $attach59->id, "type" => "video"]);
        $attach60 = Attachment::create(['type' => 'video', 'url' => 'storage/video/lipid/mod3.mp4', 'name' => 'mod3.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 39, "attachment_id" => $attach60->id, "type" => "video"]);
        $attach61 = Attachment::create(['type' => 'video', 'url' => 'storage/video/lipid/mod4.mp4', 'name' => 'mod4.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 40, "attachment_id" => $attach61->id, "type" => "video"]);
        $attach62 = Attachment::create(['type' => 'video', 'url' => 'storage/video/lipid/mod5.mp4', 'name' => 'mod5.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 41, "attachment_id" => $attach62->id, "type" => "video"]);
        $attach63 = Attachment::create(['type' => 'video', 'url' => 'storage/video/lipid/mod6.mp4', 'name' => 'mod6.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 42, "attachment_id" => $attach63->id, "type" => "video"]);
        $attach64 = Attachment::create(['type' => 'video', 'url' => 'storage/video/lipid/mod7.mp4', 'name' => 'mod7.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 43, "attachment_id" => $attach64->id, "type" => "video"]);
        $attach65 = Attachment::create(['type' => 'video', 'url' => 'storage/video/lipid/mod8.mp4', 'name' => 'mod8.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 44, "attachment_id" => $attach65->id, "type" => "video"]);
        $attach66 = Attachment::create(['type' => 'video', 'url' => 'storage/video/lipid/mod9.mp4', 'name' => 'mod9.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 45, "attachment_id" => $attach66->id, "type" => "video"]);
        $attach67 = Attachment::create(['type' => 'video', 'url' => 'storage/video/lipid/mod10.mp4', 'name' => 'mod10.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 46, "attachment_id" => $attach67->id, "type" => "video"]);
        $attach68 = Attachment::create(['type' => 'video', 'url' => 'storage/video/eem/VIDEO_CASO1_EM_3JUL2017.mp4', 'name' => 'VIDEO_CASO1_EM_3JUL2017.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 47, "attachment_id" => $attach68->id, "type" => "video"]);
        $attach69 = Attachment::create(['type' => 'video', 'url' => 'storage/video/eem/VIDEO_CASO3_EM_4JUL2017.mp4', 'name' => 'VIDEO_CASO3_EM_4JUL2017.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 47, "attachment_id" => $attach69->id, "type" => "video"]);
        $attach70 = Attachment::create(['type' => 'video', 'url' => 'storage/video/eem/CASO5_PAEC-EM_SANOFI_27NOV17.mp4', 'name' => 'CASO5_PAEC-EM_SANOFI_27NOV17.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 47, "attachment_id" => $attach70->id, "type" => "video"]);
        $attach71 = Attachment::create(['type' => 'video', 'url' => 'storage/video/eem/CASO7_PAEC-EM_SANOFI_30NOV17.mp4', 'name' => 'CASO7_PAEC-EM_SANOFI_30NOV17.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 47, "attachment_id" => $attach71->id, "type" => "video"]);
        $attach72 = Attachment::create(['type' => 'video', 'url' => 'storage/video/eem/VIDEO_CASO2_EM_3JUL2017.mp4', 'name' => 'VIDEO_CASO2_EM_3JUL2017.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 48, "attachment_id" => $attach72->id, "type" => "video"]);
        $attach73 = Attachment::create(['type' => 'video', 'url' => 'storage/video/eem/VIDEO_CASO4_EM_7JUL2017.mp4', 'name' => 'VIDEO_CASO4_EM_7JUL2017.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 48, "attachment_id" => $attach73->id, "type" => "video"]);
        $attach74 = Attachment::create(['type' => 'video', 'url' => 'storage/video/eem/CASO8_PAEC_EM_SANOFI_30NOV17.mp4', 'name' => 'CASO8_PAEC_EM_SANOFI_30NOV17.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 48, "attachment_id" => $attach74->id, "type" => "video"]);

        
        $attach100 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/1a_PAEC_SANOFI_08JUN17.mp4', 'name' => '1a_PAEC_SANOFI_08JUN17.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 71, "attachment_id" => $attach100->id, "type" => "video"]);
        $attach101 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/2a_PAEC_SANOFI_06JUN17.mp4', 'name' => '2a_PAEC_SANOFI_06JUN17.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 72, "attachment_id" => $attach101->id, "type" => "video"]);
        $attach102 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/modulo3a_paec.mp4', 'name' => 'modulo3a_paec.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 73, "attachment_id" => $attach102->id, "type" => "video"]);
        $attach103 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod4.mp4', 'name' => 'mod4.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 74, "attachment_id" => $attach103->id, "type" => "video"]);
        $attach104 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod5.mp4', 'name' => 'mod5.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 75, "attachment_id" => $attach104->id, "type" => "video"]);
        $attach105 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod6.mp4', 'name' => 'mod6.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 76, "attachment_id" => $attach105->id, "type" => "video"]);
        $attach106 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod7parte1.mp4', 'name' => 'mod7parte1.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 77, "attachment_id" => $attach106->id, "type" => "video"]);
        $attach107 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod8.mp4', 'name' => 'mod8.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 78, "attachment_id" => $attach107->id, "type" => "video"]);
        $attach108 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod_9_Dr_Rene_Rodriguez_baja.mp4', 'name' => 'mod_9_Dr_Rene_Rodriguez_baja.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 79, "attachment_id" => $attach108->id, "type" => "video"]);
        // $attach109 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/ahorro_diabetes_m1.mp4', 'name' => 'ahorro_diabetes_m1.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 81, "attachment_id" => $attach109->id, "type" => "video"]);
        // $attach110 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/ahorro_diabetes_m2.mp4', 'name' => 'ahorro_diabetes_m2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 82, "attachment_id" => $attach110->id, "type" => "video"]);
        // $attach111 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_hipertension_intro.mp4', 'name' => 'femsa_hipertension_intro.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 91, "attachment_id" => $attach111->id, "type" => "video"]);
        // $attach112 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_hipertension_m1_01.mp4', 'name' => 'femsa_hipertension_m1_01.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 92, "attachment_id" => $attach112->id, "type" => "video"]);
        // $attach113 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_hipertension_m1_02.mp4', 'name' => 'femsa_hipertension_m1_02.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 92, "attachment_id" => $attach113->id, "type" => "video"]);
        // $attach114 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/sanpablo_hipertension_intro.mp4', 'name' => 'sanpablo_hipertension_intro.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 102, "attachment_id" => $attach114->id, "type" => "video"]);
        // $attach115 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/sanpablo_hipertension_m1_p1.mp4', 'name' => 'sanpablo_hipertension_m1_p1.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 103, "attachment_id" => $attach115->id, "type" => "video"]);
        // $attach116 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/sanpablo_hipertension_m1_p2.mp4', 'name' => 'sanpablo_hipertension_m1_p2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 103, "attachment_id" => $attach116->id, "type" => "video"]);
        // $attach117 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/guadalajara_hipertension_intro.mp4', 'name' => 'guadalajara_hipertension_intro.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 113, "attachment_id" => $attach117->id, "type" => "video"]);
        // $attach118 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/guadalajara_hipertension_m1_p1.mp4', 'name' => 'guadalajara_hipertension_m1_p1.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 114, "attachment_id" => $attach118->id, "type" => "video"]);
        // $attach119 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/guadalajara_hipertension_m1_p2.mp4', 'name' => 'guadalajara_hipertension_m1_p2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 114, "attachment_id" => $attach119->id, "type" => "video"]);
        $attach120 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/1b_PAEC_SANOFI_08JUN17.mp4', 'name' => '1b_PAEC_SANOFI_08JUN17.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 71, "attachment_id" => $attach120->id, "type" => "video"]);
        $attach121 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/1c_PAEC_SANOFI_08JUN17.mp4', 'name' => '1c_PAEC_SANOFI_08JUN17.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 71, "attachment_id" => $attach121->id, "type" => "video"]);
        // $attach122 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/ahorro_diabetes_m1_02.mp4', 'name' => 'ahorro_diabetes_m1_02.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 81, "attachment_id" => $attach122->id, "type" => "video"]);
        // $attach123 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/ahorro_diabetes_m1_03.mp4', 'name' => 'ahorro_diabetes_m1_03.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 81, "attachment_id" => $attach123->id, "type" => "video"]);
        // $attach124 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/benavides_diabetes_m4.mp4', 'name' => 'benavides_diabetes_m4.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 84, "attachment_id" => $attach124->id, "type" => "video"]);
        // $attach125 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/benavides_diabetes_m5.mp4', 'name' => 'benavides_diabetes_m5.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 85, "attachment_id" => $attach125->id, "type" => "video"]);
        // $attach126 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/benavides_diabetes_m6.mp4', 'name' => 'benavides_diabetes_m6.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 86, "attachment_id" => $attach126->id, "type" => "video"]);
        // $attach127 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/benavides_diabetes_m7.mp4', 'name' => 'benavides_diabetes_m7.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 87, "attachment_id" => $attach127->id, "type" => "video"]);
        $attach128 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/modulo3b_paec.mp4', 'name' => 'modulo3b_paec.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 73, "attachment_id" => $attach128->id, "type" => "video"]);
        // $attach129 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_obesidad.mp4', 'name' => 'femsa_obesidad.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 100, "attachment_id" => $attach129->id, "type" => "video"]);
        // $attach130 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_obesidad2.mp4', 'name' => 'femsa_obesidad2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 100, "attachment_id" => $attach130->id, "type" => "video"]);
        // $attach131 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_obesidad3.mp4', 'name' => 'femsa_obesidad3.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 100, "attachment_id" => $attach131->id, "type" => "video"]);
        // $attach132 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_obesidad4.mp4', 'name' => 'femsa_obesidad4.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 100, "attachment_id" => $attach132->id, "type" => "video"]);
        // $attach133 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio.mp4', 'name' => 'femsa_dietayejercicio.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 101, "attachment_id" => $attach133->id, "type" => "video"]);
        // $attach134 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio2.mp4', 'name' => 'femsa_dietayejercicio2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 101, "attachment_id" => $attach134->id, "type" => "video"]);
        // $attach135 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio3.mp4', 'name' => 'femsa_dietayejercicio3.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 101, "attachment_id" => $attach135->id, "type" => "video"]);
        // $attach136 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio4.mp4', 'name' => 'femsa_dietayejercicio4.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 101, "attachment_id" => $attach136->id, "type" => "video"]);
        // $attach137 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio5.mp4', 'name' => 'femsa_dietayejercicio5.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 101, "attachment_id" => $attach137->id, "type" => "video"]);
        // $attach138 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio6.mp4', 'name' => 'femsa_dietayejercicio6.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 101, "attachment_id" => $attach138->id, "type" => "video"]);
        // $attach139 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio7.mp4', 'name' => 'femsa_dietayejercicio7.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 101, "attachment_id" => $attach139->id, "type" => "video"]);
        // $attach140 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_hipertension_m3.mp4', 'name' => 'femsa_hipertension_m3.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 94, "attachment_id" => $attach140->id, "type" => "video"]);
        // $attach141 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/guadalajara_hipertension_m3.mp4', 'name' => 'guadalajara_hipertension_m3.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 105, "attachment_id" => $attach141->id, "type" => "video"]);
        // $attach142 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/sanpablo_hipertension_m3.mp4', 'name' => 'sanpablo_hipertension_m3.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 116, "attachment_id" => $attach142->id, "type" => "video"]);
        // $attach143 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/ahorro_diabetes_m3.mp4', 'name' => 'ahorro_diabetes_m3.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 83, "attachment_id" => $attach143->id, "type" => "video"]);
        // $attach144 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/ahorro_diabetes_m3_02.mp4', 'name' => 'ahorro_diabetes_m3_02.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 83, "attachment_id" => $attach144->id, "type" => "video"]);
        // $attach145 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/ahorro_diabetes_m4.mp4', 'name' => 'ahorro_diabetes_m4.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 84, "attachment_id" => $attach145->id, "type" => "video"]);
        // $attach146 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/ahorro_diabetes_m5.mp4', 'name' => 'ahorro_diabetes_m5.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 85, "attachment_id" => $attach146->id, "type" => "video"]);
        // $attach147 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/ahorro_diabetes_m6.mp4', 'name' => 'ahorro_diabetes_m6.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 86, "attachment_id" => $attach147->id, "type" => "video"]);
        // $attach148 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/ahorro_diabetes_m7.mp4', 'name' => 'ahorro_diabetes_m7.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 87, "attachment_id" => $attach148->id, "type" => "video"]);
        // $attach149 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/ahorro_mod9.mp4', 'name' => 'ahorro_mod9.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 89, "attachment_id" => $attach149->id, "type" => "video"]);
        // $attach150 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod10.mp4', 'name' => 'mod10.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 80, "attachment_id" => $attach150->id, "type" => "video"]);
        // $attach151 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/ahorro_mod10.mp4', 'name' => 'ahorro_mod10.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 90, "attachment_id" => $attach151->id, "type" => "video"]);
        // $attach152 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_obesidad.mp4', 'name' => 'femsa_obesidad.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 111, "attachment_id" => $attach152->id, "type" => "video"]);
        // $attach153 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_obesidad2.mp4', 'name' => 'femsa_obesidad2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 111, "attachment_id" => $attach153->id, "type" => "video"]);
        // $attach154 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_obesidad3.mp4', 'name' => 'femsa_obesidad3.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 111, "attachment_id" => $attach154->id, "type" => "video"]);
        // $attach155 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_obesidad4.mp4', 'name' => 'femsa_obesidad4.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 111, "attachment_id" => $attach155->id, "type" => "video"]);
        // $attach156 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio.mp4', 'name' => 'femsa_dietayejercicio.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 112, "attachment_id" => $attach156->id, "type" => "video"]);
        // $attach157 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio2.mp4', 'name' => 'femsa_dietayejercicio2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 112, "attachment_id" => $attach157->id, "type" => "video"]);
        // $attach158 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio3.mp4', 'name' => 'femsa_dietayejercicio3.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 112, "attachment_id" => $attach158->id, "type" => "video"]);
        // $attach159 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio4.mp4', 'name' => 'femsa_dietayejercicio4.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 112, "attachment_id" => $attach159->id, "type" => "video"]);
        // $attach160 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio5.mp4', 'name' => 'femsa_dietayejercicio5.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 112, "attachment_id" => $attach160->id, "type" => "video"]);
        // $attach161 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio6.mp4', 'name' => 'femsa_dietayejercicio6.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 112, "attachment_id" => $attach161->id, "type" => "video"]);
        // $attach162 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio7.mp4', 'name' => 'femsa_dietayejercicio7.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 112, "attachment_id" => $attach162->id, "type" => "video"]);
        // $attach163 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_obesidad.mp4', 'name' => 'femsa_obesidad.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 122, "attachment_id" => $attach163->id, "type" => "video"]);
        // $attach164 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_obesidad2.mp4', 'name' => 'femsa_obesidad2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 122, "attachment_id" => $attach164->id, "type" => "video"]);
        // $attach165 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_obesidad3.mp4', 'name' => 'femsa_obesidad3.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 122, "attachment_id" => $attach165->id, "type" => "video"]);
        // $attach166 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_obesidad4.mp4', 'name' => 'femsa_obesidad4.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 122, "attachment_id" => $attach166->id, "type" => "video"]);
        // $attach167 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio.mp4', 'name' => 'femsa_dietayejercicio.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 123, "attachment_id" => $attach167->id, "type" => "video"]);
        // $attach168 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio2.mp4', 'name' => 'femsa_dietayejercicio2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 123, "attachment_id" => $attach168->id, "type" => "video"]);
        // $attach169 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio3.mp4', 'name' => 'femsa_dietayejercicio3.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 123, "attachment_id" => $attach169->id, "type" => "video"]);
        // $attach170 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio4.mp4', 'name' => 'femsa_dietayejercicio4.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 123, "attachment_id" => $attach170->id, "type" => "video"]);
        // $attach171 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio5.mp4', 'name' => 'femsa_dietayejercicio5.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 123, "attachment_id" => $attach171->id, "type" => "video"]);
        // $attach172 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio6.mp4', 'name' => 'femsa_dietayejercicio6.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 123, "attachment_id" => $attach172->id, "type" => "video"]);
        // $attach173 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/femsa_dietayejercicio7.mp4', 'name' => 'femsa_dietayejercicio7.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 123, "attachment_id" => $attach173->id, "type" => "video"]);
        $attach174 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Pie_Diabetico_001.mp4', 'name' => 'Pie_Diabetico_001.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 124, "attachment_id" => $attach174->id, "type" => "video"]);
        $attach175 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Pie_Diabetico_002.mp4', 'name' => 'Pie_Diabetico_002.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 124, "attachment_id" => $attach175->id, "type" => "video"]);
        $attach176 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/1a_Retinopatia_pt1.mp4', 'name' => '1a_Retinopatia_pt1.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 125, "attachment_id" => $attach176->id, "type" => "video"]);
        $attach177 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/1b_Retinopatia_pt2.mp4', 'name' => '1b_Retinopatia_pt2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 125, "attachment_id" => $attach177->id, "type" => "video"]);
        $attach178 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_001.mp4', 'name' => 'Nefropatia_001.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 126, "attachment_id" => $attach178->id, "type" => "video"]);
        $attach179 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_002.mp4', 'name' => 'Nefropatia_002.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 126, "attachment_id" => $attach179->id, "type" => "video"]);
        $attach180 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_003.mp4', 'name' => 'Nefropatia_003.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 126, "attachment_id" => $attach180->id, "type" => "video"]);
        $attach181 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_004.mp4', 'name' => 'Nefropatia_004.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 126, "attachment_id" => $attach181->id, "type" => "video"]);
        $attach182 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_005.mp4', 'name' => 'Nefropatia_005.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 126, "attachment_id" => $attach182->id, "type" => "video"]);
        // $attach183 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Pie_Diabetico_001.mp4', 'name' => 'Pie_Diabetico_001.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 127, "attachment_id" => $attach183->id, "type" => "video"]);
        // $attach184 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Pie_Diabetico_002.mp4', 'name' => 'Pie_Diabetico_002.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 127, "attachment_id" => $attach184->id, "type" => "video"]);
        // $attach185 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/1a_Retinopatia_pt1.mp4', 'name' => '1a_Retinopatia_pt1.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 128, "attachment_id" => $attach185->id, "type" => "video"]);
        // $attach186 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/1b_Retinopatia_pt2.mp4', 'name' => '1b_Retinopatia_pt2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 128, "attachment_id" => $attach186->id, "type" => "video"]);
        // $attach187 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_001.mp4', 'name' => 'Nefropatia_001.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 129, "attachment_id" => $attach187->id, "type" => "video"]);
        // $attach188 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_002.mp4', 'name' => 'Nefropatia_002.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 129, "attachment_id" => $attach188->id, "type" => "video"]);
        // $attach189 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_003.mp4', 'name' => 'Nefropatia_003.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 129, "attachment_id" => $attach189->id, "type" => "video"]);
        // $attach190 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_004.mp4', 'name' => 'Nefropatia_004.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 129, "attachment_id" => $attach190->id, "type" => "video"]);
        // $attach191 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Nefropatia_005.mp4', 'name' => 'Nefropatia_005.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 129, "attachment_id" => $attach191->id, "type" => "video"]);
        $attach192 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Pie_Diabetico_003.mp4', 'name' => 'Pie_Diabetico_003.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 124, "attachment_id" => $attach192->id, "type" => "video"]);
        $attach193 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Pie_Diabetico_004.mp4', 'name' => 'Pie_Diabetico_004.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 124, "attachment_id" => $attach193->id, "type" => "video"]);
        // $attach194 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Pie_Diabetico_003.mp4', 'name' => 'Pie_Diabetico_003.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 127, "attachment_id" => $attach194->id, "type" => "video"]);
        // $attach195 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/Pie_Diabetico_004.mp4', 'name' => 'Pie_Diabetico_004.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 127, "attachment_id" => $attach195->id, "type" => "video"]);
        // $attach196 = Attachment::create(['type' => 'video', 'url' => 'storage/videos/diabetesMod8.mp4', 'name' => 'diabetesMod8.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 88, "attachment_id" => $attach196->id, "type" => "video"]);
        $attach197 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/2b_PAEC_SANOFI_06JUN17.mp4', 'name' => '2b_PAEC_SANOFI_06JUN17.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 72, "attachment_id" => $attach197->id, "type" => "video"]);
        $attach198 = Attachment::create(['type' => 'video', 'url' => 'storage/video/diabetes/mod7parte2.mp4', 'name' => 'mod7parte2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 77, "attachment_id" => $attach198->id, "type" => "video"]);
        // $attach199 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/PAEC_Sincronizacion_IntroHiptertension_11agosto2017.mp4', 'name' => 'PAEC_Sincronizacion_IntroHiptertension_11agosto2017.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 130, "attachment_id" => $attach199->id, "type" => "video"]);
        // $attach200 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/DR_Fernandez_hipertension_Generalidades_12sep.mp4', 'name' => 'DR_Fernandez_hipertension_Generalidades_12sep.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 131, "attachment_id" => $attach200->id, "type" => "video"]);
        // $attach201 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/DR_Fernandez_hipertension_12sep.mp4', 'name' => 'DR_Fernandez_hipertension_12sep.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        // Resource::create(["module_id" => 131, "attachment_id" => $attach201->id, "type" => "video"]);
        $attach202 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/PAEC_Sincronizacion_IntroHiptertension_11agosto2017.mp4', 'name' => 'PAEC_Sincronizacion_IntroHiptertension_11agosto2017.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 132, "attachment_id" => $attach202->id, "type" => "video"]);
        $attach203 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/DR_Fernandez_hipertension_Generalidades_12sep.mp4', 'name' => 'DR_Fernandez_hipertension_Generalidades_12sep.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 133, "attachment_id" => $attach203->id, "type" => "video"]);
        $attach204 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/DR_Fernandez_hipertension_12sep.mp4', 'name' => 'DR_Fernandez_hipertension_12sep.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 133, "attachment_id" => $attach204->id, "type" => "video"]);
        $attach205 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/cardio_modulo2.mp4', 'name' => 'cardio_modulo2.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 134, "attachment_id" => $attach205->id, "type" => "video"]);
        $attach206 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/cardio_m3.mp4', 'name' => 'cardio_m3.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 135, "attachment_id" => $attach206->id, "type" => "video"]);
        $attach207 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/cardio_m4.mp4', 'name' => 'cardio_m4.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 136, "attachment_id" => $attach207->id, "type" => "video"]);
        $attach208 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/cardio_m4_2_caso_clinico.mp4', 'name' => 'cardio_m4_2_caso_clinico.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 136, "attachment_id" => $attach208->id, "type" => "video"]);
        $attach209 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/hipertension_mod5.mp4', 'name' => 'hipertension_mod5.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 137, "attachment_id" => $attach209->id, "type" => "video"]);
        $attach210 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/mod2_Hipertension_Caso_clinico_Dr_Diaz.mp4', 'name' => 'mod2_Hipertension_Caso_clinico_Dr_Diaz.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 138, "attachment_id" => $attach210->id, "type" => "video"]);
        $attach211 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/modulo_que_hago_con_mi_paciente_con_HTA.mp4', 'name' => 'modulo_que_hago_con_mi_paciente_con_HTA.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 139, "attachment_id" => $attach211->id, "type" => "video"]);
        $attach212 = Attachment::create(['type' => 'video', 'url' => 'storage/video/hinpertension/cierre_modulo.mp4', 'name' => 'cierre_modulo.mp4', 'mimetype' => 'video/mp4', 'type' => 'video']);
        Resource::create(["module_id" => 140, "attachment_id" => $attach212->id, "type" => "video"]);


        /** Imágenes de los módulos */
        $attach10000 = Attachment::create(["type" => "main_img", "url" => "storage/img/insomnio/m_prevalencia.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10000->id, "module_id" => 1]);
        $attach10001 = Attachment::create(["type" => "main_img", "url" => "storage/img/insomnio/m_opciones.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10001->id, "module_id" => 2]);
        $attach10002 = Attachment::create(["type" => "main_img", "url" => "storage/img/insomnio/m_insomnio.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10002->id, "module_id" => 3]);
        $attach10003 = Attachment::create(["type" => "main_img", "url" => "storage/img/insomnio/m_perfil.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10003->id, "module_id" => 4]);
        $attach10004 = Attachment::create(["type" => "main_img", "url" => "storage/img/insomnio/m_comorbilidades.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10004->id, "module_id" => 5]);
        $attach10005 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/m1_icon.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10005->id, "module_id" => 6]);
        $attach10006 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/m2_icon.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10006->id, "module_id" => 7]);
        $attach10007 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/pie-diabetico-OE-Dig-06.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10007->id, "module_id" => 8]);
        $attach10008 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/retinopia-OE-Dig-05.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10008->id, "module_id" => 9]);
        $attach10009 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/nefropatia-OE-Dig-07.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10009->id, "module_id" => 10]);
        $attach10010 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/obesidad-OE-Dig-08.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10010->id, "module_id" => 11]);
        $attach10011 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/modulo3_icono_linea.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10011->id, "module_id" => 12]);
        $attach10012 = Attachment::create(["type" => "main_img", "url" => "storage/img/insomnio/m_prevalencia.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10012->id, "module_id" => 13]);
        $attach10013 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/m4.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10013->id, "module_id" => 14]);
        $attach10014 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/m5.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10014->id, "module_id" => 15]);
        $attach10015 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/m6.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10015->id, "module_id" => 16]);
        $attach10016 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/m7.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10016->id, "module_id" => 17]);
        $attach10017 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/m8.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10017->id, "module_id" => 18]);
        $attach10018 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/m9.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10018->id, "module_id" => 19]);
        $attach10019 = Attachment::create(["type" => "main_img", "url" => "storage/img/diabetes/m10.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10019->id, "module_id" => 20]);
        $attach10020 = Attachment::create(["type" => "main_img", "url" => "storage/img/hipertension/mod01.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10020->id, "module_id" => 21]);
        $attach10021 = Attachment::create(["type" => "main_img", "url" => "storage/img/hipertension/mod02.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10021->id, "module_id" => 22]);
        $attach10022 = Attachment::create(["type" => "main_img", "url" => "storage/img/hipertension/mod03.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10022->id, "module_id" => 23]);
        $attach10023 = Attachment::create(["type" => "main_img", "url" => "storage/img/hipertension/mod04.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10023->id, "module_id" => 24]);
        $attach10024 = Attachment::create(["type" => "main_img", "url" => "storage/img/hipertension/mod05.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10024->id, "module_id" => 25]);
        $attach10025 = Attachment::create(["type" => "main_img", "url" => "storage/img/hipertension/mod06.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10025->id, "module_id" => 26]);
        $attach10026 = Attachment::create(["type" => "main_img", "url" => "storage/img/hipertension/mod07.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10026->id, "module_id" => 27]);
        $attach10027 = Attachment::create(["type" => "main_img", "url" => "storage/img/hipertension/mod08.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10027->id, "module_id" => 28]);
        $attach10028 = Attachment::create(["type" => "main_img", "url" => "storage/img/hipertension/mod09.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10028->id, "module_id" => 29]);
        $attach10029 = Attachment::create(["type" => "main_img", "url" => "storage/img/trombosis/trombosisCifras_Icon.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10029->id, "module_id" => 30]);
        $attach10030 = Attachment::create(["type" => "main_img", "url" => "storage/img/trombosis/evaluacionRiesgo_Icon.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10030->id, "module_id" => 31]);
        $attach10031 = Attachment::create(["type" => "main_img", "url" => "storage/img/trombosis/tromboembolia_Icon.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10031->id, "module_id" => 32]);
        $attach10032 = Attachment::create(["type" => "main_img", "url" => "storage/img/trombosis/tromboEmboliaPulmonar_Icon.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10032->id, "module_id" => 33]);
        $attach10033 = Attachment::create(["type" => "main_img", "url" => "storage/img/trombosis/sindromesCoronarios_Icon.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10033->id, "module_id" => 34]);
        $attach10034 = Attachment::create(["type" => "main_img", "url" => "storage/img/trombosis/tratamientoPaciente_Icon.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10034->id, "module_id" => 35]);
        $attach10035 = Attachment::create(["type" => "main_img", "url" => "storage/img/trombosis/icono_infartoagudo_blanco.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10035->id, "module_id" => 36]);
        $attach10036 = Attachment::create(["type" => "main_img", "url" => "storage/img/lipid/Modulo-1.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10036->id, "module_id" => 37]);
        $attach10037 = Attachment::create(["type" => "main_img", "url" => "storage/img/lipid/Modulo-2.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10037->id, "module_id" => 38]);
        $attach10038 = Attachment::create(["type" => "main_img", "url" => "storage/img/lipid/Modulo-3.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10038->id, "module_id" => 39]);
        $attach10039 = Attachment::create(["type" => "main_img", "url" => "storage/img/lipid/Modulo-4.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10039->id, "module_id" => 40]);
        $attach10040 = Attachment::create(["type" => "main_img", "url" => "storage/img/lipid/Modulo-5.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10040->id, "module_id" => 41]);
        $attach10041 = Attachment::create(["type" => "main_img", "url" => "storage/img/lipid/Modulo-6.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10041->id, "module_id" => 42]);
        $attach10042 = Attachment::create(["type" => "main_img", "url" => "storage/img/lipid/Modulo-7.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10042->id, "module_id" => 43]);
        $attach10043 = Attachment::create(["type" => "main_img", "url" => "storage/img/lipid/Modulo-8.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10043->id, "module_id" => 44]);
        $attach10044 = Attachment::create(["type" => "main_img", "url" => "storage/img/lipid/Modulo-9.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10044->id, "module_id" => 45]);
        $attach10045 = Attachment::create(["type" => "main_img", "url" => "storage/img/lipid/Modulo-10.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10045->id, "module_id" => 46]);
        $attach10046 = Attachment::create(["type" => "main_img", "url" => "storage/img/eem/cc1.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10046->id, "module_id" => 47]);
        $attach10047 = Attachment::create(["type" => "main_img", "url" => "storage/img/eem/cc2.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10047->id, "module_id" => 48]);
        $attach10048 = Attachment::create(["type" => "main_img", "url" => "storage/img/eem/cc1.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10048->id, "module_id" => 49]);

        $attach10100 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/diabetes/mod01.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10100->id, "module_id" => 71]);
        $attach10101 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/diabetes/mod02.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10101->id, "module_id" => 72]);
        $attach10102 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/diabetes/mod03.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10102->id, "module_id" => 73]);
        $attach10103 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/diabetes/mod04.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10103->id, "module_id" => 74]);
        $attach10104 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/diabetes/mod05.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10104->id, "module_id" => 75]);
        $attach10105 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/diabetes/mod06.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10105->id, "module_id" => 76]);
        $attach10106 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/diabetes/mod07.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10106->id, "module_id" => 77]);
        $attach10107 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/diabetes/mod08.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10107->id, "module_id" => 78]);
        $attach10108 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/diabetes/mod09.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10108->id, "module_id" => 79]);
        $attach10109 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/diabetes/mod10.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10109->id, "module_id" => 80]);
        $attach10110 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/diabetes/54.png ", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10110->id, "module_id" => 124]);
        $attach10111 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/diabetes/55.png ", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10111->id, "module_id" => 125]);
        $attach10112 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/diabetes/56.png ", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10112->id, "module_id" => 126]);
        $attach10113 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/hipertension/mod.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10113->id, "module_id" => 132]);
        $attach10114 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/hipertension/mod1.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10114->id, "module_id" => 133]);
        $attach10115 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/hipertension/mod2.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10115->id, "module_id" => 134]);
        $attach10116 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/hipertension/mod3.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10116->id, "module_id" => 135]);
        $attach10117 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/hipertension/mod4.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10117->id, "module_id" => 136]);
        $attach10118 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/hipertension/mod5.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10118->id, "module_id" => 137]);
        $attach10119 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/hipertension/mod6.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10119->id, "module_id" => 138]);
        $attach10120 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/hipertension/mod7.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10120->id, "module_id" => 139]);
        $attach10121 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/hipertension/mod8.png", "mimetype" => "image/png"]);
        AttachmentModule::create(["attachment_id" => $attach10121->id, "module_id" => 140]);


        $moduleCC = Module::create(['name' => 'Caso Clínico 1', 'course_id' => $course1->id]); // Caso clínico
        $attach5000 = Attachment::create(['type' => 'main_img', 'url' => 'storage/img/insomnio/btns_CasosClinicos.png', 'mimetype' => 'image/png']);
        AttachmentModule::create(["attachment_id" => $attach5000->id, "module_id" => $moduleCC->id]);
        $attach5001 = Attachment::create(['type' => 'video', 'url' => 'storage/video/cc01/v1.mp4', 'name' => 'v1.mp4', 'mimetype' => 'video/mp4']);
        Resource::create(["module_id" => $moduleCC->id, "attachment_id" => $attach5001->id, 'type' => 'video']);
        $attach5002 = Attachment::create(['type' => 'video', 'url' => 'storage/video/cc01/v2.mp4', 'name' => 'v2.mp4', 'mimetype' => 'video/mp4']);
        Resource::create(["module_id" => $moduleCC->id, "attachment_id" => $attach5002->id, 'type' => 'video']);
        $attach5003 = Attachment::create(['type' => 'video', 'url' => 'storage/video/cc01/v3.mp4', 'name' => 'v3.mp4', 'mimetype' => 'video/mp4']);
        Resource::create(["module_id" => $moduleCC->id, "attachment_id" => $attach5003->id, 'type' => 'video']);
        $attach5004 = Attachment::create(['type' => 'video', 'url' => 'storage/video/cc01/v4.mp4', 'name' => 'v4.mp4', 'mimetype' => 'video/mp4']);
        Resource::create(["module_id" => $moduleCC->id, "attachment_id" => $attach5004->id, 'type' => 'video']);
        
        
        /** Imágenes de los cursos (PAECS) */
        $attach20000 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/paec/ic1_insomnio.png", "mimetype" => "image/png"]);
        AttachmentCourse::create(["attachment_id" => $attach20000->id, "course_id" => 1]);
        $attach20001 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/paec/ic8_diabetes.png", "mimetype" => "image/png"]);
        AttachmentCourse::create(["attachment_id" => $attach20001->id, "course_id" => 2]);
        $attach20002 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/paec/hipertension_main.png", "mimetype" => "image/png"]);
        AttachmentCourse::create(["attachment_id" => $attach20002->id, "course_id" => 3]);
        $attach20003 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/paec/trombosis.png", "mimetype" => "image/png"]);
        AttachmentCourse::create(["attachment_id" => $attach20003->id, "course_id" => 4]);
        $attach20004 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/paec/iconoLipid.png", "mimetype" => "image/png"]);
        AttachmentCourse::create(["attachment_id" => $attach20004->id, "course_id" => 5]);
        $attach20005 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/paec/EsclerosisMultiple.png", "mimetype" => "image/png"]);
        AttachmentCourse::create(["attachment_id" => $attach20005->id, "course_id" => 6]);
        
        $attach20100 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/logosPaecs/diabetes.png", "mimetype" => "image/png"]);
        AttachmentCourse::create(["attachment_id" => $attach20100->id, "course_id" => 7]);
        $attach20101 = Attachment::create(["type" => "main_img", "url" => "storage/farmacias/img/logosPaecs/hipertension.png", "mimetype" => "image/png"]);
        AttachmentCourse::create(["attachment_id" => $attach20101->id, "course_id" => 8]);


        /** Imágenes de las farmacias */
        $attach325 = Attachment::create(['type' => 'main_img', 'url' => 'storage/farmacias/logosFarmacias/logoFarmaciasBenavides.png', 'name' => 'logoFarmaciasBenavides.png', 'mimetype' => 'image/png']);
        AscriptionAttachment::create(["ascription_id" => 7, "attachment_id" => $attach325->id]);
        $attach326 = Attachment::create(['type' => 'main_img', 'url' => 'storage/farmacias/logosFarmacias/Logo_FarmaciasdelAhorro.png', 'name' => 'Logo_FarmaciasdelAhorro.png', 'mimetype' => 'image/png']);
        AscriptionAttachment::create(["ascription_id" => 8, "attachment_id" => $attach326->id]);
        $attach327 = Attachment::create(['type' => 'main_img', 'url' => 'storage/farmacias/logosFarmacias/Logo_YZA.png', 'name' => 'Logo_YZA.png', 'mimetype' => 'image/png']);
        AscriptionAttachment::create(["ascription_id" => 9, "attachment_id" => $attach327->id]);
        $attach328 = Attachment::create(['type' => 'main_img', 'url' => 'storage/farmacias/logosFarmacias/Logo_San_Pablo.png', 'name' => 'Logo_San_Pablo.png', 'mimetype' => 'image/png']);
        AscriptionAttachment::create(["ascription_id" => 10, "attachment_id" => $attach328->id]);
        $attach329 = Attachment::create(['type' => 'main_img', 'url' => 'storage/farmacias/logosFarmacias/Logo_FRAGUA.png', 'name' => 'Logo_FRAGUA.png', 'mimetype' => 'image/png']);
        AscriptionAttachment::create(["ascription_id" => 11, "attachment_id" => $attach329->id]);
        $attach330 = Attachment::create(['type' => 'main_img', 'url' => 'storage/farmacias/logosFarmacias/logoFarmaciaNadro.png', 'name' => 'logoFarmaciaNadro.png', 'mimetype' => 'image/png']);
        AscriptionAttachment::create(["ascription_id" => 12, "attachment_id" => $attach330->id]);
        
        Expert::create(['name' => 'Dr. Alejandro Jiménez Genchi', 'slug' => str_slug('Dr. Alejandro Jiménez Genchi'), 'summary' => '<ul>
        <li>Clínica de Sue&ntilde;o</li>
        <li>Médico Psiquiatra, Maestro en Psiquiatría</li>
        <li>Investigador nivel II, Sistema Nacional de Investigadores</li>
        <li>Instituto Nacional de Psiquiatría Ramón de la Fuente</li>
        </ul>']);
        Expert::create(['name' => 'Dr. Edilberto Peña de León', 'slug' => str_slug('Dr. Edilberto Peña de León'), 'summary' => '<ul>
        <li>
        Neuropsiquiatra
        </li>
        <li>
        Maestro en Ciencias Médicas
        </li>
        <li>
        Director de Investigación</li>
        <li>
        Instituto de Neurociencias, Investigación y Desarrollo Emocional
        </li>
        </ul>']);
        Expert::create(['name' => 'Dr. Rafael Solano', 'slug' => str_slug('Dr. Rafael Solano'), 'summary' => '<ul>
        <li>
        Ginecología y Obstetricia
        </li>
        <li>
        Urología Ginecológica
        </li>
        <li>
        Doctor en Ciencias
        </li>
        </ul>']);
        Expert::create(['name' => 'Dr. Jorge Aldrete', 'slug' => str_slug('Dr. Jorge Aldrete'), 'summary' => '<ul>
        <li>Médico internista e investigador clínico</li>
        <li>Editor e investigador principal en Paracelsus, S. A.</li>
        <li>Expresidente del Colegio de Medicina Interna de México (2016)</li>
        </ul>']);
        Expert::create(['name' => 'Dra. Patricia Mehner Karam', 'slug' => str_slug('Dra. Patricia Mehner Karam'), 'summary' => '<p>Médica Cirujana certificada como Médico General, candidata a examen de grado académico para obtener el título de maestría en Nutriología Aplicada, especialista en Obesidad y Comorbilidades, educadora en Diabetes certificada, cursando actualmente el curso de entrenadores en diabetes de la Clínica Joslin.</p>
        <p>Dedicada a la práctica clínica de consulta privada desde hace 20 a&ntilde;os, a la docencia en varios diplomados de formación de Educadores en Diabetes en la República Mexicana desde hace 19 a&ntilde;os y en la maestría de Heridas y Estomas en la UP desde hace 6 a&ntilde;os.</p>
        <p>Miembro de la <em>Professional Section</em> de la American Diabetes Association. Asesora, voluntaria y conferencista de Instituciones Nacionales e Internacionales dedicadas a la atención de la salud y la Diabetes.</p>
        <p>Miembro fundador del Consejo Nacional de Educadores en Diabetes, A.C. (CONED), Secretaria de Exámenes, Presidenta y actualmente parte del Consejo Consultivo del CONED. Forma parte del Consejo Consultivo Médico de la Asociación Mexicana de Diabetes. Participa activamente como consultora y ha representado a la Federación Mexicana de Diabetes para la actualización de la NOM de dislipidemias y de hipertensión arterial.</p>']);
        Expert::create(['name' => 'Dr. Oscar Lozano Castañeda', 'slug' => str_slug('Dr. Oscar Lozano Castañeda'), 'summary' => '<p>El Dr. Oscar Lozano Castañeda es especialista en Endocrinología egresado del Consejo Mexicano de Endocrinología. Atiende a sus pacientes en el Hospital Ángeles Lomas ubicado en el municipio Huixquilucan de Degollado en el Estado de México.</p>
        <p>Educación<br/>1955 - Licenciatura como Médico Cirujano<br/>2001 - Especialidad en Endocrinología</p><p>Estudió en:<br/>Consejo Mexicano de Endocrinología<br/>UNAM - Universidad Nacional Autónoma de México</p><p>Especialidades:<br/>Endocrinología</p>']);
        Expert::create(['name' => 'Dra. Maria Guadalupe Castro Martínez', 'slug' => str_slug('Dra. Maria Guadalupe Castro Martínez'), 'summary' => '<p>Licenciatura de Médico Cirujano. Escuela Mexicana de Medicina. Universidad la Salle, Promedio obtenido 9.7, graduada con Mención Honorífica.</p><p>Especialidad de Medicina Interna. Hospital General. CMN .IMSS.</p><p>Primera mujer como Jefe de Residentes del Curso de la Especialidad en Medicina Interna. CMN.IMSS.</p><p>Certificación  vigente de Medicina Interna.</p>']);
        Expert::create(['name' => 'Dr. J. Abel Ramírez Estudillo', 'slug' => str_slug('Dr. J. Abel Ramírez Estudillo'), 'summary' => '<p>El Dr. Ramírez Estudillo es un destacado Oftalmólogo con más de 20 años de experiencia. Egresó de la Universidad Nacional Autónoma de México (UNAM) como Médico Cirujano para posteriormente realizar la Especialidad en Oftalmología en esta misma institución. Entre los padecimientos que trata se encuentran: Retinopatía Diabética, Desprendimiento de Retina, Trauma Ocular, Catarata, Degeneración Macular, Oclusiones Vasculares de la Retina, entre otros.</p>
        <p>Experiencia profesional<br>• Más de 20 años de experiencia<br>• Oftalmólogo. Hospital Ángeles Metropolitano</p>
        <p>Logros académicos destacados<br>• Médico Cirujano. Universidad Nacional Autónoma de México (UNAM). México, Distrito Federal. 1998<br>• Especialidad. Oftalmología. UNAM. México, Distrito Federal. 2005</p>']);
        Expert::create(['name' => 'Dr. Antonio González Chávez', 'slug' => str_slug('Dr. Antonio González Chávez'), 'summary' => '<p>Esp. Medicina Interna <br>Coordinador del Grupo de Estudio Mexicano del Síndrome Metabólico<br>Ex – Presidente de la Federación Mexicana de Diabetes (FMD)<br>Ex – Presidente del Colegio de Medicina Interna de México (CMIM)<br>Ex – Presidente de la Sociedad Médica del Hospital General de México<br>Ex – Delegado 2007-2010 de la Asociación Latinoamericana de Diabetes (ALAD)<br>Jefe del Servicio de Medicina Interna del Hospital General de México<br>Investigador de los Institutos de Salud<br>Profesor Universitario de la Facultad de Medicina de la UNAM<br>FELLOW American College of Physicians</p>']);
        Expert::create(['name' => 'Dr. Guillermo Fanghänel Salmón', 'slug' => str_slug('Dr. Guillermo Fanghänel Salmón'), 'summary' => '<p>El Dr. Fanghänel nace en la Ciudad de Culiacán, Sin., el 25 de abril de 1945, realiza sus estudios profesionales en la Facultad de Medicina de la Universidad Nacional Autónoma de México, egresando con mención honorífica. Realiza su primera especialidad en Medicina Interna en el Hospital General de México, en los años de 1970-1974, concluyendo como residente de quinto año con mención de distinción. En 1974 ingresa al Instituto Nacional de la Nutrición "Salvador Zubirán", donde realiza su segunda especialidad en Nutrición y Endocrinología, egresando en 1976 con mención honorífica. En 1976 ingresa como médico de base al Servicio de Medicina Interna en el Hospital General de México.</p><p>Durante 1976 y 1977 es profesor titular del Curso de Introducción a la Especialidad en la Universidad Autónoma de México. En 1977 funda la Dirección General de Enseñanza de la Secretaría de Salubridad y Asistencia, hoy Secretaría de Salud, puesto que desempeña hasta 1978. Tiene a su cargo durante esta época diseñar, estructurar y realizar el primer examen para aspirantes a la residencia médica del país. En 1978 regresa al Hospital General de México y tiene la oportunidad de fundar el Servicio de Endocrinología en la Unidad 404B antes pabellón 29, siendo jefe de este departamento hasta el momento actual. Durante 1983-1985 fue Director de Investigación en el Hospital General de México. En 1985 y 1986 realizó un Posgrado en la Universidad de Tulane en Nueva Orleans a cargo del Dr. Andrew V Schally, premio Nobel en Medicina.</p>']);
        Expert::create(['name' => 'Dr. Rafael Campuzano Rodríguez ', 'slug' => str_slug('Dr. Rafael Campuzano Rodríguez '), 'summary' => '<p>
        Secretario de la Sociedad Mexicana de Nutrición y Endocrinología.
        <br />
        Secretario del Consejo Mexicano de Endocrinología.
        </p>']);
        Expert::create(['name' => 'Dr. Fernando Javier Lavalle González', 'slug' => str_slug('Dr. Fernando Javier Lavalle González'), 'summary' => '<p>
        Profesor del Facultad de Medicina de la UANL: Endocrinología, Medicina Interna y Nutrición.
        <br />
        Coordinador de Enseñanza de pre y Pos Grado del Servicio de Endrocrinología, Hospital Universitario, UANL.
        <br />
        Coordinador de la Clínica de Diabetes del Hospital Universitario “Dr. José E. González” UANL.
        <br />
        Endocrinólogo del Hospital Regional de Monterrey del ISSSTE.
        <br />
        Coordinador del Grupo de Políticas de Tratamiento para la Diabetes de la Norma Oficial Mexicana.
        <br />
        Coordinador Estatal del Programa de Alimentación Saludable y Actividad Física para la Prevención de la Obesidad y Sobrepeso.        
        </p>']);
        Expert::create(['name' => 'Dr. René Rodríguez Gutiérrez', 'slug' => str_slug('Dr. René Rodríguez Gutiérrez'), 'summary' => '<p>
        Assistant Professor of Medicine. Mayo Clinic Medical School, Mayo Clinic, Rochester,
        International Research Collaborator. Division of Endocrinology, Diabetes, Metabolism and Nutrition. Knowledge and Evaluation Research Unit. Mayo Clinic Medical School.
        <br />
        Profesor de Medicina. Facultad de Medicina y Hospital Universitario “Dr. Jose E.
        Gonzalez”, Universidad Autonoma de Nuevo Leon. Monterrey, Mexico. 2016-
        Presente.
        <br />
        Miembro Sistema Nacional de Investigadores Nivel 1. Sistema Nacional de
        Investigadores, Consejo Nacional de Ciencia y Tecnología (CONACYT).
        </p>']);
        Expert::create(['name' => 'Dr. Guillermo  González Gálvez', 'slug' => str_slug('Dr. Guillermo  González Gálvez'), 'summary' => '<p>Investigador principal desde 1998 en más de 120 ensayos clínicos fase II, III y IV en el área de diabetes, obesidad, dislipidemia, hipertensión, seguridad cardiovascular de nuevos medicamentos para diabetes y problemas endocrinológicos.</p>']);
        Expert::create(['name' => 'Dr. Luis Alcocer Díaz Barreiro', 'slug' => str_slug('Dr. Luis Alcocer Díaz Barreiro'), 'summary' => '<p><b>Actualmente</b></p>
        <dl>
        <dd>Director General Instituto Mexicano de Salud Cardiovascular.</dd>
        <dd>Vicepresidente Interamerican Society of Hypertension</dd>
        </dl>        
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Médico Cirujano, Facultad de Medicina, Universidad Nacional Autónoma de México</dd>
        <dd>Cardiólogo. Certificado por el Consejo Mexicano de Cardiología</dd>
        <dd>Maestro en Administración de Hospitales y Salud Pública. IESAP</dd>
        <dd>Miembro titular. Sociedad Mexicana de Cardiología. 1969.</dd>
        </dl>        
        <p><b>Destacado: </b></p>
        <dl>
        <dd>Publicación de libros, capítulos, monografías y revistas médicas</dd>
        <dd>Docencia, cursos y congresos (978)  </dd>
        <dd>Tesis dirigidas y asesor de tesis de Postgrado </dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Carlos Fernández Barros', 'slug' => str_slug('Dr. Carlos Fernández Barros'), 'summary' => '<p><b>Actualmente: </b></p>
        <dl>
        <dd>El Dr. Carlos Leonardo Fernández Barros es actualmente Delegado en Coahuila del Capítulo México de Latinamerican Society of Hypertension (LASH) y trabaja actualmente como Cardiólogo Clínico en el Hospital Los ángeles de la Ciudad de Torreón, Coahuila, México.</dd></dl>
        <p><b>Estudios: </b></p>
        <dl>
        <dd>Licenciatura en la Facultad de Medicina de la UNAM.</dd>
        <dd>Estudios de postgrado de Medicina Interna en el Instituto Nacional de ciencias Médicas y Nutrición &quot;Salvador Zubirán&quot;. </dd>
        <dd>Estudios de Cardiología en el Instituto Nacional de Cardiología &quot;Ignacio Chávez&quot; en Destacado como Jefe de Médicos Residentes y Certificado por el Consejo Mexicano de Cardiología desde 1984.</dd>
        </dl>        
        <p><b>Destacado:</b></p>
        <dl>
        <dd>Vocal de la Sociedad Mexicana de Cardiología. </dd>
        <dd>Coordinador del Capítulo de Lípidos de la AMPAC.</dd>
        <dd>Publicación de libros y artículos científicos en revistas indexadas.</dd>
        <dd>Participación en múltiples congresos nacionales e internacionales con funciones de asistente y ponente.</dd>
        <dd>Ponente en diversas Sociedades Médicas como la Sociedad de Endocrinología y Nutrición y el Colegio de Medicina Interna de México.</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. José Z. Parra Carrillo', 'slug' => str_slug('Dr. José Z. Parra Carrillo'), 'summary' => '<p><b>Actualmente: </b></p>
        <dl>
        <dd>Profesor Extraordinario de Nefrología Clínica en la Facultad de Medicina de la Universidad de Guadalajara.</dd>
        </dl>
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Estudios Médico Cirujano y Partero. Facultad de Medicina, Universidad de Guadalajara.</dd>
        <dd>Nefrólogo. Hospital General del Centro Médico Nacional, IMSS. </dd>
        <dd>Post-Doctoral Research Fellow in Hypertension. College of Physicians and Surgeons, Columbia University. </dd>
        <dd>Maestría en Ciencias Médicas, Orientación Medicina. Universidad de Guadalajara.</dd>
        <dd>Doctorado en Ciencias de la Salud, Orientación Investigación Clínica. Universidad de Guadalajara.</dd>
        </dl>        
        <p><b>Destacado: </b></p>
        <dl>
        <dd>Autor o coautor de 180 publicaciones en Revistas Médicas Nacionales e Internacionales y libros médicos</dd>
        <dd>Reconocimiento al Mérito, por las contribuciones al Campo Clínico de la Hipertensión Arterial. Sociedad Mexicana para el Estudio de la Hipertensión arterial y Consejo Mexicano Contra la Hipertensión. México, D.F.</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Manuel Duarte Vega', 'slug' => str_slug('Dr. Manuel Duarte Vega'), 'summary' => '<p><b>Actualmente:</b></p>
        <dl>
        <dd>Moderador o ponente en reuniones científicas en el extranjero en los últimos 3 a&ntilde;os (12 eventos)</dd>
        <dd>Moderador o ponente en reuniones científicas en México en los últimos 3 a&ntilde;os (150 eventos)</dd>
        </dl>
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Egresado de la Facultad de medicina en la Universidad de Guadalajara, con especialidad en Medicina Interna en el Hospital Civil de Guadalajara</dd>
        </dl>
        <p><b>Destacado:</b></p>
        <dl>
        <dd>Investigador en estudios clínicos fase III y IV (En total 6 estudios en los últimos cinco a&ntilde;os) como: EXAMINE, INDAGA Y SAVOR.</dd>
        <dd>Catedrático de la Facultad de Medicina Universidad de Guadalajara, Postgrado en Medicina Interna Hospital Civil Juan I. Menchaca.</dd>
        <dd>Miembro de la Guía de tratamiento: HAS de la NOM</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Antonio Magaña Serrano', 'slug' => str_slug('Dr. Antonio Magaña Serrano'), 'summary' => '<p><b>Actualmente: </b></p>
        <dl>
        <dd>Jefe de la División de Educación en Salud. Hospital de Cardiología, Centro Médico Nacional Siglo XXI, Instituto Mexicano del Seguro Social.</dd>
        </dl>        
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Pregrado: Facultad de Medicina, UNAM.</dd>
        <dd>Postgrado: Residencia en Medicina Interna (2 a&ntilde;os) Hospital de especialidades, Centro Médico Nacional Siglo XXI.</dd>
        <dd>Curso de especialización en Cardiología (3 a&ntilde;os) Hospital de Cardiología, Centro Médico Nacional Siglo XXI.</dd>
        <dd>Maestría en Administración con enfoque en Factor Humano. UVM, Campus San ángel.</dd>
        </dl>        
        <p><b>Destacado:</b></p>
        <dl>
        <dd>Cardiólogo adscrito a la clínica de Insuficiencia Cardiaca y Trasplante Cardiaco. Hospital de Cardiología, Centro Médico Nacional Siglo XXI.</dd>
        <dd>Consultorio privado, 1999.</dd>
        <dd>Miembro Activo A de la Asociación Médica, Centro Médico ABC.</dd>
        <dd>Profesor titular de Cardiología. Universidad Anáhuac México Norte.</dd>
        <dd>Miembro del Task Force para la generación de las 1<sup>st</sup> Latin American Guidelines for the Diagnosis and Treatment of Acute Heart Failure, 2005.</dd>
        <dd>Publicación de artículos en revistas indizadas. </dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Enrique Díaz y Díaz', 'slug' => str_slug('Dr. Enrique Díaz y Díaz'), 'summary' => '<p><b>Actualmente:</b></p>
        <dl>
        <dd>Consulta privada, Hospital &Aacute;ngeles del Pedregal.</dd>
        <dd>Hospital de Cardiología, CMN SIGLO XXI IMSS: Jefe de Servicio de Hospitalización de Cardiología Adultos</dd>
        </dl>
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Universidad del Valle de México Campus San ángel. Maestría en Administración con dirección del Factor Humano.</dd>
        <dd>Maestría de Postgrado de Formación no presencial en Teoría Cardiovascular.</dd>
        <dd>Diplomado de Investigación Clínica. Dirección de Prestaciones Médicas. Coordinación de Educación en Salud. IMSS</dd>
        <dd>Especialidad de Cardiología.</dd>
        </dl>        
        <p><b>Destacado:</b></p>
        <dl>
        <dd>CONFERENCIAS IMPARTIDAS Y ATENDIDAS (351).</dd>
        <dd>Profesor en el XI Curso Nacional de Aterosclerosis Coronaria y I Curso de Cardiología para Médicos Generales y Familiares.</dd>
        <dd>Profesor en el Curso &quot;Las Normas Oficiales Mexicanas&quot; en la Escuela Superior de Medicina del Instituto Politecnico Nacional.</dd>
        <dd>European Society of Cardiology Congress 2014. 30 August to 3 September 2013, Barcelona, Espa&ntilde;a.</dd>
        <dd>Asistente al XI Curso Nacional de Aterosclerosis Coronaria y I Curso de Cardiología para Médicos Generales y Familiares.</dd>
        <dd>Profesor Titular del curso de Nosología Cardiovascular de la Facultad Mexicana de Medicina de la Universidad La Salle desde enero 2013.</dd>
        <dd>Presidente del capítulo de hipertensión arterial sistémica de la asociación nacional de cardiólogos de México. Bienio 2004 - 2006</dd>
        <dd>Publicaciones (30)</dd>
        <dd>Díaz y Díaz E. y Durán Oliver S. &quot;El corazón. una glándula endocrina&quot; Revista Médica de La Salle No.1 enero-marzo 1987:21-28</dd>']);
        Expert::create(['name' => 'Dr. Marco Antonio Ramos Corrales', 'slug' => str_slug('Dr. Marco Antonio Ramos Corrales'), 'summary' => '<p><b>Actualmente:</b></p>
        <dl>
        <dd>Consulta privada.</dd>
        <dd>Jefe de la Unidad Coronaria. UMAE. Hospital de Especialidades del Centro Médico Nacional &quot;La Raza&quot;. Instituto Mexicano del Seguro Social.</dd>
        </dl>        
        <p><b>Estudios: </b></p>
        <dl>
        <dd>Médico Cirujano y Partero. Facultad de Medicina. Universidad de Guadalajara.</dd>
        <dd>RESIDENCIA MEDICINA INTERNA. Hospital General. Centro Médico &quot;La Raza&quot;. Instituto Mexicano del Seguro Social.</dd>
        <dd>RESIDENCIA EN CARDIOLOGIA. Hospital General. Centro Médico &quot;La Raza&quot;. Instituto Mexicano del Seguro Social.</dd>
        </dl>        
        <p><b>Destacado: </b></p>
        <dl>
        <dd>Diploma por Actuación Meritoria en el Subinternado.</dd>
        <dd>Obtención de la Plaza de Jefe de Departamento Clínico. Dirección Médica. Instituto Mexicano del Seguro Social.</dd>
        <dd>Experiencia en investigación clínica Internacional y Nacional.</dd>
        <dd>Tutor de Tesis de Postgrado.</dd>
        <dd>Labores Docentes.</dd>
        <dd>Conferencias en cursos monográficos, jornadas médicas y simposios.</dd>
        <dd>Trabajos presentados y publicados en congresos, Libros y Revistas especializadas.</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Ricardo Martínez Zubieta', 'slug' => str_slug('Dr. Ricardo Martínez Zubieta'), 'summary' => '<p><b>Actualmente</b></p>
        <dl>
        <dd>Jefe de la Unidad de Terapia Intensiva “Alberto Villazón Sahagún” del Hospital Español de México. 1985 – 2011.</dd>
        </dl>        
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Licenciatura: Escuela de Medicina de la Universidad Autónoma de Puebla.</dd>
        <dd>Doctorado: Hospital Español de México.</dd>
        <dd>Maestría: Administración de Organizaciones de la Salud, Universidad La Salle, México.</dd>
        </dl>        
        <p><b>Destacado: </b></p>
        <dl>
        <dd>Más de 30 trabajos publicados en Libros y Revistas.</dd>
        <dd>Más de 20 trabajos presentados en Congresos Nacionales e Internacionales.</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Raúl Izaguirre &Aacute;vila', 'slug' => str_slug('Dr. Raúl Izaguirre &Aacute;vila'), 'summary' => '<p><b>Actualmente: </b></p>
        <dl>
        <dd>Jefe del Departamento de Hematología. Instituto Nacional de Cardiología Ignacio Chávez.</dd></dl>        
        <p><b>Estudios: </b></p>
        <dl>
        <dd>Título de Médico Cirujano por la Facultad de Medicina de Tampico. Universidad Autónoma de Tamaulipas.</dd>
        <dd>Especialista en Medicina Interna. Centro Médico La Raza. IMSS. </dd>
        <dd>Especialista en Hematología. Instituto Nacional de la Nutrición.</dd>
        </dl>        
        <p><b>Destacado:</b></p>
        <dl>
        <dd>Presidente de la Sociedad Mexicana de Hemostasia y Trombosis (SOMETH) 2016-2018. </dd>
        <dd>Miembro del Sistema Nacional de Investigadores, Nivel 1.</dd>
        <dd>Investigador Titular A de los Institutos Nacional de Salud.</dd>
        <dd>Presidente de la Agrupación Mexicana para el Estudio de la Hematología (1995-1997).</dd>
        <dd>Consejero por México de la International Society of Hematology (1992-1998).</dd>
        <dd>Miembro del consejo Mexicano de Hematología (1998-2001).</dd>
        <dd>Miembro del Comité Internacional de Control de Calidad en Coagulación de la Federación Internacional de Bioquímica Clínica.</dd>
        <dd>Más de 50 artículos publicados en revistas nacionales e internacionales.</dd>
        <dd>Premio Luis Sánchez Medal Otorgado en la AMEH por las Sociedades de Hematología de Uruguay y Puerto Rico.</dd>
        <dd>Premio Luis Sánchez Medal 2009 otorgado en la AMEH por la Sociedad Argentina de Hematología.</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Eulo Lupi', 'slug' => str_slug('Dr. Eulo Lupi'), 'summary' => '<p><b>Actualmente: </b></p>
        <dl>
        <dd>Es Director de la Línea de Servicio Cardiovascular del Centro Médico ABC.</dd>
        </dl>
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Médico Cirujano egresado por la Escuela Médico Militar de México con especialización en Cardiología por la UNAM.</dd>
        <dd>Completó su formación con una beca de investigación Meakins-Christie Laboratories of the Departament of Medicine, McGill University Clinic. Royal Victoria Hospital. Montreal, Canadá.</dd>
        </dl>        
        <p><b>Destacado: </b></p>
        <dl>
        <dd>Durante sus más de 40 años de trayectoria profesional, ha tenido una amplísima actividad institucional destacando su labor en el Instituto Nacional de Cardiología Ignacio Chávez, donde llegó a ser Jefe del Departamento de Urgencias y Unidad Coronaria.</dd>
        <dd>Expresidente del Consejo Mexicano de Cardiología también ostentó, entre otros muchos, el cargo de Subdirector de Investigación Clínica del Instituto Nacional de Cardiología.</dd>
        <dd>Recibió el Premio Salvador Aceves al Maestro Distinguido por la Sociedad Mexicana de Cardiología, en 2003.</dd>
        <dd>Ha practicado la docencia en muchos ámbitos.</dd>
        <dd>En su histórico como conferencista se acumulan más de 1.000 participaciones en conferencias nacionales y 100 a nivel internacional como profesor invitado.</dd>
        <dd>Ha colaborado en más de 170 publicaciones de producción científica y cuenta con 2 libros propios. Tiene más de 1200 citas de trabajos publicados y ha formado parte de varias investigaciones científicas.</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Úrsulo Juárez-Herrera', 'slug' => str_slug('Dr. Úrsulo Juárez-Herrera'), 'summary' => '<p><b>Actualmente:</b></p>
        <dl>
        <dd>Docencia dentro del Programa de Residentes UNAM-Pregrado. Curso de Cardiología a nivel Pregrado, Universidad La Salle.</dd>
        </dl>
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Médico Cirujano. Universidad La Salle, Facultad Mexicana de Medicina.</dd>
        <dd>Posgrado de Medicina Interna. Centro Hospitalario “20 de noviembre ISSSTE”.</dd>
        <dd>Especialista en Cardiología del Instituto Nacional de Cardiología Ignacio Chávez.</dd>
        <dd>Fellow in Coronary Care Unit. Brigham and Women´s Hospital. Harvard Medical School. Boston, Massachusetts.</dd>
        </dl>        
        <p><b>Destacado:</b></p>
        <dl>
        <dd>Coautor de 8 Libros.</dd>
        <dd>36 artículos publicados, a partir de 1992 a la fecha, en Revistas Médicas Científicas Nacionales e Internacionales.</dd>
        <dd>Publicación de 25 capítulos en libros de la Especialidad de Cardiología.</dd>
        <dd>Mención Honorífica en Medicina Interna Hospital “20 de noviembre”, ISSSTE.</dd>
        <dd>Premio Investigación Clínica "Ignacio Chávez". Sociedad Mexicana de Cardiología. XXII Congreso Nacional de Cardiología. Cancún, QR.</dd>
        <dd>Archievement Award. Reconocimiento por participar en el Protocolo EXTRACT- TIMI 25 Trial.</dd>
        <dd>Premio al mejor trabajo publicado en la Revista Archivos de Cardiología de México. XXVIII Congreso Mexicano de Cardiología.</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Marco Antonio Peña Duque', 'slug' => str_slug('Dr. Marco Antonio Peña Duque'), 'summary' => '<dl>
        <dd>Miembro titular de ANCAM, SMC, SOCIMA, SOLACI.</dd>
        <dd>Cardiólogo clínico e intervencionista egresado del Instituto Nacional de Cardiología.</dd>
        <dd>Certificado por el Consejo Mexicano de Cardiología.</dd>
        <dd>Jefe del Departamento de Hemodinámica del Instituo Nacionald e Cardiología Ignacio Chávez.</dd>
        <dd>Miembro numerario de la Academia Nacional de Medicina de México.</dd>
        <dd>Miembro del Sistema Nacional de Investigadores (SNI) nivel 1.</dd>
        <dd>Investigador de los Institutos Nacionales de Salud Nivel C.</dd>
        <dd>Autor o co-autor de 60 trabajos publciados en revistas nacionales o internacionales.</dd>
        <dd>Profesor titular del curso de Cardiología Intervencionista del Instituto Nacional de Cardiología.</dd>
        <dd>Presidente de la Sociedad Mexicana de Cardiología 2014-2016.</dd>
        <dd>Presidente del Consejo Mexicano de Cardiología 2017-2019.</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Simón Barquera', 'slug' => str_slug('Dr. Simón Barquera'), 'summary' => '<p><b>Actualmente</b></p>
        <dl>
        <dd>El Dr. Simon Barquera actualmente funge como Presidente del Colegio de Profesores de Nutrición (2006 -) y como Director del área de Investigación en Políticas y Programas de Nutrición (2009-) en el Instituto Nacional de Salud Pública (INSP).</dd>
        </dl>        
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Médico cirujano (Universidad Autónoma Metropolitana Xochimilco, Ciudad de México 1988-1994) con grados de maestría (1994-96) y doctorado (1997-2005) en Nutrición Aplicada y Epidemiología Nutricional (Escuela Friedman de Ciencias y Políticas de la Nutrición, Universidad de Tufts, Boston).</dd>
        </dl>        
        <p><b>Destacado: </b></p>
        <dl>
        <dd>Cuenta con más de 251 publicaciones y 6,265 citas a sus publicaciones (h-index: 39, h-index desde 2012: 33, i10-index: 83, RG score: 41.88 (marzo 2017 fuente: Google Schoolar/ResearchGate.Net).</dd>
        <dd>Ha sido reconocido como Investigador Nacional Nivel III por el Consejo Nacional de Ciencia y Tecnología, miembro de la Academia Nacional de Medicina (2006-) y miembro de la Academia Mexicana de Ciencias (2007).</dd>
        <dd>Recibió el premio Fred L. Soper (2003) a la excelencia en literatura médica.</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Erick Alexanderson Rosas', 'slug' => str_slug('Dr. Erick Alexanderson Rosas'), 'summary' => '<p><b>Actualmente: </b></p>
        <dl>
        <dd>El Dr. Erick Alexanderson Rosas es actualmente Jefe del Departamento de Cardiología Nuclear del Instituto Nacional de Cardiología Ignacio Chávez y Profesor de pregrado de Fisiología cardiovascular, Facultad de Medicina, UNAM desde octubre 1980.</dd></dl>
        <p><b>Estudios: </b></p>
        <dl>
        <dd>Médico general de Facultad de Medicina C.U., U.N.A.M México, D. F. 6 a&ntilde;os 1979-85.</dd>
        <dd>Especialidad: Medicina Interna del Hospital de Especialidades. Centro Médico Nacional Siglo XXI, IMSS, 1987-89 y Cardiología en el Instituto Nacional de Cardiología &quot;Ignacio Chávez&quot;, 1989-92. </dd>
        </dl>        
        <p><b>Destacado:</b></p>
        <dl>
        <dd>Premio Jorge Rosenkranz a la mejor Investigación en el área clínica, 2010. </dd>
        <dd>Representante de México del Consejo Internacional de la American Society of Nuclear Cardiology.</dd>
        <dd>Nombrado Gobernador para México del American College of Cardiology para el periodo de abril de 2011 a marzo de 2014.</dd>
        <dd>Nombrado Presidente del Capítulo Mexicano del American College of Cardiology en 2011.</dd>
        <dd>Coordinador del capítulo Latinoamericano de la Society of Cardiovascular Computed Tomography.</dd>
        <dd>Miembro del Comité Científico Internacional de la American Society of Nuclear Cardiology</dd>
        </dl>']);
        Expert::create(['name' => 'Mireya López Gamboa', 'slug' => str_slug('Mireya López Gamboa'), 'summary' => '<p><b>Actualmente: </b></p>
        <dl>
        <dd>La Dra. Mireya Lopez Gamboia se desempe&ntilde;a actualmente como Directora Operativo de Pharma Research Organization SA de CV y es Responsable del Centro Institucional del Farmacovigilancia en Instituto Nacional de Cancerología.</dd>
        </dl>
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Médico Cirujano con Doctorado en Ciencias en la Especialidad de Farmacología Médica y Molecular y Post-Doctorado en Farmacovigilancia del primer medicamento biotecnológico.</dd>
        </dl>        
        <p><b>Destacado: </b></p>
        <dl>
        <dd>Directora del proceso de certificación por la ISO:27001-2013 para los procesos de farmacovigilancia y tecnovigilancia de Pro Pharma Research Organization SA de CV.</dd>
        <dd>Directora del proceso de certificación por la ISO:9001-2015 del sistema de gestión de calidad de Pro Pharma Research Organization SA de CV.</dd>
        <dd>Fundadora de empresa mexicana especializada en servicios de farmacovigilancia y tecnovigilancia Pro Pharma Research Organization.</dd>
        <dd>Gestor y responsable técnico de proyectos ante CONACYT para desarrollo de proyectos en materia de tecnología, innovación en el área de farmacovigilancia.</dd>
        <dd>Gestión para obtención de 6 certificados de registros de derechos de autor por los softwares de farmacovigilancia y tecnovigilancia.</dd>
        <dd>Reconocimiento como autora de 3 softwares en 3 versiones diferentes para procesos de farmacovigilancia y tecnovigilancia.</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Carlos L. Fernández Barros', 'slug' => str_slug('Dr. Carlos L. Fernández Barros'), 'summary' => '<p><b>Actualmente: </b></p>
        <dl>
        <dd>El Dr. Carlos Leonardo Fernández Barros es actualmente Delegado en Coahuila del Capítulo México de Latinamerican Society of Hypertension (LASH) y trabaja actualmente como Cardiólogo Clínico en el Hospital Los ángeles de la Ciudad de Torreón, Coahuila, México.</dd></dl>
        <p><b>Estudios: </b></p>
        <dl>
        <dd>Licenciatura en la Facultad de Medicina de la UNAM.</dd>
        <dd>Estudios de postgrado de Medicina Interna en el Instituto Nacional de ciencias Médicas y Nutrición &quot;Salvador Zubirán&quot;. </dd>
        <dd>Estudios de Cardiología en el Instituto Nacional de Cardiología &quot;Ignacio Chávez&quot; en Destacado como Jefe de Médicos Residentes y Certificado por el Consejo Mexicano de Cardiología desde 1984.</dd>
        </dl>        
        <p><b>Destacado:</b></p>
        <dl>
        <dd>Vocal de la Sociedad Mexicana de Cardiología. </dd>
        <dd>Coordinador del Capítulo de Lípidos de la AMPAC.</dd>
        <dd>Publicación de libros y artículos científicos en revistas indexadas.</dd>
        <dd>Participación en múltiples congresos nacionales e internacionales con funciones de asistente y ponente.</dd>
        <dd>Ponente en diversas Sociedades Médicas como la Sociedad de Endocrinología y Nutrición y el Colegio de Medicina Interna de México.</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Armando García-Castillo', 'slug' => str_slug('Dr. Armando García-Castillo'), 'summary' => '<p><b>Actualmente:</b></p>
        <dl>
        <dd>El Dr. Armando García - Castillo se desempe&ntilde;a actualmente como Director de Hemodinamia en el Doctors Hospital de Monterrey, Nuevo León.</dd>
        </dl>
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Médico Cirujano, egresado de la Facultad de Medicina de la Universidad Autónoma de Coahuila, en Torreón Coahuila.</dd>
        <dd>Residencia de Medicina Interna en el Hospital de Especialidades No 71 I.M.S.S. Torreón Coahuila.</dd>
        <dd>Residencia de Cardiología en el Hospital de Cardiología del Centro Médico Nacional I.M.S.S. México, D.F. </dd>
        <dd>Subespecialidad en Hemodinámica en el Hospital de Cardiología del Centro Médico Nacional I.M.S.S. México, D.F.</dd>
        </dl>        
        <p><b>Destacado:</b></p>
        <dl>
        <dd>Beca para adiestramiento en los Laboratorios de Fisiología y Farmacología, en la Unidad de Investigaciones Biomédicas del Noreste en Monterrey, Nuevo León (6 meses 1981).</dd>
        <dd>Tercer lugar general en aprovechamiento académico durante la Carrera de Médico Cirujano en la Facultad de Medicina de Torreón Coahuila.</dd>
        <dd>Primer Lugar Nacional durante la Residencia de Cardiología (1987 - 1989).</dd>
        <dd>Certificado (Board) por el Consejo Mexicano de Cardiología (1989).</dd>
        <dd>Recertificado por el Consejo Mexicano de Cardiología (1995).</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Carlos Felipe Barrera-Ramírez. FAAC', 'slug' => str_slug('Dr. Carlos Felipe Barrera-Ramírez. FAAC'), 'summary' => '<p><b>Actualmente: </b></p>
        <dl>
        <dd>El Dr. Carlos Felipe Barrera-Ramírez es actualmente Director de la sala de Hemodinamia del Centro Hospitalario La Concepción, Saltillo. Coahuila, México.</dd>
        </dl>        
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Médico Cirujano la Universidad Nacional Autónoma de México, campus Ciudad Universitaria con reconocimiento universitario por un Servicio Social de Honor.</dd>
        <dd>Postgrado en Medicina Interna en el Instituto Nacional de Ciencias Médicas y de la Nutrición Salvador Zubirán de 1995 a 1998.</dd>
        <dd>Postgrado en Cardiología, egresado del Instituto Nacional de Cardiología Ignacio Chávez donde obtuvo el título en febrero del 2001.</dd>
        <dd>Cardiología Intervencionista en el Hospital Clínico de San Carlos de Madrid, Espa&ntilde;a, bajo la tutela del Dr. Carlos Macaya en el periodo 2001 a 2003.</dd>
        </dl>        
        <p><b>Destacado:</b></p>
        <dl>
        <dd>Miembro titular de ANCAM, SMC, SOCIMA, SOLACI.</dd>
        <dd>Investigación en el área de las enfermedades de la fosforilación oxidativa en el Instituto Nacional de Ciencias Médicas y de la Nutrición Salvador Zubirán de 1996 a 2001.</dd>
        <dd>Investigaciones sobre clopidogrel, agregación plaquetaria en relación con el intervencionismo coronario en el Hospital Clínico de San Carlos, Madrid, Espa&ntilde;a 2001-2003.</dd>
        <dd>Finalista por el premio &quot;Investigador joven Dr. Ignacio Chávez&quot;, Sociedad Interamericana de Cardiología, Ciudad de Buenos Aires, Argentina 1999; trabajo: &quot;Afección cardiaca en síndrome de Kearns-Sayre&quot;.</dd>
        <dd>Finalista a la mejor comunicación del XXXVIII Congreso de la Sociedad Espa&ntilde;ola de Cardiología como la mejor comunicación con el trabajo: &quot;Función plaquetaria en pacientes con escasa respuesta al tratamiento antiplaquetario tras implantación de un stent coronario&quot;.</dd>
        <dd>Finalista para el premio Investigador Joven &quot;Ignacio Chávez&quot; en el Congreso Interamericano de Cardiología en 1999 en la Cd. de Buenos Aires. </dd>
        <dd>Premio al mejor trabajo de investigación presentado en la reunión anual de la Sociedad de Cardiología Intervencionista de México (SOCIME), México 2004.</dd>
        <dd>Premio al mejor trabajo mexicano de investigación científica en el Congreso Anual de Cardiología Internacional, (CADECI), en Guadalajara 2011. www.http://cadeci.org.mx/.</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Carlos A. Aguilar Saúlinas', 'slug' => str_slug('Dr. Carlos A. Aguilar Saúlinas'), 'summary' => '<p><b>Actualmente:</b></p>
        <dl>
        <dd>Es subjefe del Departamento de Endocrinología y Metabolismo del Instituto Nacional de Ciencias Médicas y Nutrición desde 1996.</dd>
        </dl>        
        <p><b>Estudios: </b></p>
        <dl>
        <dd>Médico especialista en Medicina Interna y Endocrinología, egresado del Instituto Nacional de Ciencias Médicas y Nutrición. Doctorado en Investigación Médica. Realizó una estancia de investigación (1992-1994) en Washington University, School of Medicine (St Louis MO, EUA) sobre el estudio del metabolismo de las lipoproteinas, bajo la tutoría del Dr Gustav Schonfeld.</dd>
        </dl>        
        <p><b>Destacado: </b></p>
        <dl>
        <dd>Participar en la identificación de nuevos genes involucrados en la fisiopatología de la hiperlipidemia familiar combinada y en la diabetes tipo 2.</dd>
        <dd>Ser parte del equipo que llevó a cabo el primer escrutinio completo del genoma dise&ntilde;ado para identificar los genes determinantes de la concentración de los lípidos sanguíneos en mexicanos.</dd>
        <dd>Colaborar en la identificación de la variante R230C del transportador ABC-A1 como determinante de la concentración de colesterol HDL en mexicanos.</dd>
        <dd>Contribuir a la descripción de la epidemiología de la diabetes, de las dislipidemias y del síndrome metabólico en las Encuestas Nacionales de Salud de 1994, 2000, 2006 y 2012.</dd>
        <dd>Participar en el grupo que hizo posible la certificación del Instituto Nacional de Ciencias Médicas y Nutricion ante la AAHRPP (Association for Accreditation for Human Research Protection Programs) por apego a las buenas prácticas clínicas en la investigación (2013).</dd>
        <dd>Formar parte del comité organizador del &quot;Centro de Atención Integral del Paciente con Diabetes&quot; del Instituto Nacional de Ciencias Médicas y Nutricion (2013).</dd>
        <dd>Ser parte del equipo que llevó a cabo el primer escrutinio completo del genoma dise&ntilde;ado para identificar los genes asociados a la diabetes tipo 2 en mexicanos (Estudio SIGMA) (2013).</dd>
        <dd>Es autor o editor de 8 libros (&quot;Dislipidemias: De lo Clínico a lo Molecular&quot; y &quot;Manual de terapéutica médica y procedimientos de urgencia del Instituto Nacional de Ciencias Médicas y Nutrición&quot; entre otros).</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Humberto &Aacute;lvarez', 'slug' => str_slug('Dr. Humberto &Aacute;lvarez'), 'summary' => '<p><b>Actualmente:</b></p>
        <dl>
        <dd>El Dr. Humberto Alvarez es actualmente tiene su práctica privada en el Hospital Puerta de Hierro, Zapopan, Jalisco., México.</dd>
        </dl>        
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Médico Cirujano Partero egresado de la Facultad de Medicina de la Universidad de Guadalajara. </dd>
        <dd>Internal Medicine Fellow. Hospital General de Zona No. 89, INSTITUTO MEXICANO DEL SEGURO SOCIAL., Guadalajara, Jalisco, México.</dd>
        <dd>Postgrado en Cardiología en el HOSPITAL DE CARDIOLOGIA DEL CENTRO MEDICO NACIONAL SIGLO XXI, IMSS, UNIVERSIDAD NACIONAL AUTONOMA DE MEXICO. Ciudad de México.</dd>
        </dl>        
        <p><b>Destacado</b></p>
        <dl>
        <dd>Miembro de:</dd>
        <dd>Asociación Nacional de Cardiólogos de México (ANCAM)</dd>
        <dd>Colegio de Cardiólogos de Jalisco, S.C.</dd>
        <dd>Sociedad Mexicana de Ecocardiografía</dd>
        <dd>American Society of Hypertension Inc.</dd>
        <dd>Sociedad Nacional de Ecocardiografía de México</dd>
        <dd>European Society Cardiology, ESC </dd>
        <dd>Asociación Mexicana para la Prevención de la Aterosclerosis y sus Complicaciones. AMPAC</dd>
        <dd>The American Society for Preventive Cardiology</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. Juan Carlos Garnica Cuéllar', 'slug' => str_slug('Dr. Juan Carlos Garnica Cuéllar'), 'summary' => '<p><b>Actualmente:</b></p>
        <dl>
        <dd>El Dr. Juan Carlos Garnica Cuéllar es Médico Adscrito al Departamento Clínico de Endocrinología del Hospital de Especialidades del CMN La Raza. Coordinador del proceso de actualización en el área de endocrinología de las guías de práctica clínica a cargo del Centro Nacional de Excelencia Tecnológica en Salud (CENETEC). Asesor en la Secretaria de Salud para el proceso de actualización del documento de trabajo de la NOM -015-SSA2-2010, Para la prevención, detección, diagnóstico, tratamiento y control de la Diabetes Mellitus.</dd>
        </dl>        
        <p><b>Estudios:</b></p>
        <dl>
        <dd>Licenciatura en Médico Cirujano. En la universidad Anáhuac. Generación 1999-2004. </dd>
        <dd>Especialista en Endocrinología. Certificado por el Consejo Mexicano de Endocrinología, A.C.</dd>
        <dd>Subespecialista en Biología de la Reproducción Humana. Residencia en el Instituto Nacional de Ciencias Médicas y Nutrición Salvador Zubirán.</dd>
        <dd>Maestría en Administración de Organizaciones de la Salud. Universidad La Salle.</dd>
        </dl>        
        <p><b>Destacado</b></p>
        <dl>
        <dd>Miembro de:</dd>
        <dd>Speaker en el área de Tiroides para Armstrong. (2010 -2012).</dd>
        <dd>Speaker de insulinas y antagonistas de PCSK9 con Sanofi (agosto 2015. A la fecha).</dd>
        <dd>Socio titular en la sociedad mexicana de nutrición y endocrinología A.C desde el 2009.</dd>
        <dd>Socio adscrito de la American Association of Clinical Endocrinologists. AACE desde el 2008.</dd>
        <dd>Socio Activo de la Asociación de Postgraduados en Endocrinología.</dd>
        </dl>']);
        Expert::create(['name' => 'Dr. José de Jesús Flores Rivera', 'slug' => str_slug('Dr. José de Jesús Flores Rivera'), 'summary' => '<p>El doctor José de Jesús Flores Rivera es médico internista con especialidad en Neurología, enfocando su labor al estudio y atención de la esclerosis múltiple y enfermedades desmielinizantes. Se ha interesado en los procedimientos de Neuroinmunología e investigación clínica. 
        </p><p>Su preparación académica ha sido en la Universidad Autónoma de Puebla, la Universidad Nacional Autónoma de México (UNAM) y la Universidad Autónoma de Barcelona.
        Pertenece al Colegio de Medicina Interna de México, al American College of Physicians, al Consejo Mexicano de Neurología y a la Academia Mexicana de Neurología.
        Actualmente, es Subidrector del Instituto Nacional de Neurología y Neurocirugía Manuel Velasco.
        </p>']);
        Expert::create(['name' => 'Dra. Verónica Rivas Alonso', 'slug' => str_slug('Dra. Verónica Rivas Alonso'), 'summary' => '<ul>
        <li>Coordinadora de la Clínica de Esclerosis Múltiple, Instituto Nacional de Neurología,
        2016.
        </li>
        <li>Médico Adscrito Clínica de Enfermedades Desmielinizantes, Instituto Nacional de
        Neurología y Neurocirugía.
        </li>
        <li>Médico Adjunto, Curso Alta Especialidad en Esclerosis Múltiple, Instituto Nacional de
        Neurología y Neurocirugía.</li>
        <li>Unidad de Neurociencias, Hospital “Médica Sur”</li>
        <li>Miembro de la Sociedad de Médicos, Hospital Médica Sur</li>
        <li>Miembro Activo Academia Mexicana de Neurología.</li>
        <li>Miembro de la Asociación Mexicana de Neurólogos Egresados del INNN (AMEINNN).</li>
        <li>Miembro de la Asociación de Neurólogos Egresados del IMSS (ANIMSS).</li>
        </ul>']);
    }
}
