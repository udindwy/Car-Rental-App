<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::latest()->paginate(10);
        return view('admin.features.index', compact('features'));
    }

    public function create()
    {
        return view('admin.features.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:features',
            'icon' => 'nullable|string|max:255',
        ]);

        Feature::create($request->all());

        return redirect()->route('admin.features.index')->with('success', 'Fitur berhasil ditambahkan.');
    }

    public function edit(Feature $feature)
    {
        return view('admin.features.edit', compact('feature'));
    }

    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('features')->ignore($feature->id)],
            'icon' => 'nullable|string|max:255',
        ]);

        $feature->update($request->all());

        return redirect()->route('admin.features.index')->with('success', 'Fitur berhasil diperbarui.');
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return redirect()->route('admin.features.index')->with('success', 'Fitur berhasil dihapus.');
    }
}
