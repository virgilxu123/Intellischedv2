@extends('layouts.layout')
@section('content')
    <div class="container-fluid">
        <div class="row animate__animated animate__bounceInRight">
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
                                    <tr>
                                        <td>{{$designation->designation}}</td>
                                        <td>{{$designation->units}}</td>
                                        <td class="text-center">
                                            <span class="fa-solid fa-pen-to-square px-1 py-0 text-success rounded btn" data-toggle="modal" data-toggle="tooltip" data-target="#updateDesignation" data-placement="top" title="Edit"  style="cursor: pointer"></span>
                                            <span class="fa-regular fa-trash-can rounded px-1 py-0 btn text-danger" data-toggle="modal" data-toggle="tooltip" data-target="#deleteDesignation" data-placement="top" title="Delete" style="cursor: pointer"></span>
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
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" id="designation" name="designation" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="units" class="form-label">Units</label>
                                <input type="number" id="units" name="units" class="form-control">
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
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#addDesignation').submit(function(e) {
                e.preventDefault();
                let url = $(this).attr('action');
                let formData = new FormData(this);
                fetch(url, {
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
                    fetchDesignations();
                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                })
            })

            function fetchDesignations() {
                let url = '{{ route("manage-designations") }}';
                fetch(url, {
                    method: 'GET',
                    headers: {
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
                    displayDesignation(data);
                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                })
            }

            function displayDesignation(data){
                let table = document.getElementById("table");
                let existingDesignations = Array.from(table.querySelectorAll("tbody tr td:first-child")).map(td => td.textContent.trim());
                
                // Iterate over the fetched data
                data.forEach(designation => {
                    // Check if the designation already exists in the table
                    if (!existingDesignations.includes(designation.designation)) {
                        // Append a new row to the table
                        let newRow = table.insertRow();
                        let cell1 = newRow.insertCell(0);
                        let cell2 = newRow.insertCell(1);
                        let cell3 = newRow.insertCell(2);
                        cell1.textContent = designation.designation;
                        cell2.textContent = designation.units;
                        cell3.innerHTML = `<span class="fa-solid fa-pen-to-square px-1 py-0 text-success rounded btn" data-toggle="modal" data-toggle="tooltip" data-target="#updateDesignation" data-placement="top" title="Edit"  style="cursor: pointer"></span>
                        <span class="fa-regular fa-trash-can rounded px-1 py-0 btn text-danger" data-toggle="modal" data-toggle="tooltip" data-target="#deleteDesignation" data-placement="top" title="Delete" style="cursor: pointer"></span>`
                        cell3.style.textAlign = "center";
                    }
                });
                let toastEl = document.getElementById("liveToast");
                const toastInstance = bootstrap.Toast.getOrCreateInstance(toastEl)
                let toastBody = toastEl.querySelector('.toast-body');
                toastBody.textContent = `Saved: Designation added successfully!`;
                toastBody.classList.remove('text-bg-danger');
                toastBody.classList.add('text-bg-success');
                toastInstance.show();
            }
        });
    </script>
    @if (Session::has('success'))
        <script>
            toastr.success('{{ Session::get('success') }}');
        </script>
    @endif
@endsection