<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
Invite::create([
    'email' => 'ricardo.allende@subitus.com', 'phone' => '5525731520', 'name' => 'Ricardo Allende', 'company' => 'Expertos en Elearning', 'url' => 'www.subitus.com', 'ascription_id' => 1
]);
*/
class Invite extends Model
{
    protected $fillable = ['email', 'subitusTracking', 'phone', 'name', 'company', 'url', 'ascription_id'];
    public function createUsers(){
        // $emails = array('user1', 'user2', 'aprobado', 'reprobado');
        $at = getEmailProvider($this->email);
        $createdUsers = array();
        $users = factory(User::class, 10)->create([
            'ascription_id' => $this->ascription_id
        ]);
        $aprobado = "alumno.de.10@".$at;
        $reprobado = "alumno.reprobado@".$at;
        $emails = collect();
        $emails->push($aprobado);
        $emails->push($reprobado);        
        foreach ($users as $user) {
            $emails->push($user->email = replaceEmailProvider($user->email, $at));
            $user->save();
        }
        if(User::whereEmail($aprobado)->count() == 0){
            factory(User::class)->create(['ascription_id' => $this->ascription_id,'email' => $aprobado]);
        }
        if(User::whereEmail($reprobado)->count() == 0){
            factory(User::class)->create(['ascription_id' => $this->ascription_id,'email' => $reprobado]);
        }
        return $emails;
    }

    public function approveUser($user){

    }

    public function reproveUser($user){

    }

