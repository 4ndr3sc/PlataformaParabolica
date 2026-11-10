<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AccountServiceWorkflowsTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_select_a_plan_and_admin_generates_invoice_at_catalog_price(): void
    {
        $customer = User::factory()->create(['role' => 'cliente']);
        $admin = User::factory()->create(['role' => 'administrador']);

        $this->actingAs($customer)
            ->post(route('plans.select'), ['plan' => 'wifi_tv'])
            ->assertRedirect();

        $this->assertSame('wifi_tv', $customer->fresh()->selected_plan);
        $this->get('/mis-servicios')->assertOk()->assertSee('WiFi + TV');

        $this->actingAs($admin)
            ->post(route('admin.invoices.store'), [
                'user_id' => $customer->id,
                'billing_period' => now()->format('Y-m'),
                'amount' => 1,
                'plan_key' => 'solo_wifi',
            ])
            ->assertRedirect('/facturas')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('invoices', [
            'user_id' => $customer->id,
            'plan_key' => 'wifi_tv',
            'plan_name' => 'WiFi + TV',
            'amount' => 74900,
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->get('/facturas')
            ->assertOk()
            ->assertSee('Generar factura')
            ->assertSee('FAC-');

        $this->post(route('admin.invoices.store'), [
            'user_id' => $customer->id,
            'billing_period' => now()->format('Y-m'),
        ])->assertSessionHasErrors('billing_period');

        $this->assertDatabaseCount('invoices', 1);
    }

    public function test_guest_plan_request_survives_registration_and_is_linked_to_new_account(): void
    {
        $this->get(route('plans.begin-request', 'solo_television'))
            ->assertRedirect(route('login'))
            ->assertSessionHas('pending_service_plan', 'solo_television');

        $registrationResponse = $this->post('/register', [
            'name' => 'Cliente',
            'lastname' => 'Nuevo',
            'email' => 'nuevo@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $customer = User::where('email', 'nuevo@example.com')->firstOrFail();
        $registrationResponse->assertRedirect(route('plans.confirm'));
        $this->assertAuthenticatedAs($customer);
        $this->assertSame('cliente', auth()->user()->role);
        $this->assertSame('cliente', $customer->role);

        $confirmResponse = $this->get(route('plans.confirm'));
        $confirmResponse
            ->assertOk()
            ->assertSee('Solo Televisión')
            ->assertSee($customer->email);

        $this->post(route('plans.select'), ['plan' => 'solo_television'])
            ->assertRedirect('/mis-servicios')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('service_requests', [
            'user_id' => $customer->id,
            'service_key' => 'solo_television',
            'service_name' => 'Solo Televisión',
            'amount' => 27000,
            'status' => 'pendiente',
        ]);
        $this->get('/mis-servicios')->assertOk()->assertSee('Solo Televisión')->assertSee('Pendiente');
    }

    public function test_active_service_request_cannot_be_submitted_twice_and_admin_can_update_its_status(): void
    {
        $customer = User::factory()->create(['role' => 'cliente']);
        $admin = User::factory()->create(['role' => 'administrador']);

        $this->actingAs($customer)
            ->post(route('plans.select'), ['plan' => 'solo_wifi'])
            ->assertRedirect('/mis-servicios');
        $this->post(route('plans.select'), ['plan' => 'solo_wifi'])
            ->assertSessionHas('success');
        $this->assertDatabaseCount('service_requests', 1);

        $serviceRequest = $customer->serviceRequests()->firstOrFail();
        $otherCustomer = User::factory()->create(['role' => 'cliente']);
        $otherCustomer->serviceRequests()->create([
            'service_key' => 'wifi_tv',
            'service_name' => 'WiFi + TV',
            'amount' => 74900,
            'status' => 'pendiente',
        ]);
        $this->actingAs($customer)
            ->get('/mis-servicios')
            ->assertOk()
            ->assertSee('Solo WiFi')
            ->assertDontSee($otherCustomer->email);

        $this->actingAs($admin)
            ->get('/mis-servicios')
            ->assertOk()
            ->assertSee($customer->email)
            ->assertSee($otherCustomer->email)
            ->assertSee('Solo WiFi');
        $this->patch(route('admin.service-requests.update', $serviceRequest), ['status' => 'aprobada'])
            ->assertRedirect()
            ->assertSessionHas('success');
        $this->assertDatabaseHas('service_requests', [
            'id' => $serviceRequest->id,
            'status' => 'aprobada',
        ]);
    }

    public function test_customer_can_only_see_their_own_invoices(): void
    {
        $customer = User::factory()->create(['role' => 'cliente']);
        $otherCustomer = User::factory()->create(['role' => 'cliente']);

        $invoice = Invoice::create($this->invoiceData($customer));
        Invoice::create($this->invoiceData($otherCustomer));

        $response = $this->actingAs($customer)->get('/facturas');

        $response->assertOk()
            ->assertSee($invoice->invoice_number)
            ->assertDontSee(Invoice::where('user_id', $otherCustomer->id)->value('invoice_number'));
    }

    public function test_customer_can_edit_their_open_ticket_but_not_another_customers_ticket(): void
    {
        $customer = User::factory()->create(['role' => 'cliente']);
        $otherCustomer = User::factory()->create(['role' => 'cliente']);
        $ticket = Ticket::create($this->ticketData($customer));
        $otherTicket = Ticket::create($this->ticketData($otherCustomer));

        $this->actingAs($customer)
            ->patch(route('tickets.update-information', $ticket), [
                'subject' => 'Nueva descripción del problema',
                'description' => 'Agrego información adicional con detalles del problema observado.',
            ])
            ->assertRedirect('/soporte');

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'description' => 'Agrego información adicional con detalles del problema observado.',
        ]);
        $this->get('/soporte')->assertOk()->assertSee('Agrego información adicional con detalles del problema observado.');

        $this->actingAs($customer)
            ->patch(route('tickets.update-information', $otherTicket), [
                'subject' => 'Intento no autorizado',
                'description' => 'Este cambio no debe modificar la PQR de otra persona.',
            ])
            ->assertForbidden();
    }

    public function test_assigned_technician_can_save_a_comment_and_optional_photo(): void
    {
        Storage::fake('public');
        $technician = User::factory()->create(['role' => 'tecnico']);
        $customer = User::factory()->create(['role' => 'cliente']);
        $ticket = Ticket::create($this->ticketData($customer) + ['technician_id' => $technician->id]);

        $this->actingAs($technician)
            ->post('/tecnico/tickets/'.$ticket->id.'/comentario', [
                'technician_comment' => 'Se revisó la alineación de la parabólica.',
                'technician_photo' => UploadedFile::fake()->create('parabolica.jpg', 10, 'image/jpeg'),
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $ticket->refresh();
        $this->assertSame('Se revisó la alineación de la parabólica.', $ticket->technician_comment);
        $this->assertNotNull($ticket->technician_photo);
        Storage::disk('public')->assertExists($ticket->technician_photo);
        $this->get('/tecnico/asignaciones')
            ->assertOk()
            ->assertSee('Se revisó la alineación de la parabólica.');
    }

    private function invoiceData(User $customer): array
    {
        return [
            'user_id' => $customer->id,
            'invoice_number' => 'FAC-'.$customer->id.'-TEST',
            'plan_key' => 'solo_wifi',
            'plan_name' => 'Solo WiFi',
            'amount' => 47900,
            'date' => today(),
            'billing_period' => today()->startOfMonth(),
            'due_date' => today()->addDays(14),
            'status' => 'pending',
        ];
    }

    private function ticketData(User $customer): array
    {
        return [
            'user_id' => $customer->id,
            'ticket_number' => 'TK-'.$customer->id.'-TEST',
            'type' => 'peticion',
            'subject' => 'Falla en la parabólica',
            'description' => 'La señal presenta interrupciones desde ayer por la tarde.',
            'status' => 'abierto',
            'priority' => 'media',
        ];
    }
}
