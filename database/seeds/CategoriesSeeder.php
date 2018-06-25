<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Attachment;
use App\Course;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::create(['name' => 'Alergia', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/alergia..png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Anestesiología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/anestesiologia.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Cardiología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/cardiologia.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);
        $course = Course::find(3);
        $course->category_id = $category->id;
        $course->save();
        $course = Course::find(4);
        $course->category_id = $category->id;
        $course->save();
        $course = Course::find(5);
        $course->category_id = $category->id;
        $course->save();
        $course = Course::find(8);
        $course->category_id = $category->id;
        $course->save();

        $category = Category::create(['name' => 'Endocrinología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/endocrinologia.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);
        $course = Course::find(2);
        $course->category_id = $category->id;
        $course->save();
        $course = Course::find(7);
        $course->category_id = $category->id;
        $course->save();

        $category = Category::create(['name' => 'Gastroenterología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/gastroenterologia.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Geriatría', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/geriatria.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Ginecología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/ginecologia.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Hematología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/hematologia.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Infectología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/infectologia.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Nefrología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/nephrology.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Neurología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/neurologia.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);
        $course = Course::find(6);
        $course->category_id = $category->id;
        $course->save();

        $category = Category::create(['name' => 'Nutrición', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/nutricion.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Oftamología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/oftalmologia.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Oncología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/oncologia.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Pediatría', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/pediatria.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Psiquiatría', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/psiquiatria.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);
        $course = Course::find(1);
        $course->category_id = $category->id;
        $course->save();

        $category = Category::create(['name' => 'Pulmonología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/pulmonology.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Radiación', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/radiacion.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Rehabilitación', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/rehab.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Reumatología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/reumatologia.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Sistema Nervioso Central', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/sistema_nervioso_central.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Toxicología', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/toxicologia.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);

        $category = Category::create(['name' => 'Uroligia', 'description' => 'Icono del sistema']);
        $attach = Attachment::create(["type" => "main_img", "url" => "storage/ICONOS/uroligia.png", "mimetype" => "image/png"]);
        $category->attachments()->attach($attach->id);
    }
}
