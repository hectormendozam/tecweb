<?php
namespace EJEMPLOS\POO;

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

class Cabecera2 {
    private $titulo;
    private $ubicacion;
    private $enlace;

    public function __construct($tittle, $location, $link) {
        $this->titulo = $tittle;
        $this->ubicacion = $location;
        $this->enlace = $link;
    }

    public function graficar() {
        $estilo = 'font-size: 40px; text-align: '.$this->ubicacion;
        echo '<div style="'.$estilo.'">';
        echo '<h4>';
        echo '<a href="'.$this->enlace.'">'.$this->titulo.'</a>';
        echo '</h4>';
        echo '</div>';
    }
}
?>