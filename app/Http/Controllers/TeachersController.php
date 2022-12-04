<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Teachers;
use Carbon;

class TeachersController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = DB::table('teachers')->orderBy('created_at', 'desc')->paginate(10);
        return view('teachers.teachers-list', ['teachers' => $teachers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teachers.teachers-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $input     = $request->all();
        $today     = Carbon\Carbon::now();

        $validatedData = $request->validate([
            'teacher'      => 'required',
        ]);
        
        $teachers             = new Teachers;
        $teachers->name       = $input['teacher'];
        $teachers->created_at = $today;
        $teachers->updated_at = $today;

        $teachers->save();

        return response()->json(['status'=>'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teachers = DB::table('teachers')->find($id);
        return view('teachers.teachers-view')->with([ 'teachers' => $teachers ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teachers = DB::table('teachers')->find($id);
        return view('teachers.teachers-edit')->with([ 'teachers' => $teachers ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $today     = Carbon\Carbon::now();

        $validatedData = $request->validate([
            'teacher'      => 'required'
        ]);
        
        $aUpdate     =  [];
        $id          = $input['id'];

        $aUpdate     = [
            'name'   =>  $input['teacher'],
            'updated_at' => $today
        ];
    
        $teachers = DB::table('teachers')
            ->where('id', $id)
            ->update($aUpdate);
        return response()->json(['status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teachers = Teachers::find( $id )->delete();
        return redirect()->back();
    }
}
