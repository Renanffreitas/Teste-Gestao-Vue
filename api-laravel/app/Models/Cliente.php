<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Definir o nome da tabela se não seguir a convenção
    protected $table = 'clientes';

    // Especificar quais atributos podem ser preenchidos (mass assignable)
    protected $fillable = [
        'empresa', 'codigo', 'razao_social', 'tipo', 'cpf_cnpj'
    ];

    // Definir a chave primária (se for diferente da padrão 'id')
    protected $primaryKey = 'recnum'; // 'recnum' é a chave primária

    // Definir as chaves compostas para buscar os registros
    public $incrementing = true; // Isso permite o incremento automático de recnum

    // Definir o tipo das colunas
    protected $casts = [
        'empresa' => 'decimal:0',
        'codigo' => 'decimal:0',
    ];

    // Definir os relacionamentos (se houver algum relacionamento com outras tabelas)
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa', 'codigo');
    }
}
