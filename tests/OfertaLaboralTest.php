<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../models/OfertaLaboral.php';

class OfertaLaboralTest extends TestCase {
    private $pdoMock;
    private $stmtMock;
    private $model;

    protected function setUp(): void {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);
        $this->model = new OfertaLaboral($this->pdoMock);
    }

    public function testCrear() {
        $data = [
            'titulo' => 'Backend Dev',
            'descripcion' => 'API REST',
            'ubicacion' => 'Santiago',
            'salario' => '1800000',
            'tipo_contrato' => 'Indefinido',
            'fecha_cierre' => '2025-12-31',
            'reclutador_id' => 1
        ];
        $this->assertTrue($this->model->crear($data));
    }

    public function testActualizar() {
        $data = ['titulo' => 'Nuevo Título'];
        $this->assertTrue($this->model->actualizar(1, $data));
    }

    public function testEliminar() {
        $this->assertTrue($this->model->eliminar(1));
    }
}