<?php
    class Libro {
        private $id;
        private $titulo;
        private $autor;
        private $editorial;
        private $fecha;
        private $genero;
        private $cantidad;

        public function __construct($id, $titulo, $autor, $editorial, $fecha, $genero, $cantidad) {
            $this->id = $id;
            $this->titulo = $titulo;
            $this->autor = $autor;
            $this->editorial = $editorial;
            $this->fecha = $fecha;
            $this->genero = $genero;
            $this->cantidad = $cantidad;

            }

            public function getIdLibro() {
                return $this->id;
            }

            public function setId($id) {
                $this->id = $id;
            }

            public function getTitulo() {
                return $this->titulo;
            }

            public function setTitulo($titulo) {
                $this->titulo = $titulo;
            }

            public function getAutor() {
                return $this->autor;
            }

            public function setAutor($autor) {
                $this->autor = $autor;
            }

            public function getEditorial() {
                return $this->editorial;
            }

            public function setEditorial($editorial) {
                $this->editorial = $editorial;
            }

            public function getFecha() {
                return $this->fecha;
            }

            public function setFecha($fecha) {
                $this->fecha = $fecha;
            }

            public function getGenero() {
                return $this->genero;
            }

            public function setGenero($genero) {
                $this->genero = $genero;
            }

            public function getCantidad() {
                return $this->cantidad;
            }

            public function setCantidad($cantidad) {
                $this->cantidad = $cantidad;
            }
        
    }
?>