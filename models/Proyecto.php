<?php

namespace Model;

class Proyecto extends ActiveRecord {
    protected static $tabla = 'proyectos';
    protected static $columnasDB = ['id', 'proyecto', 'url', 'propietarioId'];

    public $id;
    public $proyecto;
    public $url;
    public $propietarioId;

    public function __construct($args = []) 
    {
        $this->id = $args['id'] ?? null;
        $this->proyecto = $args['proyecto'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->propietarioId = $args['propietarioId'] ?? '';
    }
    
    public function validarProyecto() {
        if (!$this->proyecto) {
            self::$alertas['error'][] = 'El nombre del proyecto es obligatorio';
        }
        return self::$alertas;
    }

    public function existeProyecto() {
        $query = " SELECT * FROM " . self::$tabla . " WHERE proyecto = '" . 
        $this->proyecto . "' AND propietarioId = '" . $this->propietarioId . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][] = 'Ya existe un proyecto con ese nombre';
        }
        return $resultado;
    }
}