<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $invoicesQuery = Invoice::with('user')->latest('date');

        if ($user->isAdministrator()) {
            $now = now();
            $allUsers = User::where('role', 'cliente')->orderBy('name')->get();
            $paidUsersThisMonth = Invoice::with('user')
                ->where('status', 'paid')
                ->whereMonth('date', $now->month)
                ->whereYear('date', $now->year)
                ->get()
                ->pluck('user')
                ->unique('id')
                ->values();
            $unpaidUsersThisMonth = Invoice::with('user')
                ->where('status', 'pending')
                ->whereMonth('billing_period', $now->month)
                ->whereYear('billing_period', $now->year)
                ->get()
                ->pluck('user')
                ->unique('id')
                ->values();
            $unpaidUsersPreviousMonths = Invoice::with('user')
                ->where('status', 'pending')
                ->whereDate('billing_period', '<', $now->copy()->startOfMonth())
                ->get()
                ->pluck('user')
                ->unique('id')
                ->values();

            return view('facturas', [
                'user' => $user,
                'invoices' => $invoicesQuery->get(),
                'all_users' => $allUsers,
                'total_users' => $allUsers->count(),
                'paid_users_this_month' => $paidUsersThisMonth,
                'unpaid_users_this_month' => $unpaidUsersThisMonth,
                'unpaid_users_previous_months' => $unpaidUsersPreviousMonths,
                'paid_this_month' => $paidUsersThisMonth->count(),
                'unpaid_this_month' => $unpaidUsersThisMonth->count(),
                'unpaid_previous_months' => $unpaidUsersPreviousMonths->count(),
                'catalog' => config('plans.catalog'),
            ]);
        }

        $invoices = $invoicesQuery->where('user_id', $user->id)->get();

        return view('facturas', [
            'user' => $user,
            'invoices' => $invoices,
            'paid_total' => $invoices->where('status', 'paid')->sum('amount'),
            'next_invoice' => $invoices->where('status', 'pending')->sortBy('due_date')->first(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'billing_period' => ['required', 'date_format:Y-m'],
        ]);

        $customer = User::where('role', 'cliente')->findOrFail($validated['user_id']);
        $plan = config('plans.catalog.'.$customer->selected_plan);

        if (! $plan) {
            return back()->withInput()->withErrors([
                'user_id' => 'El cliente debe seleccionar un plan antes de generar la factura.',
            ]);
        }

        $billingPeriod = Carbon::createFromFormat('!Y-m', $validated['billing_period']);
        if (Invoice::where('user_id', $customer->id)->whereDate('billing_period', $billingPeriod)->exists()) {
            return back()->withInput()->withErrors([
                'billing_period' => 'Ya existe una factura para este cliente y período.',
            ]);
        }

        Invoice::create([
            'user_id' => $customer->id,
            'invoice_number' => 'FAC-'.now()->format('Ymd').'-'.Str::upper(Str::random(8)),
            'plan_key' => $customer->selected_plan,
            'plan_name' => $plan['name'],
            'amount' => $plan['amount'],
            'date' => today(),
            'billing_period' => $billingPeriod,
            'due_date' => $billingPeriod->copy()->addDays(14),
            'status' => 'pending',
        ]);

        return redirect('/facturas')->with('success', 'La factura se generó correctamente.');
    }
}
