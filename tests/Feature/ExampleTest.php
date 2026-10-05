<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_tecnico_role_sees_sidebar_actions_and_routes(): void
    {
        $user = User::factory()->create([
            'role' => 'tecnico',
            'name' => 'Técnico Test',
        ]);

        $this->actingAs($user);

        $response = $this->get('/dashboard');

        $response->assertRedirect('/tecnico/asignaciones');

        $response = $this->get('/tecnico/asignaciones');
        $response->assertOk();
        $response->assertSee('Ver asignaciones');
        $response->assertDontSee('Resumen');
        $response->assertDontSee('Actualizar estados');
        $response->assertSee('Historial de soporte');

        $profileResponse = $this->get('/perfil');
        $profileResponse->assertOk();
        $profileResponse->assertSee('Ver asignaciones');
        $profileResponse->assertDontSee('Actualizar estados');
        $profileResponse->assertSee('Historial de soporte');

        $ticket = \App\Models\Ticket::create([
            'user_id' => User::factory()->create()->id,
            'technician_id' => $user->id,
            'ticket_number' => 'TK-20260815-0001',
            'type' => 'peticion',
            'subject' => 'Fallo de fibra',
            'description' => 'La conexión de internet falla desde ayer.',
            'priority' => 'alta',
            'status' => 'abierto',
        ]);

        $assignmentResponse = $this->get('/tecnico/asignaciones');
        $assignmentResponse->assertOk();
        $assignmentResponse->assertSee('Marcar en progreso');
        $assignmentResponse->assertSee('Resolver');
        $assignmentResponse->assertSee($ticket->ticket_number);

        $this->post('/tecnico/tickets/' . $ticket->id . '/estado', ['status' => 'en_progreso'])
            ->assertRedirect('/tecnico/asignaciones');

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'status' => 'en_progreso',
        ]);

        $this->get('/tecnico/historial')->assertOk();
    }

    public function test_technician_only_sees_assigned_tickets(): void
    {
        $assignedTechnician = User::factory()->create(['role' => 'tecnico']);
        $otherTechnician = User::factory()->create(['role' => 'tecnico']);

        $assignedTicket = \App\Models\Ticket::create([
            'user_id' => User::factory()->create()->id,
            'technician_id' => $assignedTechnician->id,
            'ticket_number' => 'TK-TECH-ASSIGNED-001',
            'type' => 'peticion',
            'subject' => 'Ticket asignado',
            'description' => 'Debe verse para el técnico asignado',
            'priority' => 'alta',
            'status' => 'abierto',
        ]);

        $otherTicket = \App\Models\Ticket::create([
            'user_id' => User::factory()->create()->id,
            'technician_id' => $otherTechnician->id,
            'ticket_number' => 'TK-TECH-OTHER-001',
            'type' => 'peticion',
            'subject' => 'Ticket de otro técnico',
            'description' => 'No debe verse para este técnico',
            'priority' => 'alta',
            'status' => 'abierto',
        ]);

        $this->actingAs($assignedTechnician);

        $response = $this->get('/tecnico/asignaciones');
        $response->assertOk();
        $response->assertSee($assignedTicket->ticket_number);
        $response->assertDontSee($otherTicket->ticket_number);

        $this->get('/tecnico/historial')->assertOk();
    }

    public function test_admin_can_access_validation_overview(): void
    {
        $admin = User::factory()->create([
            'role' => 'administrador',
            'is_active' => true,
        ]);

        $this->actingAs($admin);

        $response = $this->get('/admin/validacion');

        $response->assertOk();
        $response->assertSee('Control de validación');
        $response->assertSee('Vendidas');
        $response->assertSee('Disponibles');
        $response->assertSee('Utilizadas');
        $response->assertSee('Canceladas');
    }

    public function test_admin_reports_are_available_and_transaction_tracking_is_hidden(): void
    {
        $admin = User::factory()->create([
            'role' => 'administrador',
            'is_active' => true,
        ]);

        $this->actingAs($admin);

        $dashboardResponse = $this->get('/dashboard');
        $dashboardResponse->assertOk();
        $dashboardResponse->assertSee('Reportes y analítica');
        $dashboardResponse->assertDontSee('Seguimiento de transacciones');

        $reportResponse = $this->get('/admin/reportes');
        $reportResponse->assertOk();
        $reportResponse->assertSee('Informes periódicos');
        $reportResponse->assertSee('Rendimiento de ventas');
        $reportResponse->assertSee('Uso de boletos');
        $reportResponse->assertSee('Comportamiento del usuario');
    }

    public function test_admin_can_create_edit_and_deactivate_user_accounts(): void
    {
        $admin = User::factory()->create([
            'role' => 'administrador',
            'is_active' => true,
        ]);

        $this->actingAs($admin);

        $this->post('/admin/users', [
            'name' => 'Aliado Test',
            'email' => 'aliado@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'aliado',
            'is_active' => true,
        ])->assertRedirect('/admin/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'aliado@test.com',
            'role' => 'aliado',
            'is_active' => true,
        ]);

        $user = User::where('email', 'aliado@test.com')->first();

        $this->post('/admin/users/' . $user->id . '/update-role', [
            'role' => 'tecnico',
        ])->assertRedirect('/admin/dashboard');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'tecnico',
        ]);

        $this->post('/admin/users/' . $user->id . '/toggle-status')
            ->assertRedirect('/admin/dashboard');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_active' => false,
        ]);
    }

    public function test_admin_can_assign_ticket_to_technician(): void
    {
        $admin = User::factory()->create(['role' => 'administrador']);
        $technician = User::factory()->create(['role' => 'tecnico']);
        $ticket = \App\Models\Ticket::create([
            'user_id' => User::factory()->create()->id,
            'ticket_number' => 'TK-ADMIN-ASSIGN-001',
            'type' => 'peticion',
            'subject' => 'Problema de red',
            'description' => 'La red está caída',
            'priority' => 'alta',
            'status' => 'abierto',
        ]);

        $this->actingAs($admin);

        $dashboardResponse = $this->get('/admin/dashboard');
        $dashboardResponse->assertOk();
        $dashboardResponse->assertSee('Asignar técnico');
        $dashboardResponse->assertDontSee('Asignar ticket');

        $this->get('/admin/tickets/asignar')->assertOk();

        $this->post('/admin/tickets/' . $ticket->id . '/assign', [
            'technician_id' => $technician->id,
        ])->assertRedirect('/admin/tickets/asignar');

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'technician_id' => $technician->id,
        ]);
    }
}