    public function createDemoCourse(){
        $courses = collect();
        $ascription_id = $this->ascription_id;
        $course = Course::whereSlug('curso-de-prueba')->select('id')->first();
        if($course != null){
            if( AscriptionCourse::whereCourseId($course->id)->whereAscriptionId($this->ascription_id)->count() != 0 ){
                return $course;
            }
        }
        $course = Course::create([
            'name' => 'Curso de prueba',
            'slug' => 'curso-de-prueba',
            'ascription_id' => $this->ascription_id
        ]);
        $course_id = $course->id;
        AscriptionCourse::create([
            'ascription_id' => $this->ascription_id,
            'course_id' => $course_id
        ]);
        factory(Module::class, 4)->create([
            'course_id' => $course->id
        ])->each(function($module){
            $module = $module->id;
            $evaluation = Evaluation::create([
                'name' => '',
                'type' => 'd',
                'module_id' => $module
            ]);
            $evaluation_id = $evaluation->id;
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => '¿Cuál es el lugar más frío de la tierra?',
            'content' => '¿Cuál es el lugar más frío de la tierra?',
            'feedback' => 'Es la Antártida']);
            Option::create(['content' => "México", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => 'La Antártida', 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => 'Escocia', 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => 'Egipto', 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => 'Egipto', 'question_id' => $question->id, 'is_correct' => 0]);
    
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => '¿Cuál es el río más largo del mundo?',
            'content' => '¿Cuál es el río más largo del mundo?',
            'feedback' => 'Es el Amazonas']);
            Option::create(['content' => "El río Nilo", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "El río bravo", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "El río Amazonas", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "El río Danubio", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "El río Danubio", 'question_id' => $question->id, 'is_correct' => 0]);
    
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => '¿Dónde se originaron los juegos olímpicos?',
            'content' => '¿Dónde se originaron los juegos olímpicos?',
            'feedback' => 'En Grecia']);
            Option::create(['content' => "México", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Tailandia", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "USA", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "USA", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Grecia", 'question_id' => $question->id, 'is_correct' => 1]);
    
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => "¿Cuándo acabó la II Guerra Mundial?",
            'content' => "¿Cuándo acabó la II Guerra Mundial?",
            'feedback' => '1945']);
            Option::create(['content' => "1939", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "1944", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "1945", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "1945", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "1964", 'question_id' => $question->id, 'is_correct' => 0]);
    
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => "¿Dónde se encuentra la Sagrada Familia?",
            'content' => "¿Dónde se encuentra la Sagrada Familia?",
            'feedback' => 'Barcelona']);
            Option::create(['content' => "Barcelona", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "Barcelona", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "Ciudad de México", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Ciudad del Vaticano", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Madrid", 'question_id' => $question->id, 'is_correct' => 0]);
    
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => "¿Cuál es el color que representa la esperanza?",
            'content' => "¿Cuál es el color que representa la esperanza?",
            'feedback' => 'Verde']);
            Option::create(['content' => "Azul", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Café", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Naranja", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Verde", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "Verde", 'question_id' => $question->id, 'is_correct' => 1]);
    
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => "¿Cuántas patas tiene la araña?",
            'content' => "¿Cuántas patas tiene la araña?",
            'feedback' => 'Normalmente son 8']);
            Option::create(['content' => "8", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "5", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "6", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "7", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "7", 'question_id' => $question->id, 'is_correct' => 0]);



            $evaluation = $evaluation = Evaluation::create([
                'name' => '',
                'type' => 'f',
                'module_id' => $module
            ]);
            $evaluation_id = $evaluation->id;
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => '¿Cuál es el lugar más frío de la tierra?',
            'content' => '¿Cuál es el lugar más frío de la tierra?',
            'feedback' => 'Es la Antártida']);
            Option::create(['content' => "México", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => 'La Antártida', 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => 'Escocia', 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => 'Egipto', 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => 'Egipto', 'question_id' => $question->id, 'is_correct' => 0]);
    
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => '¿Cuál es el río más largo del mundo?',
            'content' => '¿Cuál es el río más largo del mundo?',
            'feedback' => 'Es el Amazonas']);
            Option::create(['content' => "El río Nilo", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "El río bravo", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "El río Amazonas", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "El río Danubio", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "El río Danubio", 'question_id' => $question->id, 'is_correct' => 0]);
    
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => '¿Dónde se originaron los juegos olímpicos?',
            'content' => '¿Dónde se originaron los juegos olímpicos?',
            'feedback' => 'En Grecia']);
            Option::create(['content' => "México", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Tailandia", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "USA", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "USA", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Grecia", 'question_id' => $question->id, 'is_correct' => 1]);
    
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => "¿Cuándo acabó la II Guerra Mundial?",
            'content' => "¿Cuándo acabó la II Guerra Mundial?",
            'feedback' => '1945']);
            Option::create(['content' => "1939", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "1944", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "1945", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "1945", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "1964", 'question_id' => $question->id, 'is_correct' => 0]);
    
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => "¿Dónde se encuentra la Sagrada Familia?",
            'content' => "¿Dónde se encuentra la Sagrada Familia?",
            'feedback' => 'Barcelona']);
            Option::create(['content' => "Barcelona", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "Barcelona", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "Ciudad de México", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Ciudad del Vaticano", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Madrid", 'question_id' => $question->id, 'is_correct' => 0]);
    
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => "¿Cuál es el color que representa la esperanza?",
            'content' => "¿Cuál es el color que representa la esperanza?",
            'feedback' => 'Verde']);
            Option::create(['content' => "Azul", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Café", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Naranja", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "Verde", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "Verde", 'question_id' => $question->id, 'is_correct' => 1]);
    
            $question = Question::create(['evaluation_id' => $evaluation_id, 'level' => rand(1,3),
            'name' => "¿Cuántas patas tiene la araña?",
            'content' => "¿Cuántas patas tiene la araña?",
            'feedback' => 'Normalmente son 8']);
            Option::create(['content' => "8", 'question_id' => $question->id, 'is_correct' => 1]);
            Option::create(['content' => "5", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "6", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "7", 'question_id' => $question->id, 'is_correct' => 0]);
            Option::create(['content' => "7", 'question_id' => $question->id, 'is_correct' => 0]);
            

        });
        return $course;
    }

}
