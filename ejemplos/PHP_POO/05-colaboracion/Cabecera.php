<?php
class Cabecera {
    private $titulo;
    private $ubicacion;

    public function __construct($tittle, $location) {
        $this->titulo = $tittle;
        $this->ubicacion = $location;
    }

    public function graficar() {
        $estilo = 'font-size: 40px; text-align: '.$this->ubicacion;
        echo '<div style="'.$estilo.'">';
        echo '<h4>'.$this->titulo.'</h4>';
        echo '</div>';
    }
}
?>