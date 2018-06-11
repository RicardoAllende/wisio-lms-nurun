<?php 
define("SERVER", "localhost");
define("DATABASE", "paecfarmacias");
define("PASSWORD", "");
define("USER", "root");

$connection =  new mysqli('127.0.0.1', 'root', '', DATABASE);
mysqli_set_charset ($connection , 'utf8');

// $sql = "SELECT * FROM paecs";
// $resultado = $connection->query($sql);
// $i=1;
// while($fila = $resultado->fetch_assoc()){
// 	echo '$course'.$i." = Course::create(['id' =>  ".$fila['id'].", 'name' => '".$fila['title']."', 'slug' => '".$fila['url']."', 'has_constancy' => ".$fila['is_available_constancy']."]);";
// 	echo "<br>";
// 	$i++;
// }


// $sql = "SELECT * FROM modules";
// $resultado = $connection->query($sql);
// $i=1;
// while($fila = $resultado->fetch_assoc()){
// 	echo "Module::create(['id' => '".$fila['id']."', 'name' => '".$fila['title']."', 'course_id' => ".$fila['id_paec']."]);";
// 	echo "<br>";
// 	$i++;
// }

// $sql = "SELECT * FROM evaluations";
// $resultado = $connection->query($sql);
// $i=1;
// while($fila = $resultado->fetch_assoc()){
// 	echo "Evaluation::create(['id' => ".$fila['id']." , 'name' => '".$fila['title']."', 'module_id' => ".$fila['modules_id'].", 'type'=> '".$fila['type']."']);";
// 	echo "<br>";
// 	$i++;
// }// $sql = "SELECT * FROM evaluations";
// $resultado = $connection->query($sql);
// $i=1;
// while($fila = $resultado->fetch_assoc()){
// 	echo "Evaluation::create(['id' => ".$fila['id']." , 'name' => '".$fila['title']."', 'module_id' => ".$fila['modules_id'].", 'type'=> '".$fila['type']."']);";
// 	echo "<br>";
// 	$i++;
// }

// $sql = "SELECT * FROM questions";
// $resultado = $connection->query($sql);
// $i=1;
// while($fila = $resultado->fetch_assoc()){
// 	echo "Question::create(['id' => ".$fila['id'].", 'content' => '".$fila['title']."', 'evaluation_id' => ".$fila['evaluations_id']."]);";
// 	echo "<br>";
// 	$i++;
// }

// $sql = "SELECT * FROM options";
// $resultado = $connection->query($sql);
// $i=1;
// while($fila = $resultado->fetch_assoc()){
// 	echo "Option::create(['content' => '".$fila['title']."', 'question_id' => ".$fila['questions_id'].", 'score' => ".$fila['value']."]);";
// 	echo "<br>";
// 	$i++;
// }

$sql = "SELECT * FROM experts";
$resultado = $connection->query($sql);
while($fila = $resultado->fetch_assoc()){
	echo "Expert::create(['id' => ".$fila['id'].", 'name' => '".$fila['title']."', 'slug' => str_slug('".$fila['title']."'), 'summary' => '".$fila['description']."']);";
	echo "<br>";
	echo "ExpertModule::create(['expert_id' => ".$fila['id'].", 'module_id' => ".$fila['modules_id']."]);";
	echo "<br>";
}

// $sql = "SELECT * FROM users JOIN specialties ON users.specialty = specialties.";
// $resultado = $connection->query($sql);
// $i=1;
// while($fila = $resultado->fetch_assoc()){
// 	echo "Option::create(['content' => '".$fila['title']."', 'question_id' => ".$fila['questions_id'].", 'score' => ".$fila['value']."]);";
// 	echo "<br>";
// 	$i++;
// }



/**---------------------------------------------------- */

