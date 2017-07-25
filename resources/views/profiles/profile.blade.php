@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <p class="text-center">
                        {{ $user->name }}'s Profile.
                    </p>

                    <div class="panel-body">
                        <center>
                            <img src="{{ Storage::url($user->avatar) }}" width="140px" heiht="140px" style="border-radius: 50%" alt="">
                        </center>

                        <p class="text-center">
                            @if(Auth::id() == $user->id)
                                <a href="{{ route('profile.edit') }}" class="btn btn-lg btn-info">Edit your profile</a>
                            @endif
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
