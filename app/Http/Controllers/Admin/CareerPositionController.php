<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CareerPosition;

class CareerPositionController extends Controller
{
    public function index()
    {
        $positions = CareerPosition::ordered()->get();
        return view('admin.careers.index', compact('positions'));
    }

    public function create()
    {
        return view('admin.careers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'responsibilities' => 'required|array|min:1',
            'responsibilities.*' => 'required|string',
            'order' => 'integer|min:0'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets'), $filename);
            $data['image'] = 'assets/' . $filename;
        }

        CareerPosition::create($data);

        return redirect()->route('admin.careers.index')
                        ->with('success', 'Career position created successfully!');
    }

    public function edit(CareerPosition $career)
    {
        return view('admin.careers.edit', compact('career'));
    }

    public function update(Request $request, CareerPosition $career)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'responsibilities' => 'required|array|min:1',
            'responsibilities.*' => 'required|string',
            'order' => 'integer|min:0'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets'), $filename);
            $data['image'] = 'assets/' . $filename;
        }

        $career->update($data);

        return redirect()->route('admin.careers.index')
                        ->with('success', 'Career position updated successfully!');
    }

    public function destroy(CareerPosition $career)
    {
        $career->delete();
        
        return redirect()->route('admin.careers.index')
                        ->with('success', 'Career position deleted successfully!');
    }
}
