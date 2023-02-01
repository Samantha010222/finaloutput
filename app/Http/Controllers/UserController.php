<?php

namespace App\Http\Controllers;
use DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use App\Illuminate\Http\Response;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::all();    
        return view('user.user', [
            'header' => 'Add User',
            'user' => User::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required',  Rules\Password::defaults()],
        ]);
        User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
        ]);
        session()->flash('status', 'Added User Successfully');
        return redirect('/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('user.form', [
            'header' => 'Update User',
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
               $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => [ Rules\Password::defaults()],
        ]);
        $user = User::find($id);
        $user->update($request->all());
        session()->flash('status', 'Updated User Successfully');
        return redirect('/user/update/' . $user->id);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user->delete();
        return redirect()->route('/user')
                        ->with('success','deleted successfully');
    }
    public function form()
    {
        //
        return view('user.form',[
            'user' => User::all(),
            'header' => 'Add User',
           

        ]); 

    }
}
