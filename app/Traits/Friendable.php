<?php

namespace App\Traits;

use App\Friendship;
use App\User;

trait Friendable {

    public function add_friend($user_requested_id){

        // user can't send friend request to itself
        if($this->id === $user_requested_id){
            return 0;
        }

        // if both user already friends
        if($this->is_friends_with($user_requested_id) == 1){
            return "Already friends";
        }


        // if user already send te friend request
        if($this->has_pending_friend_request_sent_to($user_requested_id) === 1){
            return "Already sent a friend request";

        }

        if($this->has_pending_friend_request_from($user_requested_id) === 1 ){
            return $this->accept_friend($user_requested_id);
        }

        $friendship = Friendship::create([
            'requester' => $this->id,
            'user_requested' => $user_requested_id
        ]);

        if($friendship){
            return 1;
        }

        return 0;

    }


    public function accept_friend($requester){

        if($this->has_pending_friend_request_from($requester) === 0){
            return 0;
        }

        $friendship = Friendship::where('requester', $requester)
                                ->where('user_requested', $this->id)
                                ->first();

        if($friendship){
            $friendship->update([
                'status' => 1
            ]);

            return response()->json($friendship, 200);
        }

        return response()->json('fail', 501);

    } // end accept_friend()

    public function friends(){

        $friends = array();

        $f1 = Friendship::where('status', 1)
                        ->where('requester', $this->id)
                        ->get();

        foreach($f1 as $friendship):
            array_push($friends, \App\User::find($friendship->user_requested));
        endforeach;

        $friends2 = array();

        $f2 = Friendship::where('status', 1)
                        ->where('user_requested', $this->id)
                        ->get();
        foreach($f2 as $friendship):
            array_push($friends2, User::find($friendship->requester));
        endforeach;

        return array_merge($friends, $friends2);

    }


    public function pending_friend_requests(){

        $users = array();

        $friendships = Friendship::where('status', 0)
                                ->where('user_requested', $this->id)
                                ->get();

        foreach($friendships as $friendship):
            array_push($users, User::find($friendship->requester));
        endforeach;

        return $users;
    }

    public function friends_ids(){

        return collect($this->friends())->pluck('id')->toArray();
    }

    public function is_friends_with($user_id){

        if(in_array($user_id, $this->friends_ids())){

            return 1;

        } else {

            return 0;
        }
    }

    public function pending_friend_requests_ids(){
        return collect($this->pending_friend_requests())->pluck('id')->toArray();

    }

    public function pending_friend_requests_sent(){
        $users = array();

        $friendships = Friendship::where('status', 0)
                                ->where('requester', $this->id)
                                ->get();

        foreach($friendships as $friendship):
            array_push($users, User::find($friendship->user_requested));

        endforeach;

        return $users;
    }

    public function has_pending_friend_request_from($user_id){
        if(in_array($user_id, $this->pending_friend_requests_ids())){
            return 1;
        } else {
            return 0;
        }
    }


    public function pending_friend_requests_sent_ids(){
        return collect($this->pending_friend_requests_sent())->pluck('id')->toArray();
    }

    // Particular user has send friend request to other user
    // And other user/reciever havn't accept it yet
    public function has_pending_friend_request_sent_to($user_id){

        if(in_array($user_id, $this->pending_friend_requests_sent_ids())){
            return 1;
        } else {
            return 0;
        }

    }













}