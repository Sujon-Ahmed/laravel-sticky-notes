<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    // note store
    public function store(Request $request)
    {
        Note::insert([
            'author' => Auth::user()->id,
            'note' => $request->note,
            'created_at' => Carbon::now(),
        ]);
        return redirect('/home')->with('status', 'note added successfully!');
    }
    // note destroy
    public function destroy(Request $request)
    {
        $noteId = $request->input('noteDeletedId');
        $note = Note::find($noteId);
        $note->delete();
        return redirect('/home')->with('status', 'Note Deleted Successfully!');
    }
    // edit
    public function edit($id)
    {
        $note_info = Note::find($id);
        return response()->json([
            'status' => 200,
            'note_info' => $note_info,
        ]);
    }
    // update
    public function update(Request $request)
    {
        $note_id = $request->input('editNoteId');
        Note::find($note_id)->update([
            'note' => $request->editNote,
        ]);
        return redirect('/home')->with('status', 'Note Updated Successfully!');
    }

}
