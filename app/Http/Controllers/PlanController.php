<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function beginRequest(string $plan): RedirectResponse
    {
        abort_unless(array_key_exists($plan, config('plans.catalog')), 404);

        if (auth()->check()) {
            if (auth()->user()->role !== 'cliente') {
                return redirect('/dashboard')->with('error', 'Solo las cuentas de cliente pueden solicitar servicios.');
            }

            return redirect()->route('plans.confirm');
        }

        session(['pending_service_plan' => $plan]);
        session()->put('url.intended', route('plans.confirm'));

        return redirect()->route('login')->with('status', 'Inicia sesión o crea una cuenta para solicitar este servicio.');
    }

    public function confirm(Request $request): View|RedirectResponse
    {
        if ($request->user()->role !== 'cliente') {
            return redirect('/dashboard')->with('error', 'Solo las cuentas de cliente pueden solicitar servicios.');
        }

        $plan = session('pending_service_plan');
        abort_unless(is_string($plan) && array_key_exists($plan, config('plans.catalog')), 404);

        return view('planes.confirmar', [
            'planKey' => $plan,
            'plan' => config('plans.catalog.'.$plan),
        ]);
    }

    public function select(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plan' => ['required', 'string', 'in:'.implode(',', array_keys(config('plans.catalog')))],
        ]);

        $user = $request->user();
        if ($user->role !== 'cliente') {
            abort(403, 'Solo las cuentas de cliente pueden solicitar servicios.');
        }

        $planKey = $validated['plan'];
        $plan = config('plans.catalog.'.$planKey);
        $existingRequest = $user->serviceRequests()
            ->where('service_key', $planKey)
            ->whereIn('status', ['pendiente', 'aprobada'])
            ->exists();

        if ($existingRequest) {
            session()->forget('pending_service_plan');

            return redirect('/mis-servicios')->with('success', 'Ya tienes una solicitud activa para este plan.');
        }

        $user->serviceRequests()->create([
            'service_key' => $planKey,
            'service_name' => $plan['name'],
            'amount' => $plan['amount'],
            'status' => 'pendiente',
        ]);
        $user->update(['selected_plan' => $planKey]);
        session()->forget('pending_service_plan');

        return redirect('/mis-servicios')->with('success', 'Tu solicitud fue enviada y quedó vinculada a tu cuenta.');
    }
}
