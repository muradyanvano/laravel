<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Note::where('userId', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('note.index', ['notes' => $models,'trash'=>false]);
    }

    public function trash(){
        $models=Note::onlyTrashed()->where('userId', Auth::id())->orderBy('deleted_at','asc')->get();
        return view('note.index',['notes'=>$models,'trash'=>true]);
    }

    public function restore($id){
        Note::withTrashed()->where('id',$id)->where('userId', Auth::id())->restore();
        return redirect(route('notes.trash'));
    }

    public function remove(Request $request){
        Note::onlyTrashed()->where('userId', Auth::id())->where('id',$request->get('id'))->forceDelete();
        return redirect(route('notes.trash'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('note.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|unique:notes|max:255',
            'body' => 'required'
        ])->validate();

        $data=$request->all();
        $data['userId']=Auth::id();

        $model = Note::create($data);
        if ($model) {
            return redirect('notes');
        } else {
            return back()->with('error', 'Error! Request data is not insert to database');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Notes $notes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Note::where('userId', Auth::id())->find($id);
        if ($model) {
            return view('note.preview', ['note' => $model]);
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Notes $notes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Note::where('userId', Auth::id())->find($id);
        if ($model) {
            return view('note.form', ['note' => $model]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Notes $notes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ])->validate();

        $model = Note::where('id', $id)->where('userId', Auth::id())->update($request->except(['_token', '_method']));
        if ($model) {
            return redirect('notes');
        } else {
            return back()->with('error', 'Error! Failed to update request data');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Notes $notes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Note::destroy($id);
        return redirect('notes');
    }
}
