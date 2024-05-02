@extends('layouts.layout')
@section('content')
    <div class="container-fluid">
        <div class="row animate__animated animate__fadeIn">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">LIST OF Signatories</strong>
                    </div>
                    <div class="card-body">
                        <table
                            class="table table-striped table-bordered"
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
                                    <th data-sortable="true">Name</th>
                                    <th data-sortable="true">Position</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($signatories as $signatory)
                                    <tr data-signatory-id="{{$signatory->id}}" data-first-name="{{$signatory->first_name}}" data-last-name="{{$signatory->last_name}}" data-middle-initial="{{$signatory->middle_initial}}" data-educ-qualification="{{$signatory->educ_qualification}}" data-position="{{$signatory->position}}">
                                        <td>{{$signatory->first_name}} {{$signatory->middle_initial}}. {{$signatory->last_name}}</td>
                                        <td>{{$signatory->position}}</td>
                                        <td class="text-center">
                                            <span class="fa-solid fa-pen-to-square px-1 py-0 text-success rounded btn" data-bs-toggle="modal" data-toggle="tooltip" data-bs-target="#updateSignatory" data-placement="top" title="Edit"  style="cursor: pointer"></span>
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
                        <strong class="card-title">Add Signatories</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{route('add-signatory')}}" method="post" id="addDesignation">
                            @csrf
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="middle_initial" class="form-label">Middle Initial</label>
                                <input type="text" id="middle_initial" name="middle_initial" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="educ_qualification" class="form-label">Educational Qualification</label>
                                <input type="text" id="educ_qualification" name="educ_qualification" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="position" class="form-label">Position</label>
                                <input type="text" id="position" name="position" class="form-control" required>
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
    <div class="modal fade" id="updateSignatory" tabindex="-1" role="dialog" aria-labelledby="update designation" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Update Signatory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form action="" method="post" id="updateSignatoryForm">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body card-block">
                            <div class="row">
                                <div class="col">
                                    <label for="updateFirstName" class="form-label">First Name</label>
                                    <input type="text" id="updateFirstName" name="first_name" class="form-control mb-3">
                                </div>
                                <div class="col">
                                    <label for="updateMiddleInitial" class="form-label">Middle Initial</label>
                                    <input type="text" id="updateMiddleInitial" name="middle_initial" class="form-control mb-3">
                                </div>
                                <div class="col">
                                    <label for="updateLastName" class="form-label">Last Name</label>
                                    <input type="text" id="updateLastName" name="last_name" class="form-control mb-3">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="updateEducQualification" class="form-label">Educational Qualification</label>
                                    <input type="text" id="updateEducQualification" name="educ_qualification" class="form-control mb-3">
                                </div>
                                <div class="col">
                                    <label for="updatePosition" class="form-label">Position</label>
                                    <input type="text" id="updatePosition" name="position" class="form-control mb-3">
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
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#table tbody').on('click', '.fa-pen-to-square', function(e) {

                var tr = $(this).closest('tr');
                var id = tr.data('signatory-id');
                var firstName = tr.data('first-name');
                var lastName = tr.data('last-name');
                var middleInitial = tr.data('middle-initial');
                var educQualification = tr.data('educ-qualification');
                var position = tr.data('position');

                $('#updateSignatoryForm').attr('action', '/update-signatory/' + id);
                $('#updateFirstName').val(firstName);
                $('#updateMiddleInitial').val(middleInitial);
                $('#updateLastName').val(lastName);
                $('#updateEducQualification').val(educQualification);
                $('#updatePosition').val(position);
            });
        });
    </script>
@endsection