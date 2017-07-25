<?php

namespace App\Http\Controllers;

use App\User;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index($slug){
        $user = User::where('slug', $slug)->first();
        return view('profiles.profile')
            ->with('user', $user);
    }

    public function edit(){

        return view('profiles.edit')
            ->with('info', Auth::user()->profile);
    }

    public function update(Request $req){

        $this->validate($req, [
            'location' => 'required',
            'about' => 'required'
        ]);

        Auth::user()->profile()->update([
            'location' => $req->location,
            'about' => $req->about
        ]);

        Session::flash('success', 'Profile updated.');

        return redirect()->back();



    }


}
