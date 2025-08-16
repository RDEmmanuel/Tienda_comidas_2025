<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'adicional',
        'descuento',
        'total',
        'direccion_envio',
        'estado',
        'metodo_pago',
    ];

    /**
     * Un pedido puede tener muchos detalles.
     */
    public function detalles()
    {
        return $this->hasMany(PedidoDetalle::class, 'pedido_id');
    }
}
