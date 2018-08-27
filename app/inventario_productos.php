<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $inventario
 * @property int $medida
 * @property int $producto
 * @property int $usuario
 * @property string $descripcion
 * @property int $precio
 * @property int $importe
 * @property float $cantidad_peso
 * @property float $total
 * @property string $fecha_vencimiento
 * @property string $fecha
 * @property Inventario $inventario
 * @property Medida $medida
 * @property Producto $producto
 * @property User $user
 */
class inventario_productos extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['inventario', 'medida', 'producto', 'usuario', 'descripcion', 'precio', 'importe', 'cantidad_peso', 'total', 'fecha_vencimiento', 'fecha'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventario()
    {
        return $this->belongsTo('App\Inventario', 'inventario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medida()
    {
        return $this->belongsTo('App\Medida', 'medida');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo('App\Producto', 'producto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'usuario');
    }
}
