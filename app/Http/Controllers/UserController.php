<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Document;
use App\Models\Evidence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showData()
    {
        $userId = auth()->id();
        $data['Evidence'] = Evidence::whereHas('document', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->orderBy('id', 'desc')->paginate(5);
        $validDocuments = Document::where('status', 1)->count();
        $pendingDocuments = Document::where('pending', 1)->count();
        $invalidDocuments = Document::where('invalid', 1)->count();
        
        $result = [
            'validDocuments' => $validDocuments,
            'pendingDocuments' => $pendingDocuments,
            'invalidDocuments' => $invalidDocuments
        ];
        
        return view('user.DataEvidence.indexData', compact('data', 'result'));
    }
    
    

    public function createData()
    {
        return view('user.DataEvidence.createData');
    }


    public function storeData(Request $request)
{
    $request->validate([
        'name' => 'required',
        'alamat' => 'required',
        'indikator' => 'required',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'pdf.*' => 'nullable|mimes:pdf|max:2048',
    ]);

    $latestEvidence = Evidence::latest()->first();
    $latestId = $latestEvidence ? $latestEvidence->id : 0;

    $evidence = new Evidence;
    $evidence->id = $latestId + 1;
    $evidence->name = $request->name;
    $evidence->alamat = $request->alamat;
    $evidence->indikator = $request->indikator;
    $evidence->image = []; 
    $evidence->pdf = []; 

    if ($request->hasFile('images')) {
        $images = $request->file('images');
        foreach ($images as $image) {
            $imageFileName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/assets', $imageFileName);
            $evidence->image = array_merge($evidence->image ?? [], [$imageFileName]);
        }
    }
    
    

    if ($request->hasFile('pdf')) {
        $pdfs = $request->file('pdf');
        foreach ($pdfs as $pdf) {
            $pdfFileName = time() . '_' . $pdf->getClientOriginalExtension();
            $pdf->storeAs('public/assets', $pdfFileName);
            $evidence->pdf = array_merge($evidence->pdf ?? [], [$pdfFileName]);
        }
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

    return redirect()->route('home')->with('success', 'Evidence has been created successfully.');
}
public function downloadImage($evidence)
{
    $evidence = Evidence::find($evidence);
    // $imagePath = public_path('/storage/assets/' . $evidence->image);

    if (is_array($evidence->image) && count($evidence->image) > 0) {
        foreach ($evidence->image as $imageName) {
            $imagePath = public_path('/storage/assets/' . $imageName);
        }
    }

    return response()->download($imagePath);
}

public function downloadPDF($evidence)
{
    $evidence = Evidence::find($evidence);
    if (is_array($evidence->pdf) && count($evidence->pdf) > 0) {
        foreach ($evidence->pdf as $pdfName) {
            $pdfPath  = public_path('/storage/assets/' . $pdfName);
        }
    }
    return response()->download($pdfPath);
}
}
