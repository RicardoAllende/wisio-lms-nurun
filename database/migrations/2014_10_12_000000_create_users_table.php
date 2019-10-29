<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            // $table->string('username')->unique()->nullable();
            $table->string('firstname', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('email', 50)->unique();
            $table->string('password', 70)->default(bcrypt('secret'));
            $table->date('birthday')->nullable();
            $table->enum('gender', ['Hombre', 'Mujer'])->nullable(); // M or F
            $table->string('mobile_phone', 15)->nullable();
            $table->string('zip', 5)->nullable();
            $table->string('city', 50)->nullable();
            $table->boolean('is_validated')->default(true); // Cédula
            $table->string('address', 100)->nullable();
            $table->string('professional_license', 10)->nullable();
            $table->string('refered_code', 15)->nullable();
            $table->enum('consultation_type', ['Privada', 'Pública', 'Mixta'])->nullable();
            $table->timestamp('last_access')->nullable();
            $table->timestamp('last_profile_update')->nullable();
            $table->boolean('enabled')->default(true);
            // $table->integer('ascription_id')->unsigned();
            $table->rememberToken()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
