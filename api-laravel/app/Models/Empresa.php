<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';
    protected $primaryKey = 'recnum';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['codigo', 'empresa', 'sigla', 'razao_social'];

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'empresa', 'codigo');
    }
}

