<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property float $precio
 * @property int $descuento
 * @property string $imagen
 * @property string $fecha
 * @property int $usuario
 * @property boolean $estado
 * @property MenuPlato[] $menuPlatos
 */
class platos extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['nombre', 'descripcion', 'precio', 'descuento', 'imagen', 'fecha', 'usuario', 'estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuPlatos()
    {
        return $this->hasMany('App\MenuPlato', 'plato');
    }
}
