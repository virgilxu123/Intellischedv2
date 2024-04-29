@extends('layouts.layout')
@section('content')
    <div class="container-fluid">
        <div class="row animate__animated animate__fadeIn">
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
                                    <th data-sortable="true">Availability</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rooms as $room)
                                    <tr>
                                        <td>{{$room->room_number}}</td>
                                        <td>{{$room->type}}</td>
                                        <td>{{$room->capacity}}</td>
                                        <td><span class="badge {{$room->availability?'text-bg-success':'text-bg-danger'}}">{{$room->availability ? 'Available':'Not Available'}}</span></td>
                                        <td class="text-center">
                                            <span class="fa-solid fa-pen-to-square px-1 py-0 text-success rounded btn" data-bs-toggle="modal" data-toggle="tooltip" data-bs-target="#updateRoom" data-placement="top" title="Edit"  style="cursor: pointer" data-room-id="{{$room->id}}"></span>
                                            <span class="fa-regular fa-trash-can rounded px-1 py-0 btn text-danger" data-bs-toggle="modal" data-toggle="tooltip" data-bs-target="#deleteRoom" data-placement="top" title="Delete" style="cursor: pointer" data-room-id="{{$room->id}}"></span>
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
    {{-- start- add room modal--}}
    <div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Add Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
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

    {{-- end add room modal --}}
    {{-- start update room modal --}}
    <div class="modal fade" id="updateRoom" tabindex="-1" role="dialog" aria-labelledby="update room" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Update Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form action="" method="post" id="updateRoomForm">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body card-block">
                            <div class="row">
                                <div class="col">
                                    <label for="updateRoomNumber" class="form-label">Room #</label>
                                    <input type="text" id="updateRoomNumber" name="room_number" class="form-control mb-3">
                                </div>
                                <div class="col">
                                    <label for="updateRoomCapacity" class="form-label">Capacity</label>
                                    <input type="number" id="updateRoomCapacity" name="capacity" class="form-control mb-3">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="updateType" class="form-label">Type</label>
                                    <select id="updateType" name="type" data-placeholder="Choose a type..." class="form-control form-select mb-3" tabindex="1">
                                        <option value=""></option>
                                        <option value="Lecture">Lecture</option>
                                        <option value="Laboratory">Laboratory</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="updateAvailability" class="form-label">Type</label>
                                    <select id="updateAvailability" name="availability" data-placeholder="Choose a type..." class="form-control form-select mb-3" tabindex="1">
                                        <option value=1>Available</option>
                                        <option value=0>Not Available</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end update room modal --}}
    {{-- start delete room modal --}}
    <div class="modal fade" id="deleteRoom" tabindex="-1" role="dialog" aria-labelledby="update room" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Delete Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form action="" method="post" id="deleteRoomForm">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body card-block text-danger">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end delete room modal --}}
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('.fa-pen-to-square').on('click', function() {
                const trElement = $(this).closest('tr');

                // Find the <td> elements within the <tr> and get their values
                const roomNumber = trElement.find('td:eq(0)').text().trim();
                const roomType = trElement.find('td:eq(1)').text().trim();
                const roomCapacity = trElement.find('td:eq(2)').text().trim();
                const roomAvailability = trElement.find('td:eq(3)').text().trim()=='Available' ? 1 : 0;
                const roomId = $(this).attr('data-room-id');

                // Now you have the values of the <td> elements
                $('#updateRoomNumber').val(roomNumber);
                $('#updateRoomCapacity').val(roomCapacity);
                $('#updateType').val(roomType);
                $('#updateAvailability').val(roomAvailability);

                const url = `{{ route('update-room', ':classroom') }}`.replace(':classroom', roomId);
                $('#updateRoomForm').attr('action', url);
            })
            $('.fa-trash-can').on('click', function(){
                const trElement = $(this).closest('tr');
                const roomNumber = trElement.find('td:eq(0)').text().trim();
                const roomId = $(this).attr('data-room-id');
                $('#deleteRoomForm .card-body').text(`Are you sure you want to delete Room ${roomNumber}?`);

                const url = `{{ route('delete-room', ':classroom') }}`.replace(':classroom', roomId);
                $('#deleteRoomForm').attr('action', url);
            });
        });
    </script>
    @if (Session::has('success'))
    <script>
        toastr.success('{{ Session::get('success') }}');
    </script>
    @endif
    @if (Session::has('deleted'))
    <script>
        toastr.warning('{{ Session::get('deleted') }}');
    </script>
    @endif
@endsection