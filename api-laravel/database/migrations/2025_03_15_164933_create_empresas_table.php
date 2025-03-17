<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id('recnum'); // Auto incremento
            $table->decimal('codigo', 4, 0)->unique(); // PK
            $table->decimal('empresa', 4, 0);
            $table->string('sigla', 40)->nullable();
            $table->string('razao_social', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};

