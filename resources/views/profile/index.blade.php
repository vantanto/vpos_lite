@extends('layouts.app')
@section('style')
<style>
    .avatar-edit {
        position: relative;
    }
    .avatar-edit #imageUpload {
        display: none;
    }

    .avatar-edit>label {
        display: block;
        position: absolute;
        bottom: 0;
        right: 0;
    }
</style>
@endsection
@section('header')
<div class="col-sm-6">
    <h1>User Profile</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </ol>
</div>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form id="mainForm" method="post" action="{{ route('profiles.update') }}" autocomplete="off" enctype="multipart/form-data">
                    @csrf                    
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">

                            <div class="d-flex justify-content-center">
                                <div class="avatar-edit">
                                    <img id="imagePreview" class="profile-user-img img-fluid img-circle" src='{{ asset($user->avatar_url) }}' alt="User profile picture">
                                    <input type='file' id="imageUpload" name="avatar" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload" class="btn btn-default btn-sm rounded-circle text-primary">
                                        <i class="fa fa-camera"></i>
                                    </label>
                                </div>
                            </div>
            
                            <h3 class="profile-username text-center">{{ $user->username }}</h3>
            
                            <p class="text-muted text-center">
                                {{ $user->email }}
                                <br>
                                <small>Since {{ date('F Y', strtotime($user->created_at)) }}</small>
                            </p>
            
                            <div class="form-group">
                                <label for="name" class="required">Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Customer phone"
                                    required
                                    value="{{ $user->name }}">
                                <div class="invalid-feedback"></div>    
                            </div>
            
                            <button type="submit" id="mainFormBtn" class="btn btn-primary btn-block">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>mainFormSubmit();</script>
<script>
$(document).ready(function(){
    $("#imageUpload").change(function(data){
        var imageFile = data.target.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(imageFile);

        reader.onload = function(evt){
            $('#imagePreview').attr('src', evt.target.result);
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
    });
});
</script>
@endsection
