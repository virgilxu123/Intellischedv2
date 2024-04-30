@extends('layouts.layout')

@section('content')
    <div class="container-fluid">
        <div class="row animate__animated animate__fadeIn">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="d-inline align-middle"><strong class="card-title">LIST OF Faculty Members</strong></p>
                        <p class="d-inline align-middle float-end"><strong class="card-title">Manage Faculty Members</strong></p>
                    </div>
                    <div class="card-body">
                        <button id="toolbar" type="button" class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#addFacultyModal"><i class="fa-solid fa-circle-plus"></i> Add</button>
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
                            <thead>
                                <th data-sortable="true" data-field="name">Name</th>
                                <th data-sortable="true" data-field="rank">Rank</th>
                                <th data-sortable="true" data-field="status">Status</th>
                                <th data-sortable="true" data-field="availability">Availability</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($faculties as $faculty)
                                    <tr data-facultyId="{{$faculty->id}}" data-fname="{{$faculty->first_name}}" data-lname="{{$faculty->last_name}}" data-mi="{{$faculty->middle_initial}}" data-status="{{$faculty->status}}" data-rank="{{$faculty->rank}}" data-years-in-service="{{$faculty->years_in_service}}" data-eligibility="{{$faculty->eligibility}}" data-educ-qualification="{{$faculty->educ_qualification}}">
                                        <td>{{$faculty->first_name}} {{$faculty->middle_initial}}. {{$faculty->last_name}}</td>
                                        <td>{{$faculty->rank}}</td>
                                        <td>{{$faculty->status}}</td>
                                        <td><span class="badge {{$faculty->availability == 1 ? 'text-bg-success' : 'text-bg-danger'}}">{{$faculty->availability==1?"Available":"Unavailable"}}</span></td>
                                        <td class="text-center">
                                            <span class="fa-solid fa-pen-to-square px-1 py-0 text-success rounded btn" data-bs-toggle="modal" data-toggle="tooltip" data-bs-target="#updateFacultyModal" data-placement="top" title="Edit" data-facultyId="{{$faculty->id}}"></span>
                                            <span class="fa-regular fa-trash-can rounded px-1 py-0 btn text-danger" data-bs-toggle="modal" data-toggle="tooltip" data-bs-target="#deleteFaculty" data-placement="top" title="Delete" data-facultyId="{{$faculty->id}}"></span>
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
    {{-- Add Faculty Modal --}}
    <div class="modal fade" id="addFacultyModal" tabindex="-1" role="dialog" aria-labelledby="addFaculty" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{route('add-faculty')}}" method="post" id="addFacultyForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addFaculty">Add Faculty</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-lg-5">
                                <label class="form-label" for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-lg-2">
                                <label class="form-label" for="middle_initial">M.I.</label>
                                <input type="text" id="middle_initial" name="middle_initial" class="form-control">
                            </div>
                            <div class="col-lg-5">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="rank">Rank</label>
                                <select id="rank" name="rank" data-placeholder="" class="form-control form-select" tabindex="1" required>
                                    <option value=""></option>
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
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="status">Status</label>
                                <select id="status" name="status" data-placeholder="" class="form-control form-select" tabindex="1" required>
                                    <option value=""></option>
                                    <option value="Regular">Regular</option>
                                    <option value="Contractual">Contractual</option>
                                    <option value="Part time">Part time</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label" for="years_in_service">Years in Service</label>
                                <input type="number" id="years_in_service" name="years_in_service" class="form-control">
                            </div>
                            <div class="col-4">
                                <label class="form-label" for="eligibility">Eligibility</label>
                                <input type="text" id="eligibility" name="eligibility" class="form-control">
                            </div>
                            <div class="col-4">
                                <label class="form-label" for="educ_qualification">Educational Qualification</label>
                                <input type="text" id="educ_qualification" name="educ_qualification" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Add Faculty Modal --}}
    {{-- update faculty --}}
    <div class="modal fade" id="updateFacultyModal" tabindex="-1" role="dialog" aria-labelledby="updateFaculty" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="" method="post" id="updateFacultyForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateFaculty">Update Faculty</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body card-block">
                            <div class="row mb-3">
                                <div class="col-lg-5">
                                    <label class="form-label" for="update_first_name">First Name</label>
                                    <input type="text" id="update_first_name" name="first_name" class="form-control">
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-label" for="update_middle_initial">M.I.</label>
                                    <input type="text" id="update_middle_initial" name="middle_initial" class="form-control">
                                </div>
                                <div class="col-lg-5">
                                    <label class="form-label" for="update_last_name">Last Name</label>
                                    <input type="text" id="update_last_name" name="last_name" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <label class="form-label" for="update_status">Status</label>
                                    <select id="update_status" name="status" data-placeholder="" class="form-control form-select" tabindex="1">
                                        <option value=""></option>
                                        <option value="Regular">Regular</option>
                                        <option value="Contractual">Contractual</option>
                                        <option value="Part time">Part time</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label" for="update_availability">Availability</label>
                                    <select id="update_availability" name="availability" data-placeholder="" class="form-control form-select" tabindex="1">
                                        <option value="1">Available</option>
                                        <option value="0">Not Available</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <label class="form-label" for="update_rank">Rank</label>
                                    <select id="update_rank" name="rank" data-placeholder="" class="form-control form-select" tabindex="1">
                                        <option value=""></option>
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
                                <div class="col-lg-6">
                                    <label class="form-label" for="update_years_in_service">Years in Service</label>
                                    <input type="number" id="update_years_in_service" name="years_in_service" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="form-label" for="update_eligibility">Eligibility</label>
                                    <input type="text" id="update_eligibility" name="eligibility" class="form-control">
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label" for="update_educ_qualification">Educational Qualification</label>
                                    <input type="text" id="update_educ_qualification" name="educ_qualification" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark rounded" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>   
    {{-- update faculty --}}
    {{-- Delete confirmation modal --}}
    <div class="modal fade" id="deleteFaculty" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form action="" method="post" id="deleteFacultyForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Delete Faculty!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body card-block">
                            <p id="deleteFacultyMessage" class="card-content"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark rounded" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger rounded">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Delete confirmation modal --}}

