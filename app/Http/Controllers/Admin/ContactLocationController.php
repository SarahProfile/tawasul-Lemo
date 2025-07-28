<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactLocation;
use Illuminate\Http\Request;

class ContactLocationController extends Controller
{
    public function index()
    {
        $locations = ContactLocation::ordered()->get();
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'map_embed_url' => 'required|url',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        ContactLocation::create($request->all());

        return redirect()->route('admin.locations.index')
            ->with('success', 'Contact location created successfully.');
    }

    public function show(ContactLocation $location)
    {
        return view('admin.locations.show', compact('location'));
    }

    public function edit(ContactLocation $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, ContactLocation $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'map_embed_url' => 'required|url',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $location->update($request->all());

        return redirect()->route('admin.locations.index')
            ->with('success', 'Contact location updated successfully.');
    }

    public function destroy(ContactLocation $location)
    {
        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('success', 'Contact location deleted successfully.');
    }
}
