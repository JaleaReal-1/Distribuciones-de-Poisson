<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id('id_estudiante');
            $table->string('dni', 8);
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('grado_seccion');
        });
    }

    public function down()
    {
        Schema::dropIfExists('estudiantes');
    }
};
