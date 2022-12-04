<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\StudentsMarkList;
use App\Models\Students;

use Carbon;
use Session;
use Hash;  

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }  

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')->withSuccess('You have Successfully loggedin');
        }
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
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
        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function create(array $data)
    {

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function logout() 
    {

        Session::flush();
        Auth::logout();
        return Redirect('login');
    }

}