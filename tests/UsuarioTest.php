<?php
// entrega_1
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioTest extends TestCase {
    private $pdoMock;
    private $stmtMock;
    private $model;

    protected function setUp(): void {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);
        $this->model = new Usuario($this->pdoMock);
    }

    public function testCrear() {
        $data = [
            'nombre' => 'Andrés',
            'apellido' => 'Corbacho',
            'email' => 'andres@example.com',
            'contrasena' => '123456',
            'fecha_nacimiento' => '1990-01-01',
            'telefono' => '987654321',
            'direccion' => 'Providencia',
            'rol' => 'Candidato'
        ];
        $this->assertTrue($this->model->crear($data));
    }

    public function testCrearFalla() {
        // Simula que execute retorna false (fallo en la inserción)
        $stmtMockFail = $this->createMock(PDOStatement::class);
        $stmtMockFail->method('execute')->willReturn(false);
        $this->pdoMock = $this->createMock(PDO::class); // Nueva instancia para aislar el mock
        $this->pdoMock->method('prepare')->willReturn($stmtMockFail);
        $model = new Usuario($this->pdoMock);

        $data = [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan@example.com',
            'contrasena' => 'abcdef',
            'fecha_nacimiento' => '1985-05-05',
            'telefono' => '123456789',
            'direccion' => 'Las Condes',
            'rol' => 'Candidato'
        ];
        $this->assertFalse($model->crear($data));
    }

    public function testCrearDatosIncompletos() {
        // Simula que falta un campo requerido
        $this->stmtMock->method('execute')->willReturn(true);
        $data = [
            'nombre' => 'Ana',
            // Falta 'apellido'
            'email' => 'ana@example.com',
            'contrasena' => 'qwerty',
            'fecha_nacimiento' => '1992-02-02',
            'telefono' => '555555555',
            'direccion' => 'Ñuñoa',
            'rol' => 'Candidato'
        ];
        // Dependiendo de la implementación del modelo, puede lanzar excepción o retornar false
        $this->expectException(Exception::class);
        $this->model->crear($data);
    }
}