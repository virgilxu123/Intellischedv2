@extends('layouts.layout')

@section('content')
    <div class="container-fluid">
        <div class="mb-3 row animate__animated animate__bounceInRight">
            <h4>Admin Dashboard</h4>
        </div>
        <div class="row animate__animated animate__bounceInRight">
            <div class="col-12 col-md-6 d-flex">
                <div class="card flex-fill border-0 illustration">
                    <div class="card-body p-0 d-flex flex-fill">
                        <div class="row g-0 w-100">
                            <div class="col-6">
                                <div class="p-3 m-1">
                                    <h4>Welcome Back, Admin</h4>
                                    <p class="mb-0">Admin Dashboard, Intellisched</p>
                                </div>
                            </div>
                            <div class="col-6 align-self-end text-end">
                                <img src="{{asset('admin-assets/image/icon-admin-8.jpg')}}" class="img-fluid illustration-img"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row animate__animated animate__bounceInRight">
            <div class="col-6 col-md-3 d-flex">
                <div class="card flex-fill border-0 text-bg-danger">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h4 class="mb-2 fs-6">
                                    Schedule
                                </h4>
                                <div class="mb-0">
                                    <span class="badge text-bg-success me-2">
                                        Recent:
                                    </span>
                                    <span>
                                        <em>
                                            <a href="{{ $academic_year_terms->isNotEmpty() ? route('create-schedule', $academic_year_terms->sortByDesc('created_at')->first()->id) : '#' }}" style="font-size: small">
                                                {{ $academic_year_terms->isNotEmpty() ? $academic_year_terms->sortByDesc('created_at')->first()->academic_year->year_start . '-' . ($academic_year_terms->sortByDesc('created_at')->first()->academic_year->year_start + 1) . ' ' . $academic_year_terms->sortByDesc('created_at')->first()->term->term : 'No schedule to show' }}
                                            </a>
                                        </em>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 d-flex">
                <div class="card flex-fill border-0 text-bg-warning">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h4 class="mb-2">
                                    {{$numberOfClasses}}
                                </h4>
                                <p class="mb-2">
                                    Number of Classes
                                </p>
                                <div class="mb-0">
                                    <span class="badge text-bg-success me-2">
                                        Scheduled: {{$numberOfScheduledClasses}}
                                    </span>
                                    <span class="badge text-bg-danger me-2">
                                        Unscheduled: {{$numberOfUnScheduledClasses}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 d-flex">
                <div class="card flex-fill border-0 text-bg-primary">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h4 class="mb-2">
                                    {{$numberOfFacultyMembers}}
                                </h4>
                                <p class="mb-2">
                                    Faculty Members
                                </p>
                                <div class="mb-0">
                                    <span class="badge text-bg-success me-2">
                                        Available: {{$numberOfAvailableFacultyMembers}}
                                    </span>
                                    <span class="badge text-bg-danger me-2">
                                        Unavailable: {{$numberOfUnAvailableFacultyMembers}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 d-flex">
                <div class="card flex-fill border-0 text-bg-info">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h4 class="mb-2">
                                    {{$classrooms->count()}}
                                </h4>
                                <p class="mb-2">
                                    Number of Rooms
                                </p>
                                <div class="mb-0">
                                    <span class="badge text-bg-success me-2">
                                        Lecture: {{$classrooms->where('type','Lecture')->count()}}
                                    </span>
                                    <span class="badge text-bg-info me-2">
                                        Laboratory: {{$classrooms->where('type','Laboratory')->count()}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection