<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Students;
use App\Models\Teachers;

class StudentsController extends Controller
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
        $students = Students::with('teachers')
            ->orderBy('students.created_at', 'desc')
            ->paginate(10);

        if(!empty($students)){
            foreach ($students as $studentKey => $studentValue) {
                if( '' != $studentValue->date_birth ){
                    $studentValue->age =Carbon::parse($studentValue->date_birth)->age;
                }else{
                    $studentValue->age =  '-';
                }
                if( 1 == $studentValue->gender ){
                    $studentValue->gender  = 'Male';
                }else if( 2 == $studentValue->gender ){
                    $studentValue->gender  = 'Female';
                }
            }
        }
        return view('students.students-list', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers   = Teachers::all('id', 'name');
        return view('students.students-add',["teachers" => $teachers]);
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
        $today     = Carbon::now();

        $validatedData = $request->validate([
            'name'      => 'required',
            'teacherId' => 'required',
            'dob'       => 'required|date',
            'gender'    => 'required',
        ]);

        if( '' != $request->dob ){
            $dob = date('Y-m-d' , strtotime($request->dob));
        }else{
            $dob =  NULL;
        }
        
        $students             = new Students;
        $students->name       = $input['name'];
        $students->gender     = $input['gender'];
        $students->teachers_id= $input['teacherId'];
        $students->date_birth = $dob;
        $students->created_at = $today;
        $students->updated_at = $today;

        $students->save();
        return response()->json(['status'=>'success']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $students   = DB::table('students')->find($id);
        $teachers   = Teachers::all('id', 'name');
        return view('students.students-edit')->with([ 'students' => $students , 'teachers' => $teachers ]);
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
        $input   = $request->all();
        $today   = Carbon::now();

        $validatedData = $request->validate([
            'name'      => 'required',
            'teacherId' => 'required',
            'dob'       => 'required|date',
            'gender'    => 'required',
        ]);

        if( '' != $request->dob ){
            $dob = date('Y-m-d' , strtotime( $request->dob ));
        }else{
            $dob =  NULL;
        }

        $aUpdate     =  [];
        $id          = $input['id'];

        $aUpdate     = [
            'name'       =>  $input['name'],
            'date_birth' =>  $dob,
            'gender'     =>  $input['gender'],
            'teachers_id' => $input['teacherId'],
            'updated_at' =>  $today
        ];

        $students = DB::table('students')
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
        $students = Students::find( $id )->delete();
        return redirect()->back();
    }
}
