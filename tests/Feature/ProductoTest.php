<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin()
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        return $this->actingAs($admin, 'sanctum');
    }

    public function test_puede_listar_productos(): void
    {
        Producto::factory(5)->create();

        $this->actingAsAdmin()
             ->getJson('/api/productos')
             ->assertOk();
    }

    public function test_puede_crear_producto(): void
    {
        $this->actingAsAdmin()
             ->postJson('/api/productos', [
                 'nombre' => 'Laptop Dell',
                 'precio' => 1299.99,
                 'stock'  => 10,
             ])
             ->assertCreated();

        $this->assertDatabaseHas('productos', ['nombre' => 'Laptop Dell']);
    }

    public function test_cliente_no_puede_eliminar(): void
    {
        $cliente  = User::factory()->create(['rol' => 'cliente']);
        $producto = Producto::factory()->create();

        $this->actingAs($cliente, 'sanctum')
             ->deleteJson("/api/productos/{$producto->id}")
             ->assertForbidden();
    }
}