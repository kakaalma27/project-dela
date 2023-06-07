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
        $data['Evidence'] = Evidence::orderBy('id','desc')->paginate(5);
        
        return view('user.DataEvidence.indexData', $data);
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
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'pdf' => 'required|mimes:pdf|max:2048',
    ]);

    $evidence = new Evidence;
    $evidence->name = $request->name;
    $evidence->alamat = $request->alamat;
    $evidence->indikator = $request->indikator;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageFileName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('assets', $imageFileName, 'public');
        $evidence->image = $imageFileName;
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

    return redirect()->route('home')->with('success', 'Evidence has been created successfully.');
}

}
