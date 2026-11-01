<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::where('is_active', true)
            ->orderBy('next_billing_date')
            ->get();

        $totalMonthly = $subscriptions->sum('monthly_cost');

        // Tagihan yang jatuh tempo dalam 7 hari ke depan.
        $dueSoon = $subscriptions->filter(
            fn ($s) => $s->next_billing_date->between(today(), today()->addDays(7))
        );

        return view('subscriptions.index', compact(
            'subscriptions',
            'totalMonthly',
            'dueSoon'
        ));
    }

    public function store(Request $request)
    {
        Subscription::create($this->validated($request));

        return redirect()->route('subscriptions.index');
    }

    public function edit(Subscription $subscription)
    {
        return view('subscriptions.edit', compact('subscription'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $subscription->update($this->validated($request));

        return redirect()->route('subscriptions.index');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return redirect()->route('subscriptions.index');
    }

    // Aturan validasi dipakai bersama oleh store dan update.
    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'next_billing_date' => 'required|date',
            'category' => 'nullable|string|max:50',
        ]);
    }
}