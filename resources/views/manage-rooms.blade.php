@extends('layouts.layout')
@section('content')
    <div class="container-fluid">
        <div class="row animate__animated animate__bounceInRight">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">LIST OF Rooms</strong>
                        <p class="float-end"><strong class="card-title">Manage Rooms</strong></p>
                        <button id="toolbar" type="button" class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#addRoomModal"><i class="fa-solid fa-circle-plus"></i> Add</button>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table-export" class="table table-striped table-bordered"
                            id="table"
                            data-toolbar="#toolbar"
                            data-toggle="table"
                            data-pagination="true"
                            data-pagination-h-align="left"
                            data-pagination-detail-h-align="right"
                            data-pagination-v-align="bottom"
                            data-search="true"
                            data-searchable="true">
                            <thead>
                                <tr>
                                    <th data-sortable="true">Room #</th>
                                    <th data-sortable="true">Type</th>
                                    <th data-sortable="true">Capacity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rooms as $room)
                                    <tr>
                                        <td>{{$room->room_number}}</td>
                                        <td>{{$room->type}}</td>
                                        <td>{{$room->capacity}}</td>
                                        <td class="text-center">
                                            <span class="fa-solid fa-pen-to-square px-1 py-0 text-success rounded btn" data-toggle="modal" data-toggle="tooltip" data-target="#updateRoom" data-placement="top" title="Edit"  style="cursor: pointer"></span>
                                            <span class="fa-regular fa-trash-can rounded px-1 py-0 btn text-danger" data-toggle="modal" data-toggle="tooltip" data-target="#deleteRoom" data-placement="top" title="Delete" style="cursor: pointer"></span>
                                        </td>
                                    </tr>
                                 @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- start-Modal --}}
    <div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Add Room</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form action="{{route('add-room')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body card-block">
                                <label for="room" class="form-label">Room #</label>
                                <input type="text" id="room" name="room_number" class="form-control mb-3">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" id="capacity" name="capacity" class="form-control mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select id="type" name="type" data-placeholder="Choose a type..." class="form-control form-select mb-3" tabindex="1">
                                    <option value=""></option>
                                    <option value="Lecture">Lecture</option>
                                    <option value="Laboratory">Laboratory</option>
                                </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- end modal --}}
@endsection
@section('scripts')
    
@endsection