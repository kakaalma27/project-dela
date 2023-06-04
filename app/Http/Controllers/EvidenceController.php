<?php

namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\Evidence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvidenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['Evidence'] = Evidence::orderBy('id','desc')->paginate(5);
        return view('admin.evidence.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.evidence.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'indikator' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf' => 'required|mimes:pdf|max:2048',
        ]);
    
        $evidence = new Evidence;
        $evidence->name = $request->name;
        $evidence->alamat = $request->alamat;
        $evidence->indikator = $request->indikator;
    
        if ($request->hasFile('image')) {
            $evidence->image = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('assets', $evidence->image, 'public');
        }
    
        if ($request->hasFile('pdf')) {
            $evidence->pdf = $request->file('pdf')->getClientOriginalExtension();
            $request->file('pdf')->storeAs('assets', $evidence->pdf, 'public');
        }

        $evidence->save();
        $user = Auth::user();
        $document = new Document;
        $document->user()->associate($user);
        $document->save();
        $evidence->document()->associate($document);
        $evidence->save();

        return redirect()->route('evidence.index')->with('success', 'Evidence has been created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.evidence.show',["Evidence"=>Evidence::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.evidence.edit',["Evidence"=>Evidence::find($id)]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'indikator' => 'required',
            'evidence' => 'required'
            ]);
        $evidence = Evidence::find($id);
        $evidence->name = $request->name;
        $evidence->alamat = $request->alamat;
        $evidence->indikator = $request->indikator;
        $evidence->evidence = $request->evidence;
        $evidence->save();
        return redirect()->route('evidence.index')
        ->with('success','evidence has been updated successfully.');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Evidence::find($id)->delete();
        Document::find($id)->delete();
        return redirect()->route('evidence.index')
                        ->with('success','Product deleted successfully');
    }
}
