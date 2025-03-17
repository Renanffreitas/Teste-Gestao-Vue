<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            // Defina 'recnum' como auto_increment
            $table->bigIncrements('recnum'); // Isso define 'recnum' como auto_increment e chave primária

            // Colunas restantes
            $table->decimal('empresa', 4, 0); // Coluna para relacionar com a tabela 'empresa'
            $table->decimal('codigo', 14, 0); // Código do cliente
            $table->string('razao_social'); // Razão social
            $table->enum('tipo', ['PJ', 'PF']); // Tipo de cliente
            $table->string('cpf_cnpj', 14); // CPF ou CNPJ

            // Defina a chave estrangeira composta
            $table->unique(['empresa', 'codigo']); // Garante que a combinação seja única

            // Relacionamento de chave estrangeira (presumindo que a tabela 'empresa' exista)
            $table->foreign('empresa')->references('codigo')->on('empresas')->onDelete('cascade');

            $table->timestamps(); // Cria as colunas created_at e updated_at
        });
    }



    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};

