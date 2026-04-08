<?php

namespace App\Http\Controllers;

use App\Models\FuelEntry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class FuelEntryController extends Controller
{
    // index(): Fetch all fuel entries for the authenticated user
    public function index()
    {
        return Inertia::render('Dashboard', [
            'entries' => FuelEntry::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get()
        ]);
    }

    // store(): Validate and save the entry
    public function store(Request $request)
    {
        $validated = $request->validate([
            'station_name' => 'required|string|max:255',
            'fuel_type' => 'required|in:Diesel,Unleaded,Premium',
            'price_per_liter' => 'required|numeric|min:0.01', // Price must be > 0
        ]);

        // Save the entry for the current user
        Auth::user()->fuelEntries()->create($validated);

        return redirect()->back();
    }

    // For the delete action in Task 3
    public function destroy(FuelEntry $fuelEntry)
    {
        if ($fuelEntry->user_id === Auth::id()) {
            $fuelEntry->delete();
        }
        return redirect()->back();
    }
}