<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipsController extends Controller
{

    public function check($id){
        if(Auth::user()->is_friends_with($id)){
            return ["status" => "friends"];
        }

        if(Auth::user()->has_pending_friend_request_from($id)){
            return ["status" => "pending"];
        }

        if(Auth::user()->has_pending_friend_request_sent_to($id)){
            return ["status" => "waiting"];
        }

        return ["status" => 0];

    }

    public function add_friend($id){
        // sending notifications, email, broadcasting. in next lectures
        return Auth::user()->add_friend($id);
    }

    public function accept_friend($id){
        //sending nots
        return Auth::user()->accept_friend($id);
    }

}
