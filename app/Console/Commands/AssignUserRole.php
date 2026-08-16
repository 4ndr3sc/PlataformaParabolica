<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AssignUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:assign-role {email} {role}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Asigna un rol a un usuario. Roles disponibles: cliente, administrador, tecnico';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        // Validar que el rol sea válido
        $validRoles = ['cliente', 'administrador', 'tecnico'];
        if (!in_array($role, $validRoles)) {
            $this->error('Rol inválido. Roles disponibles: ' . implode(', ', $validRoles));
            return Command::FAILURE;
        }

        // Buscar el usuario
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error('Usuario no encontrado con el email: ' . $email);
            return Command::FAILURE;
        }

        // Asignar el rol
        $oldRole = $user->role;
        $user->update(['role' => $role]);

        $this->info('✓ Rol actualizado exitosamente');
        $this->line("Usuario: {$user->name}");
        $this->line("Email: {$user->email}");
        $this->line("Rol anterior: {$oldRole}");
        $this->line("Nuevo rol: {$role}");

        return Command::SUCCESS;
    }
}
