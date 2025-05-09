<?php
// entrega_1
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../models/Postulacion.php';

class PostulacionTest extends TestCase {
    private $pdoMock;
    private $stmtMock;
    private $model;

    protected function setUp(): void {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);
        $this->model = new Postulacion($this->pdoMock);
    }

    public function testPostular() {
        $data = ['candidato_id' => 1, 'oferta_laboral_id' => 2, 'comentario' => 'Postulación enviada.'];
        $this->assertTrue($this->model->postular($data));
    }

    public function testActualizarParcial() {
        $data = ['estado_postulacion' => 'Revisando', 'comentario' => 'Buen perfil'];
        $this->assertTrue($this->model->actualizarParcial(1, $data));
    }
}