// $query = "select title, is_available_constancy, minimum_grade from paecs";
	// $result = $connection->query($query);
	// while ($course = $result->fetch_assoc()) {
	// 	echo "Course::create(['name' => '".$course['title']."', 'has_constancy' => ".$course['is_available_constancy'].");";
	//     echo "<br>";
	// }

	// $query = "select name from states";
	// $result = $connection->query($query);
	// while ($fila = $result->fetch_assoc()) {
	// 	echo "State::create(['name' => '".$fila['name']."']);";
	//     echo "<br>";
	// }



	// $query = "select cc_id, url from cc_medias";
	// $queryImg = "select icon from cc where id = 1";
	// $result = $connection->query($query);
	// $result2 = $connection->query($queryImg);
	// $i = 5000;
	// $weight = 1;
	// $img = $result2->fetch_assoc();
	// echo '$attach'.$i." = Attachment::create(['type' => 'main_img', 'url' => '".str_replace('/storage', 'storage',
	//     $img['icon'])."', 'mimetype' => 'image/*']);";
	// echo "<br>";
	// echo 'AttachmentModule::create(["attachment_id" => , "module_id" => ])';
	// $i++;
	// while ($fila = $result->fetch_assoc()) {
	//     echo '$attach'.$i." = Attachment::create(['type' => 'video', 'url' => '".str_replace('/storage', 'storage',
	//     $fila['url'])."', 'name' => '".substr($fila['url'], strripos($fila['url'], '/') + 1 )."', 'mimetype' => 'video/mp4']);";
	//     echo "<br>";
	//     echo 'Resource::create(["module_id" => $moduleCC->id, "attachment_id" => $attach'.$i.'->id]);';
	//     echo '<br>';
	//     $i++;
	//     $weight++;
	// }



	// Migración de los vídeos de los módulos
	// $query = "select modules_id, url from medias";
	// $result = $connection->query($query);
	// $i = 1;
	// while ($fila = $result->fetch_assoc()) {
	// 	echo '$attach'.$i." = Attachment::create(['type' => 'video', 'url' => '".str_replace('/storage', 'storage',
	// 	$fila['url'])."', 'name' => '".substr($fila['url'], strripos($fila['url'], '/') + 1 )."', 'mimetype' => 'video/mp4', 'type' => 'video']);";
	// 	echo "<br>";
	// 	echo 'Resource::create(["module_id" => '.$fila['modules_id'].', "attachment_id" => $attach'.$i.'->id, "type" => "video"]);';
	// 	echo '<br>';
	// 	$i++;
	// }



	// Migración de las imágenes del módulo
	// $i = 10100;
	// $query = "select icon, id from modules";
	// $result = $connection->query($query) or die($connection->error);
	// while($fila = $result->fetch_assoc()){
	//     echo '$attach'.$i.' = Attachment::create(["type" => "main_img", "url" => "'.str_replace('storage', 'storage', $fila['icon']).'", "mimetype" => "image/png"]);';
	//     echo "<br>";
	//     echo 'AttachmentModule::create(["attachment_id" => $attach'.$i.'->id, "module_id" => '.$fila['id'].']);';
	//     echo "<br>";
	//     $i++;
	// }

	// name, type    ,      mimetype, url, description              Attachment
	//     ,pdf/video,     video/mp4, 

	// type





/*
	$connection = mysqli_connect("127.0.0.1", "root", "", "paecmexico");
	$connection->set_charset("utf8");
	// $query = "select title, is_available_constancy, minimum_grade from paecs";
	// $result = $connection->query($query);
	// while ($course = $result->fetch_assoc()) {
	// 	echo "Course::create(['name' => '".$course['title']."', 'has_constancy' => ".$course['is_available_constancy'].");";
	//     echo "<br>";
	// }

	// $query = "select name from states";
	// $result = $connection->query($query);
	// while ($fila = $result->fetch_assoc()) {
	// 	echo "State::create(['name' => '".$fila['name']."']);";
	//     echo "<br>";
	// }



	// $query = "select cc_id, url from cc_medias";
	// $queryImg = "select icon from cc where id = 1";
	// $result = $connection->query($query);
	// $result2 = $connection->query($queryImg);
	// $i = 5000;
	// $weight = 1;
	// $img = $result2->fetch_assoc();
	// echo '$attach'.$i." = Attachment::create(['type' => 'main_img', 'url' => '".str_replace('/storage', 'storage',
	//     $img['icon'])."', 'mimetype' => 'image/*']);";
	// echo "<br>";
	// echo 'AttachmentModule::create(["attachment_id" => , "module_id" => ])';
	// $i++;
	// while ($fila = $result->fetch_assoc()) {
	//     echo '$attach'.$i." = Attachment::create(['type' => 'video', 'url' => '".str_replace('/storage', 'storage',
	//     $fila['url'])."', 'name' => '".substr($fila['url'], strripos($fila['url'], '/') + 1 )."', 'mimetype' => 'video/mp4']);";
	//     echo "<br>";
	//     echo 'Resource::create(["module_id" => $moduleCC->id, "attachment_id" => $attach'.$i.'->id]);';
	//     echo '<br>';
	//     $i++;
	//     $weight++;
	// }



	// Migración de los vídeos de los módulos
	$query = "select modules_id, url from medias";
	$result = $connection->query($query);
	$i = 1;
	while ($fila = $result->fetch_assoc()) {
		echo '$attach'.$i." = Attachment::create(['type' => 'video', 'url' => '".str_replace('/storage', 'storage',
		$fila['url'])."', 'name' => '".substr($fila['url'], strripos($fila['url'], '/') + 1 )."', 'mimetype' => 'video/mp4', 'type' => 'video']);";
		echo "<br>";
		echo 'Resource::create(["module_id" => $module'.$fila['modules_id'].'->id, "attachment_id" => $attach'.$i.'->id, "type" => "video"]);';
		echo '<br>';
		$i++;
	}



	// Migración de las imágenes del módulo
	// $i = 10000;
	// $query = "select icon, id from modules";
	// $result = $connection->query($query) or die($connection->error);
	// while($fila = $result->fetch_assoc()){
	//     echo '$attach'.$i.' = Attachment::create(["type" => "main_img", "url" => "'.str_replace('storage', 'storage', $fila['icon']).'", "mimetype" => "image/png"]);';
	//     echo "<br>";
	//     echo 'AttachmentModule::create(["attachment_id" => $attach'.$i.'->id, "module_id" => $module'.$fila['id'].'->id]);';
	//     echo "<br>";
	//     $i++;
	// }

	// name, type    ,      mimetype, url, description              Attachment
	//     ,pdf/video,     video/mp4, 

	// type

*/



?>