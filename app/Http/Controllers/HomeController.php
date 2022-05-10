<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $author = Auth::id();
        $notes = Note::where('author', '=', $author)->orderBy('id','desc')->paginate(5);
        // $notes = Note::all();
        return view('home', compact('notes'));
    }
    public function searched()
    {
        $search_text = $_GET['search_note'];
        $author = Auth::id();
        $notes = Note::where('author', '=', $author)->where('note', 'LIKE', '%'.$search_text.'%')->get();
        // $notes = Note::all();
        return view('searched', compact('notes'));
    }

}
