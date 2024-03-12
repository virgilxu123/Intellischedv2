@extends('layouts.layout')
@section('content')
    <div class="container-fluid mt-3 animate__animated animate__bounceInRight">
        <div class="">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="mx-autod-block">
                                <div class="row justify-content-md-center">
                                    <img class="rounded-circle col-lg-9" src="{{asset('admin-assets/image/no-image-icon.png')}}" alt="Profile Pic">
                                </div>
                                <h5 class="text-sm-center mt-2 mb-1">{{$faculty->first_name}} {{$faculty->last_name}}</h5>
                                <div class="location text-sm-center">{{$faculty->rank}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header text-bg-info">
                            <strong class="card-title">Personal Details</strong>
                        </div>
                        
                            <div class="card-body card-block">
                                <form action="" method="post" class="">
                                    <div class="row mb-3">
                                        <div class="form-group col-lg-6">
                                            <label for="name" class=" form-label">First Name</label>
                                            <input type="text" id="name" name="name" value="{{$faculty->first_name}}" class="form-control">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name" class=" form-label">Last Name</label>
                                            <input type="text" id="name" name="name" value="{{$faculty->last_name}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group col-lg-6">
                                            <label for="rank" class=" form-label">Rank</label>
                                            <select name="rank" data-placeholder="sdfasfsa" class="form-control form-select" tabindex="1">
                                                <option value="{{$faculty->rank}}">{{$faculty->rank}}</option>
                                                <option value="Instructor 1">Instructor 1</option>
                                                <option value="Instructor 2">Instructor 2</option>
                                                <option value="Instructor 3">Instructor 3</option>
                                                <option value="Assistant Professor 1">Assistant Professor 1</option>
                                                <option value="Assistant Professor 2">Assistant Professor 2</option>
                                                <option value="Assistant Professor 3">Assistant Professor 3</option>
                                                <option value="Assistant Professor 4">Assistant Professor 4</option>
                                                <option value="Associate Professor 1">Associate Professor 1</option>
                                                <option value="Associate Professor 2">Associate Professor 2</option>
                                                <option value="Associate Professor 3">Associate Professor 3</option>
                                                <option value="Associate Professor 4">Associate Professor 4</option>
                                                <option value="Associate Professor 5">Associate Professor 5</option>
                                                <option value="Professor 1">Professor 1</option>
                                                <option value="Professor 2">Professor 2</option>
                                                <option value="Professor 3">Professor 3</option>
                                                <option value="Professor 4">Professor 4</option>
                                                <option value="Professor 5">Professor 5</option>
                                                <option value="Professor 6">Professor 6</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="nf-password" class=" form-label">Status</label>
                                            <select name="status" data-placeholder="" class="form-control form-select" tabindex="1">
                                                <option value="{{$faculty->status}}">{{$faculty->status}}</option>
                                                <option value="Permanent">Permanent</option>
                                                <option value="Contractual">Contractual</option>
                                                <option value="Part time">Part time</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group col-lg-6">
                                            <label for="workload" class=" form-label">Units</label>
                                            <input type="text" id="workload" name="workload" disabled value="21" class="form-control">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="workload" class=" form-label">Designation</label>
                                            <input type="text" id="workload" name="workload" disabled value="ICT Director" class="form-control">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded float-right">Update</button>
                                </form>
                            </div>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-bg-success">
                            <strong class="card-title">Work Load</strong>
                        </div>
                        <div class="card-body">
                            <table 
                                id="table" 
                                data-toggle="table" 
                                class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Day/Time</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Students</th>
                                        <th scope="col">Room</th>
                                        <th scope="col">Type</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection