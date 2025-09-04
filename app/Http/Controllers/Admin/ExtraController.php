<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extra;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExtraController extends Controller
{
    public function index()
    {
        $extras = Extra::latest()->paginate(10);
        return view('admin.extras.index', compact('extras'));
    }

    public function create()
    {
        return view('admin.extras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:extras',
            'type' => ['required', Rule::in(['per_day', 'per_booking'])],
            'price' => 'required|numeric|min:0',
        ]);

        Extra::create($request->all());

        return redirect()->route('admin.extras.index')->with('success', 'Layanan tambahan berhasil dibuat.');
    }

    public function edit(Extra $extra)
    {
        return view('admin.extras.edit', compact('extra'));
    }

    public function update(Request $request, Extra $extra)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('extras')->ignore($extra->id)],
            'type' => ['required', Rule::in(['per_day', 'per_booking'])],
            'price' => 'required|numeric|min:0',
        ]);

        $extra->update($request->all());

        return redirect()->route('admin.extras.index')->with('success', 'Layanan tambahan berhasil diperbarui.');
    }

    public function destroy(Extra $extra)
    {
        $extra->delete();
        return redirect()->route('admin.extras.index')->with('success', 'Layanan tambahan berhasil dihapus.');
    }
}
