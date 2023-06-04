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

    /**
     * Store a newly created resource in storage.
     */
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
        $userData = new User;

        return redirect()->route('home')->with('success', 'Evidence has been created successfully.');

    }
}
