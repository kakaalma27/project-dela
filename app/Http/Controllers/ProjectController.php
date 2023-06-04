<?php

namespace App\Http\Controllers;
use App\Models\Evidence;
use App\Models\Document;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function verif()
    {
        $Evidence = Evidence::all();
        $projects = Document::all();
        return view('admin.verif', compact('Evidence', 'projects'));
    }
    

    public function toggle(Request $request) {
        $project = Document::find($request->project_id);
    
        if ($project->status == 0) {
            $project->status = 1;
        } else {
            $project->status = 0;
        }    
        $project->save();
    
        return response()->json(['status' => (int) $project->status]);
    }

    public function pending(Request $request)
    {
        $project = Document::find($request->project_id);
    
        if ($project->pending == 0) {
            $project->pending = 1;
        } else {
            $project->pending = 0;
        }
    
        $project->save();
    
        return response()->json(['pending' => (int) $project->pending]);
    }
    

    public function invalid(Request $request) {
        $project = Document::find($request->project_id);
    
        if ($project->invalid == 0) {
            $project->invalid = 1;
        } else {
            $project->invalid = 0;
        }    
        $project->save();
    
        return response()->json(['invalid' => (int) $project->invalid]);
    }


}
