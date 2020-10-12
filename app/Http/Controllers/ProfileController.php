<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
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

    public function index(){
        return view('profile');
    }

    public function update(Request $request, $id){

        $user = User::where('id', '=', $id)->firstOrFail();

        if($request->current_password || $request->new_password){
            $request->validate([
                'current_password' => ['required', new MatchOldPassword],
                'new_password' => ['required','string', 'min:8', 'confirmed'],
                'new_confirm_password' => ['same:new_password'],
            ]);

            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
            return redirect()->action('ProfileController@index')
                            ->with('success','Profile and Password changed successfully.');
        }

        if($request->username != $user->username){
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:users'],
            ]);
        }
        if($request->email != $user->email){
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();
        return redirect()->action('ProfileController@index')
            ->with('success','Profile updated successfully.');
    }
}