@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#table tbody').on('click', '.fa-pen-to-square', function() {

                if ($(event.target).hasClass('fa-pen-to-square') || $(event.target).hasClass('fa-trash-can')) {
                    let facultyId = $(this).closest('tr').attr('data-facultyId');
                    if ($(event.target).hasClass('fa-pen-to-square')) {
                        let updateFacultyForm = document.getElementById('updateFacultyForm');
                        updateFacultyForm.action = `{{ route('update-faculty', ':facultyId') }}`.replace(':facultyId', facultyId);
                        $('#update_first_name').val($(this).closest('tr').attr('data-fname'));
                        $('#update_middle_initial').val($(this).closest('tr').attr('data-mi'));
                        $('#update_last_name').val($(this).closest('tr').attr('data-lname'));
                        $('#update_status').val($(this).closest('tr').attr('data-status'));
                        $('#update_rank').val($(this).closest('tr').attr('data-rank'));
                        $('#update_years_in_service').val($(this).closest('tr').attr('data-years-in-service'));
                        $('#update_eligibility').val($(this).closest('tr').attr('data-eligibility'));
                        $('#update_educ_qualification').val($(this).closest('tr').attr('data-educ-qualification'));
                    } else {
                        let deleteFacultyForm = document.getElementById('deleteFacultyForm');
                        deleteFacultyForm.action = `{{ route('delete-faculty', ':facultyId') }}`.replace(':facultyId', facultyId);
                        let deleteFacultyMessage = document.getElementById('deleteFacultyMessage');
                        deleteFacultyMessage.textContent = `Are you sure you want to delete ${data.faculty.first_name} ${data.faculty.last_name} from the record?`;
                    }
                }
            });
            
            function handleFormSubmission(formId, successCallback, actionType) {
                document.getElementById(formId).addEventListener('submit', function(event){
                    event.preventDefault();
                    let formData = new FormData(this);
                    let url = this.getAttribute('action');
                    fetch(url, {
                        method: 'POST', // Use the appropriate HTTP method
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest', // Set the X-Requested-With header
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Set the CSRF token header
                        },
                        body: formData // Set the body as a form data object
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json(); // Parse the JSON response
                        })
                        .then(data => {
                            successCallback(data);

                            if (actionType === 'update') {
                                toastr.success(data.message);
                                const modalElement = document.querySelector('#updateFacultyModal');
                                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                                modalInstance.hide(); // Close the modal
                            } else if (actionType === 'delete') {
                                toastr.warning(data.message);
                                const modalElement = document.querySelector('#deleteFaculty');
                                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                                modalInstance.hide(); // Close the modal
                            }
                        })
                        .catch(error => {
                            console.error('There has been a problem with your fetch operation:', error);
                        });
                });
            }
            handleFormSubmission('updateFacultyForm', function(data) {
                let tableRow = document.querySelector(`tr[data-facultyId="${data.updatedData.id}"]`);
                let facultyId = data.updatedData.id;
                console.log(data.updatedData.availability);
                tableRow.querySelector('td:nth-child(1)').innerHTML = `<a href="{{ route('show-faculty', ':facultyId') }}">${ data.updatedData.first_name} ${ data.updatedData.middle_initial}. ${ data.updatedData.last_name }</a>`.replace(':facultyId', facultyId);
                tableRow.querySelector('td:nth-child(2)').textContent = data.updatedData.rank;
                tableRow.querySelector('td:nth-child(3)').textContent = data.updatedData.status;
                tableRow.querySelector('td:nth-child(4)').innerHTML = `<span class="badge ${data.updatedData.availability == 1 ? 'text-bg-success' : 'text-bg-danger'}">${data.updatedData.availability == 1 ? 'Available' : 'Unavailable'}</span>`;
            }, 'update');
            handleFormSubmission('deleteFacultyForm', function(data) {
                let tableRow = document.querySelector(`tr[data-facultyId="${data.deletedData.id}"]`);
                tableRow.remove();
            }, 'delete');
        });  
    </script>
    @if (Session::has('success'))
        <script>
            toastr.success('{{ Session::get('success') }}');
        </script>
    @endif
@endsection