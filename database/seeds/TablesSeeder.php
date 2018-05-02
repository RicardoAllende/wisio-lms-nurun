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

class TablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'student', 'description' => 'Médico']);
        Role::create(['name' => 'admin', 'description' => 'Administrador del sistema']);
        User::create(['email'=>'juan.huerta@subitus.com', 'password'=>bcrypt('secret'), 'firstname'=>'Juan', 'lastname'=>'Huerta']);
        User::create(['email'=>'miguel.villegas@subitus.com', 'password'=>bcrypt('secret'), 'firstname'=>'Miguel', 'lastname'=>'Villegas']);
        User::create(['email'=>'ricardo.allende@subitus.com', 'password'=>bcrypt('secret'), 'firstname'=>'Ricardo', 'lastname'=>'Allende']);
        RoleUser::create(['role_id'=> 2, 'user_id' => 1]);
        RoleUser::create(['role_id'=> 2, 'user_id' => 2]);
        RoleUser::create(['role_id'=> 2, 'user_id' => 3]);
        Course::create(['name'=>'Cómo programar', 'description'=>'En este curso se dan los principios básicos de la programación']);
        
        CustomField::create(['name'=>'Tipo de sangre', 'type' => 'text']);
        CustomFieldUser::create(['user_id'=> 1, 'custom_field_id'=>1, 'data'=>'RH-A positivo']);
        Tag::create(['tag' => 'Programación']);
        CourseTag::create(['tag_id'=> 1, 'course_id'=>1]);
        Module::create(['name' => 'Introducción']);
        Module::create(['name' => 'Instalación de herramientas']);
        CourseModule::create(['course_id' => 1, 'module_id' => 1]);
        CourseModule::create(['course_id' => 1, 'module_id' => 2]);
        Attachment::create(['name'=>'Documento de introducción', 'type'=>'pdf', 'url'=>'public/intro.pdf']);
        Attachment::create(['name'=>'Vídeo de instalación', 'type'=>'mp4', 'url'=>'public/intro.mp4']);
        Resource::create(['attachment_id'=>1, 'type'=>'manual']);
        Resource::create(['attachment_id'=>2, 'type'=>'video']);
        ModuleResource::create(['module_id'=> 1, "resource_id"=>1]);
        ModuleResource::create(['module_id'=> 2, "resource_id"=>2]);
        Evaluation::create(['module_id' => 1, 'name'=>'Test de conocimientos básicos', 'type' => 'test']);
        Evaluation::create(['module_id' => 2, 'name'=>'Test de instalación de las herramientas necesarias', 'type' => 'test']);
        Question::create(['evaluation_id'=>1, 'name'=>'Programación antigua', 'content'=>'No siempre se programó en computadoras.', 'type' => '1', 'is_true' => 1]);
        Question::create(['evaluation_id'=>2, 'name'=>'Instalación windows', 'content'=>'Windows está disponible sólo en 32 bits', 'type' => '1', 'is_true' => 0]);
        Question::create([ 'evaluation_id' => 1, 'name'=>'Horas del día', 'content' => '¿Cuántas horas tiene un día?', 'type' => '2']);
        Question::create([ 'evaluation_id' => 2, 'name'=>'Siglas RGB', 'content' => '¿Qué significa RGB?', 'type' => '2']);
        Option::create(['question_id' => 4, 'content' => 'Red Green Blue', 'score' => 1]);
        Option::create(['question_id' => 4, 'content' => 'FASHGDF', 'score' => 0]);
        Option::create(['question_id' => 4, 'content' => 'kiuolk', 'score' => 0]);
        Option::create(['question_id' => 3, 'content' => '23', 'score' => 0]);
        Option::create(['question_id' => 3, 'content' => '24', 'score' => 1]);
    }
}
