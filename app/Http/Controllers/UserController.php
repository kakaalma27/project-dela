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
        'domain' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'pdf' => 'nullable|mimes:pdf|max:2048',
    ]);

    $evidence = new Evidence;
    $evidence->name = $request->name;
    $evidence->alamat = $request->alamat;
    $evidence->indikator = $request->indikator;
    $evidence->domain = $request->domain;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageFileName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('assets', $imageFileName, 'public');
        $evidence->image = $imageFileName;
    }
    
    if ($request->hasFile('pdf')) {
        $pdf = $request->file('pdf');
        $pdfFileName = time() . '_' . $pdf->getClientOriginalName();
        $pdf->storeAs('assets', $pdfFileName, 'public');
        $evidence->pdf = $pdfFileName;
    }
    

    $evidence->save();
    $user = Auth::user();
    $document = new Document;
    $document->user()->associate($user);
    $document->save();
    $evidence->document()->associate($document);
    $evidence->save();

    return redirect()->route('home')->with('success', 'Evidence has been created successfully.');
}

}
