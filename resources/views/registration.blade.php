@extends('layout')
@section('hero')
    <div class="container">
        <form class="row g-3" method="POST" action="{{ route('registration_submit') }}"">
            @csrf
            <div class="col-6">
                <label for="inputname" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Your Name">
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" name="email" placeholder="Enter Email" class="form-control" id="inputEmail4">
            </div>
            <div class="col-6">
                <label for="inputmobile" class="form-label">mobile</label>
                <input type="text" name="mobile" class="form-control" placeholder="Enter Your mobile">
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Password</label>
                <input type="password" name="password" placeholder="Enter Password" class="form-control"
                    id="inputPassword4">
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" name="address" class="form-control" id="inputAddress"
                    placeholder="Enter Your address">
            </div>
            <div class="col-md-4">
                <label for="inputGender" class="form-label">Gender</label>
                <select id="inputGender" name="gender" class="form-select">
                    <option selected>Choose...</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
@endsection
