@extends('layouts.layout')

@section('links')
@endsection
@section('content')
    {{-- toast --}}
    <div class="toast-container top-0 start-50 translate-middle-x position-fixed">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    
    {{-- toast --}}
    <div class="container-fluid">
        <div class="row animate__animated animate__bounceInRight">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p class="d-inline align-middle"><strong class="card-title">LIST OF Subjects</strong></p>
                        <p class="d-inline align-middle float-end"><strong class="card-title">Manage Subjects</strong></p>
                    </div>
                    <div class="card-body">
                        <button id="toolbar" type="button" class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#addClassModal"><i class="fa-solid fa-circle-plus"></i> Add</button>
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
                            <thead class="">
                                <tr>
                                    <th data-sortable="true" data-field="course_code">Course Code</th>
                                    <th data-sortable="true" data-field="description">Description</th>
                                    <th data-sortable="true" data-field="units">Units</th>
                                    <th data-sortable="true" data-field="year_level">Year Level</th>
                                    <th data-sortable="true" data-field="term">Term</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjects as $subject)
                                    <tr data-subject_id="{{$subject->id}}">
                                        <td>{{$subject->course_code}}</td>
                                        <td>{{$subject->description}}</td>
                                        <td>{{$subject->units}}</td>
                                        <td>{{$subject->year_level}}</td>
                                        <td>{{ optional($subject->term)->term ?? '' }}</td>
                                        <td class="text-center">
                                            <span data-subject_id="{{$subject->id}}" class="fa-solid fa-pen-to-square p-1 text-success rounded btn" data-bs-toggle="modal" data-toggle="tooltip" data-bs-target="#editSubjectModal" data-placement="top" title="Edit"  style="cursor: pointer"></span>
                                            <span data-subject_id="{{$subject->id}}" class="fa-regular fa-trash-can rounded p-1 btn text-danger" data-bs-toggle="modal" data-toggle="tooltip" data-bs-target="#deleteSubject" data-placement="top" title="Delete" style="cursor: pointer"></span>
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
    <div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="#addClassModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="" method="post" id="addSubject">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addClassModalLabel">Add Subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12 mb-3">
                            <label class="form-label" for="code">Course Code</label>
                            <input type="text" name="course_code" class="form-control" id="code" >
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">   
                                <label class="form-label" for="description">Description</label>
                                <input type="text" name="description" class="form-control" id="description" >
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="units">Units</label>
                                <input type="number" name="units" class="form-control" id="units" >
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label class="form-label" for="year_level">Year</label>
                                <select id="year_level" name="year_level" data-placeholder="" class="form-select" tabindex="1">
                                    <option value=""></option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="term">Term</label>
                                <select id="term" name="term_id" data-placeholder="" class="form-select" tabindex="1">
                                    <option value=""></option>
                                    @foreach ($terms as $term)
                                        <option value="{{$term->id}}">{{$term->term}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label class="form-label" for="subject_type">Type</label>
                                <select id="subject_type" name="subject_type" data-placeholder="" class="form-select" tabindex="1">
                                    <option value=""></option>
                                    <option value="Minor">Minor</option>
                                    <option value="Major">Major</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="laboratory">Laboratory</label>
                                <select id="laboratory" name="laboratory" data-placeholder="" class="form-select" tabindex="1">
                                    <option value=""></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
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
    {{-- edn modal --}}
    {{-- update-modal --}}
    <div class="modal fade" id="editSubjectModal" tabindex="-1" role="dialog" aria-labelledby="#updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="" method="post" id='update'>
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12 mb-3">
                            <label class="form-label" for="code2">Course Code</label>
                            <input type="text" name="course_code" class="form-control" id="code2" placeholder="Course Code">
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">   
                                <label class="form-label" for="description2">Description</label>
                                <input type="text" name="description" class="form-control" id="description2" placeholder="Description">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="units2">Units</label>
                                <input type="number" name="units" class="form-control" id="units2" placeholder="Units">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="year_level2">Year</label>
                                <select id="year_level2" name="year_level" class="form-select" tabindex="1">
                                    <option value=""></option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="term2">Term</label>
                                <select id="term2" name="term_id" class="form-select" tabindex="1">
                                    <option value=""></option>
                                    @foreach ($terms as $term)
                                        <option value="{{$term->id}}">{{$term->term}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="subject_type2">Type</label>
                                <select id="subject_type2" name="subject_type" class="form-select" tabindex="1">
                                    <option value=""></option>
                                    <option value="Minor">Minor</option>
                                    <option value="Major">Major</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3    ">
                                <label class="form-label" for="laboratory2">Laboratory</label>
                                <select id="laboratory2" name="laboratory" class="form-select" tabindex="1">
                                    <option value=""></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- update-modal --}}
    {{-- Delete confirmation modal --}}
    <div class="modal fade" id="deleteSubject" tabindex="-1" role="dialog" aria-labelledby="#deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form action="" method="post" id="deleteSubjectForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="deleteModalLabel">Delete Subject!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body card-block">
                            <p id="deleteSubjectMessage" class="card-content"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
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
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('toolbar').addEventListener('click', (event) => {
                document.getElementById('addSubject').setAttribute('action', '{{route("add-subject")}}');
            });
            // Attach event listener to a parent element that exists when the page loads
            document.addEventListener('click', function (event) {
                if (event.target.classList.contains('fa-pen-to-square')||event.target.classList.contains('fa-trash-can')) {
                    let pencilTrash = event.target;
                    let subjectId = pencilTrash.getAttribute('data-subject_id');
                    // Make AJAX request to fetch subject details
                    fetch(`{{ route('show-subject', ':subjectId') }}`.replace(':subjectId', subjectId))
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json(); // Parse the JSON response
                        })
                        .then(data => {
                            // Populate the edit modal with fetched data
                            let editForm = document.querySelector('#editSubjectModal');
                            editForm.querySelector('[name="course_code"]').value = data.course_code;
                            editForm.querySelector('[name="description"]').value = data.description;
                            editForm.querySelector('[name="units"]').value = data.units;
                            editForm.querySelector('[name="year_level"]').value = data.year_level;
                            editForm.querySelector('[name="term_id"]').value = data.term_id;
                            editForm.querySelector('[name="laboratory"]').value = data.laboratory;
                            editForm.querySelector('[name="subject_type"]').value = data.subject_type;

                            document.getElementById('deleteSubjectMessage').textContent = `Are you sure you want to delete ${data.course_code} ${data.description}?`;

                            // Update action URL of the form
                            document.querySelector('#update').setAttribute('action', '{{ route("update-subject", ":subjectId") }}'.replace(':subjectId', subjectId));
                            document.querySelector('#deleteSubjectForm').setAttribute('action', '{{ route("delete-subject", ":subjectId") }}'.replace(':subjectId', subjectId));
                        })
                        .catch(error => {
                            console.error('There was a problem with the fetch operation:', error);
                        });
                }
            });
            // Function to make AJAX request and handle response
            function handleFormSubmission(formId, successCallback, actionType) {
                document.querySelector(formId).addEventListener('submit', function (event) {
                    event.preventDefault(); // Prevent the default form submission

                    // Get the form data
                    let formData = new FormData(this);

                    // Get the action URL from the form's action attribute
                    let actionUrl = this.getAttribute('action');
                    // Make an AJAX request
                    fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Add CSRF token header
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // Parse the JSON response
                    })
                    .then(data => {
                        // Call the success callback function with the response data
                        successCallback(data);
                        // Show toast message
                        let toastElement = document.getElementById('liveToast');
                        const toastInstance = bootstrap.Toast.getOrCreateInstance(toastElement)
                        let toastBody = toastElement.querySelector('.toast-body');
                        toastBody.textContent = actionType=="delete"?`Warning: ${data.message}`:`Success: ${data.message}`;
                        // let toastHeader = toastElement.querySelector('.toast-header');

                        if (actionType === 'update') {
                            toastElement.classList.remove('text-bg-danger');
                            toastElement.classList.add('text-bg-success');
                            const modalElement = document.querySelector('#editSubjectModal');
                            const modalInstance = bootstrap.Modal.getInstance(modalElement);
                            modalInstance.hide(); // Close the modal
                            // toastElement.querySelector('strong').textContent = 'Saved!';
                        } else if (actionType === 'delete') {
                            toastElement.classList.remove('text-bg-success');
                            toastElement.classList.add('text-bg-danger');
                            const modalElement = document.querySelector('#deleteSubject');
                            const modalInstance = bootstrap.Modal.getInstance(modalElement);
                            modalInstance.hide(); // Close the modal
                            // toastElement.querySelector('strong').textContent = 'Deleted!';
                        } else if (actionType == 'add') {
                            toastElement.classList.remove('text-bg-danger');
                            toastElement.classList.add('text-bg-success');
                            const modalElement = document.querySelector('#addClassModal');
                            const modalInstance = bootstrap.Modal.getInstance(modalElement);
                            modalInstance.hide(); // Close the modal
                            document.querySelector('#addClassModal form').reset();
                            // toastElement.querySelector('strong').textContent = 'Added!';
                        }
                        toastInstance.show();
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                        // Handle errors here (e.g., display an error message)
                    });
                });
            }

            // Call the function for update form
            handleFormSubmission('#update', function(data) {
                let tableRow = document.querySelector(`tr[data-subject_id="${data.updatedData.id}"]`);
                tableRow.querySelector('td:nth-child(1)').textContent = data.updatedData.course_code;
                tableRow.querySelector('td:nth-child(2)').textContent = data.updatedData.description;
                tableRow.querySelector('td:nth-child(3)').textContent = data.updatedData.units;
                tableRow.querySelector('td:nth-child(4)').textContent = data.updatedData.year_level;
                tableRow.querySelector('td:nth-child(5)').textContent = data.updatedData.term_name;
            }, 'update');

            // Call the function for delete form
            handleFormSubmission('#deleteSubjectForm', function(data) {
                let tableRow = document.querySelector(`tr[data-subject_id="${data.deletedData.id}"]`);
                tableRow.remove();
            }, 'delete');
            handleFormSubmission('#addSubject', function(data) {
                console.log(data);
                let tableBody = document.querySelector('table tbody');
                let newRow = tableBody.insertRow();
                newRow.innerHTML = `
                    <td>${data.subject.course_code}</td>
                    <td>${data.subject.description}</td>
                    <td>${data.subject.units}</td>
                    <td>${data.subject.year_level}</td>
                    <td>${data.subject.term.term}</td>
                    <td class="text-center">
                        <span data-subject_id="${data.subject.id}" class="fa-solid fa-pen-to-square p-1 text-success rounded btn" data-bs-toggle="modal" data-toggle="tooltip" data-bs-target="#editSubjectModal" data-placement="top" title="Edit"  style="cursor: pointer"></span>
                        <span data-subject_id="${data.subject.id}" class="fa-regular fa-trash-can rounded p-1 btn text-danger" data-bs-toggle="modal" data-toggle="tooltip" data-bs-target="#deleteSubject" data-placement="top" title="Delete" style="cursor: pointer"></span>
                    </td>
                `;
            }, 'add');
        });
    </script>
@endsection