<?php

namespace App\Http\Controllers;
use App\Models\Document;

use App\Models\Evidence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userHome()
    {
        $user_id = Auth::id();
        $user = Document::where('user_id', $user_id);
    
        if ($user->exists() && $user->first()->user_id === $user_id) {
            $totalDocuments = Evidence::count();
            $validDocuments = Document::where('status', 1)->where('user_id', $user_id)->count();
            $pendingDocuments = Document::where('pending', 1)->where('user_id', $user_id)->count();
            $invalidDocuments = Document::where('invalid', 1)->where('user_id', $user_id)->count();
    
            $visitors = Document::select(
                DB::raw('SUM(status) as total_status'), 
                DB::raw('SUM(pending) as total_pending'),
                DB::raw('SUM(invalid) as total_invalid')
            )
            ->where('user_id', $user_id)
            ->orderBy(DB::raw("YEAR(created_at)"))
            ->groupBy(DB::raw("YEAR(created_at)"))
            ->get();            
            
            $result = [
                ['status', 'pending', 'invalid'],
                ['status', $validDocuments, 0],
                ['pending', $pendingDocuments, 0],
                ['invalid', $invalidDocuments, 0]
            ]; 
    
            return view('user.dashboard', compact('totalDocuments', 'validDocuments', 'pendingDocuments', 'invalidDocuments', 'result'));
        }
    
        // Jika tidak ada dokumen yang sesuai dengan ID pengguna yang diotentikasi
        return view('user.dashboard', compact('user_id'));
    }
        
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        // $documents = Document::all();
        $totalDocuments = Evidence::count();
        $validDocuments = Document::where('status', 1)->count();
        $pendingDocuments = Document::where('pending', 1)->count();
        $invalidDocuments = Document::where('invalid', 1)->count();

        $visitors = Document::select(
            DB::raw('SUM(status) as total_status'), 
            DB::raw('SUM(pending) as total_pending'),
            DB::raw('SUM(invalid) as total_invalid'),
        )
        ->orderBy(DB::raw("YEAR(created_at)"))
        ->groupBy(DB::raw("YEAR(created_at)"))
        ->get();            
        $result = [
            ['status', 'pending', 'invalid'],
            ['status', $validDocuments, 0],
            ['pending', $pendingDocuments, 0],
            ['invalid', $invalidDocuments, 0],
        ]; 
        return view('admin.dashboard', compact('totalDocuments', 'validDocuments','pendingDocuments','invalidDocuments', 'result'));
    }
    

}