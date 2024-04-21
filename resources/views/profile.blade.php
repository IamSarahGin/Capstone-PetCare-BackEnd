@extends('layouts.app')

@section ('title', 'Profile')

@section('contents')

<h1 class="mb-0">Profile</h1>
<hr/>
<form method="POST" enctype="multipart/form-data" id="profile_set_frm" action="">
    <div class="row">
    <div class="col-md-12 border-right">
        <div class="p-3 py-5">
            <div class="dflex justify-content-between align-items-center mb-3">
                <h4 class="text-right">Profile Settings</h4>
            </div>
            <div class="row" id="res"></div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <label class="labels">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="first name" value=" {{ auth()->guard('admin_users')->user()->name }}">
                </div>
                <div class="col-md-6">
                    <label class="labels">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="first name" value=" {{ auth()->guard('admin_users')->user()->email }}">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <label class="labels">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="Phone Number" value=" {{ auth()->guard('admin_users')->user()->phone }}">
                </div>
                <div class="col-md-6">
                    <label class="labels">Address</label>
                    <input type="text" name="address" class="form-control" placeholder="first name" value=" {{ auth()->guard('admin_users')->user()->address }}">
                </div>
                
            </div>
            <div class="mt-5 text-center"><button id="btn" class="btn btn-primary profile-button">Save Profile</button></div>
        </div>
       
    </div>
    </div>
   
</form>
@endsection