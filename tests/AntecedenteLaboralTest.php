<?php
// entrega_1
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../models/AntecedenteLaboral.php';

class AntecedenteLaboralTest extends TestCase {
    private $pdoMock;
    private $stmtMock;
    private $model;

    protected function setUp(): void {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);
        $this->model = new AntecedenteLaboral($this->pdoMock);
    }

    public function testCrear() {
        $data = [
            'candidato_id' => 1,
            'empresa' => 'SoftTech',
            'cargo' => 'Desarrollador',
            'funciones' => 'Backend en PHP',
            'fecha_inicio' => '2021-01-01',
            'fecha_termino' => '2023-01-01'
        ];
        $this->assertTrue($this->model->crear($data));
    }
}