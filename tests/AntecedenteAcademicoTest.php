<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../models/AntecedenteAcademico.php';

class AntecedenteAcademicoTest extends TestCase {
    private $pdoMock;
    private $stmtMock;
    private $model;

    protected function setUp(): void {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);
        $this->model = new AntecedenteAcademico($this->pdoMock);
    }

    public function testCrear() {
        $data = [
            'candidato_id' => 1,
            'nivel_educacional' => 'Universitario',
            'titulo' => 'Ingeniero',
            'institucion' => 'U. Chile',
            'fecha_inicio' => '2015-03-01',
            'fecha_termino' => '2020-12-15'
        ];
        $this->assertTrue($this->model->crear($data));
    }
}