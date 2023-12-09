<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'correo',
        'calle',
        'cp',
        'numero_interior',
        'municipio',
        'estado',
        'numero_telefonico',
        'status'
    ];

    public function productos()
    {
        return $this->hasMany(PedidoProducto::class, 'id_pedido');
    }

    public function calcularTotal()
    {
        $total = 0;

        foreach ($this->productos as $producto) {
            $total += $producto->precio * $producto->cantidad;
        }

        return $total;
    }
}
