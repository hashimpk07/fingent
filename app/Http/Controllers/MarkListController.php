<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Carbon;
use App\Models\StudentsMarkList;
use App\Models\Students;

class MarkListController extends Controller
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
        $markLists = StudentsMarkList::with('students')
            ->orderBy('student_mark_list.created_at', 'desc')
            ->paginate(10);
        
        if(!empty($markLists)){
            foreach ($markLists as $markListsKey => $markListsValue) {
                if( 1 == $markListsValue->term ){
                    $markListsValue->terms  = '1st Term';
                }else if( 2 == $markListsValue->term ){
                    $markListsValue->terms   = '2nd Term';
                }else if( 3 == $markListsValue->term ){
                    $markListsValue->terms  = '3rd Term';
                }
                $markListsValue->total_marks = $markListsValue->maths + $markListsValue->science + $markListsValue->history;
                $markListsValue->created =  date('M d ,Y h:i A', strtotime($markListsValue->created_at) );
            }
        }
        return view('mark-list.mark-list', ['markLists' => $markLists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students   = Students::all('id', 'name');
        return view('mark-list.mark-list-add',["students" => $students]);
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
            'studentName'   => 'required',
            'science'       => 'required|numeric',
            'maths'         => 'required|numeric',
            'history'       => 'required|numeric',
            'terms'         => 'required',
        ]);

        $studentMarkList = DB::table('student_mark_list')
                    ->select('id')
                    ->where('students_id', '=', $input['studentName'] )
                    ->where('term', '=', $input['terms'] )
                    ->first();
        if(!empty($studentMarkList)){
            return response()->json(['status'=>'error','message' =>'Student This Terms Already Added ! Please Update Data']);
        }else{
            $markList             = new StudentsMarkList;
            $markList->students_id= $input['studentName'];
            $markList->maths      = $input['maths'];
            $markList->science    = $input['science'];
            $markList->history    = $input['history'];
            $markList->term       = $input['terms'];
            $markList->created_at = $today;
            $markList->updated_at = $today;
            $markList->save();
        }
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
        $markList   = DB::table('student_mark_list')->find($id);
        $students   = Students::all('id', 'name');
        return view('mark-list.mark-list-edit')->with([ 'students' => $students , 'markList' => $markList ]);
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
        $today   = Carbon\Carbon::now();

        $validatedData = $request->validate([
            'studentName'   => 'required',
            'science'       => 'required|numeric',
            'maths'         => 'required|numeric',
            'history'       => 'required|numeric',
            'terms'         => 'required',
        ]);
        $id          = $input['id'];
        $studentMarkList = DB::table('student_mark_list')
                    ->select('id')
                    ->where('students_id', '=', $input['studentName'] )
                    ->where('term', '=', $input['terms'] )
                    ->where('id',   '!=', $input['id'] )
                    ->first();
        if(!empty($studentMarkList)){
           return response()->json(['status'=>'error','message' =>'Sorry This Data not Processing']);
        }else{
            $aUpdate     =  [];
            $aUpdate     = [
                'term'        =>  $input['terms'],
                'maths'       =>  $input['maths'],
                'science'     =>  $input['science'],
                'history'     =>  $input['history'],
                'students_id' =>  $input['studentName'],
                'updated_at'  =>  $today
            ];

            $markList = DB::table('student_mark_list')
                ->where('id', $id)
                ->update($aUpdate);
        }

       
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
        $markList = StudentsMarkList::find( $id )->delete();
        return redirect()->back();
    }
}
