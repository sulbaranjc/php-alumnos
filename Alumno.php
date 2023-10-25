<?php

class Alumno {
    private $nombre;
    private $apellido;
    private $telefono;
    private $email;
    private $nota1;
    private $nota2;
    private $nota3;
    private $asistencia;
    private $examenFinal;

    public function __construct($nombre, $apellido, $telefono, $email, $nota1, $nota2, $nota3, $asistencia, $examenFinal) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->nota1 = $nota1;
        $this->nota2 = $nota2;
        $this->nota3 = $nota3;
        $this->asistencia = $asistencia;
        $this->examenFinal = $examenFinal;
    }

    // Getters
    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getNota1() {
        return $this->nota1;
    }

    public function getNota2() {
        return $this->nota2;
    }

    public function getNota3() {
        return $this->nota3;
    }

    public function getAsistencia() {
        return $this->asistencia;
    }

    public function getExamenFinal() {
        return $this->examenFinal;
    }

    public function getNotaAcumulada() {
        return $this->nota1 * 0.2 + $this->nota2 * 0.2 + $this->nota3 * 0.2 + $this->asistencia * 0.1 + $this->examenFinal * 0.3;
    }

    // Setters
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setNota1($nota1) {
        $this->nota1 = $nota1;
    }

    public function setNota2($nota2) {
        $this->nota2 = $nota2;
    }

    public function setNota3($nota3) {
        $this->nota3 = $nota3;
    }

    public function setAsistencia($asistencia) {
        $this->asistencia = $asistencia;
    }

    public function setExamenFinal($examenFinal) {
        $this->examenFinal = $examenFinal;
    }
}

?>
