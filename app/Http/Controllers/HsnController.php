<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hsn;

class HsnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hsns = Hsn::latest()->paginate(10);
        return view('hsns.index', compact('hsns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hsns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            //'hsn_code' => 'required|unique:hsns,hsn_code',
            'hsn_code' => 'required|digits_between:4,8|numeric|unique:hsns,hsn_code,' . ($hsn->id ?? 'NULL'),
            'description' => 'required',
        ],
    [
        'hsn_code.required' => 'HSN code is mandatory.',
        'hsn_code.digits_between' => 'HSN code must be between 4 and 8 digits.',
        'hsn_code.numeric' => 'HSN code must contain only numbers.',
        'hsn_code.unique' => 'This HSN code already exists.',
        'description.required' => 'Description is required.',
    ]
);

        Hsn::create($request->all());

        return redirect()->route('hsns.index')->with('success', 'HSN created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hsn $hsn)
    {
        return view('hsns.edit', compact('hsn'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hsn $hsn)
    {
        $request->validate([
            //'hsn_code' => 'required|unique:hsns,hsn_code,' . $hsn->id,
            'hsn_code' => 'required|digits_between:4,8|numeric|unique:hsns,hsn_code,' . $hsn->id,  
            'description' => 'required',
        ],
        [
            'hsn_code.required' => 'HSN code is mandatory.',
            'hsn_code.digits_between' => 'HSN code must be between 4 and 8 digits.',
            'hsn_code.numeric' => 'HSN code must contain only numbers.',
            'hsn_code.unique' => 'This HSN code already exists.',
            'description.required' => 'Description is required.',
        ]
    );

        $hsn->update($request->all());

        return redirect()->route('hsns.index')->with('success', 'HSN updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hsn $hsn)
    {
        $hsn->delete();
        return redirect()->route('hsns.index')->with('success', 'HSN deleted successfully.');
    }
}
