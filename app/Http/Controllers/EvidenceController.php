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
        $$request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'indikator' => 'required',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf' => 'nullable|mimes:pdf|max:2048',
        ]);
    
        $latestEvidence = Evidence::latest()->first();
        $latestId = $latestEvidence ? $latestEvidence->id : 0;
    
        $evidence = new Evidence;
        $evidence->id = $latestId + 1;
        $evidence->name = $request->name;
        $evidence->alamat = $request->alamat;
        $evidence->indikator = $request->indikator;
        $evidence->image = [];
    
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            dd($image);
            foreach ($images as $image) {
                $imageFileName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/assets', $imageFileName);
                $evidence->image[] = $imageFileName;
            }
        }
    
        if ($request->hasFile('pdf')) {
            $evidence->pdf = $request->file('pdf')->getClientOriginalExtension();
            $request->file('pdf')->storeAs('assets', $evidence->pdf, 'public');
        }
        
        
        $latestEvidence = Document::latest()->first();
        $latestId = $latestEvidence ? $latestEvidence->id : 0;
            
        $evidence->save();
        $user = Auth::user();
        $document = new Document;
        $document->id = $latestId + 1; // Memperbarui nomor urut
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


public function downloadImage($evidence)
{
    $evidence = Evidence::find($evidence);
    $imagePath = public_path('/storage/assets/' . $evidence->image);

    return response()->download($imagePath);
}

public function downloadPDF($evidence)
{
    $evidence = Evidence::find($evidence);
    $pdfPath = public_path('/storage/assets/' . $evidence->pdf);

    return response()->download($pdfPath);
}
}
