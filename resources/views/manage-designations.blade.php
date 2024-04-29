@extends('layouts.layout')
@section('content')
    <div class="container-fluid">
        <div class="row animate__animated animate__fadeIn">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">LIST OF Designation</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered"
                            id="table"
                            data-toolbar="#toolbar"
                            data-toggle="table"
                            data-pagination="true"
                            data-pagination-h-align="left"
                            data-pagination-detail-h-align="right"
                            data-pagination-v-align="bottom"
                            data-search="true"
                            data-searchable="true">
                            <thead class="table-dark">
                                <tr>
                                    <th data-sortable="true">Designation</th>
                                    <th data-sortable="true">Units</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($designations as $designation)
                                    <tr data-designation-id="{{$designation->id}}" data-designation-name="{{$designation->designation}}" data-unique="{{$designation->unique}}">
                                        <td>{{$designation->designation}}</td>
                                        <td>{{$designation->units}}</td>
                                        <td class="text-center">
                                            <span class="fa-solid fa-pen-to-square px-1 py-0 text-success rounded btn" data-bs-toggle="modal" data-toggle="tooltip" data-bs-target="#updateDesignation" data-placement="top" title="Edit"  style="cursor: pointer"></span>
                                            <span class="fa-regular fa-trash-can rounded px-1 py-0 btn text-danger" data-bs-toggle="modal" data-toggle="tooltip" data-bs-target="#deleteDesignation" data-placement="top" title="Delete" style="cursor: pointer"></span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-bg-warning">
                        <strong class="card-title">Create Designation</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{route('add-designation')}}" method="post" id="addDesignation">
                            @csrf
                            <div class="mb-3">
                                <label for="designation" class="form-label">Designation/Title</label>
                                <input type="text" id="designation" name="designation" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="units" class="form-label">Units</label>
                                <input type="number" id="units" name="units" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-select" id="type" aria-label="Designation type" name="unique">
                                    <option selected>Select Type</option>
                                    <option value="1">Designation</option>
                                    <option value="0">Mandatory Deloading</option>
                                </select>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="Submit"><i class="fa-solid fa-circle-plus"></i> Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- start update designation modal --}}
    <div class="modal fade" id="updateDesignation" tabindex="-1" role="dialog" aria-labelledby="update designation" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Update Designation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form action="" method="post" id="updateDesignationForm">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body card-block">
                            <div class="row">
                                <div class="col">
                                    <label for="updateTitle" class="form-label">Designation/Title</label>
                                    <input type="text" id="updateTitle" name="designation" class="form-control mb-3">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="updateUnits" class="form-label">Units</label>
                                    <input type="number" id="updateUnits" name="units" class="form-control mb-3">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="updateType" class="form-label">Type</label>
                                    <select class="form-select" id="updateType" aria-label="Designation type" name="unique">
                                        <option value="1">Designation</option>
                                        <option value="0">Mandatory Deloading</option>
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
    {{-- end update designation modal --}}
    {{-- start delete room modal --}}
    <div class="modal fade" id="deleteDesignation" tabindex="-1" role="dialog" aria-labelledby="update room" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Delete Designation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form action="" method="post" id="deleteDesignationForm">
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
        $(document).ready(function() {
            $('#table').on('click', '.fa-trash-can', function(e) {
                let designationId = $(this).closest('tr').data('designation-id');
                let designationName = $(this).closest('tr').data('designation-name');
                let url = '{{ route("delete-designation", ":id") }}';
                url = url.replace(':id', designationId);
                $('#deleteDesignationForm').attr('action', url);
                $('#deleteDesignationForm .card-body').html(`Are you sure you want to delete <strong>${designationName}</strong> designation?`);
            });
            $('#table').on('click', '.fa-pen-to-square', function(e) {
                let tr = $(this).closest('tr');
                let designationId = tr.data('designation-id');
                let designationName = tr.data('designation-name');
                let unique = tr.data('unique');
                $('#updateTitle').val(designationName);
                $('#updateUnits').val( parseFloat(tr.find('td:eq(1)').text().trim()).toFixed(0));
                $('#updateType').val(unique);
                let url = '{{ route("update-designation", ":id") }}';
                url = url.replace(':id', designationId);
                $('#updateDesignationForm').attr('action', url);
                $('#updateDesignationForm #designation').val(designationName);
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