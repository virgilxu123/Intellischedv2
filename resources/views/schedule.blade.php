@extends('layouts.layout')
@section('content')
    {{-- toast --}}
    <div class="toast-container top-0 start-50 translate-middle-x">
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
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Created Schedules</strong>
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
                                    <th data-field="acadYear" data-sortable="true">Academic Year</th>
                                    <th data-field="term" data-sortable="true">Term</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($academicYearTerms as $academicYearTerm)
                                    <tr>
                                        <td>{{$academicYearTerm->academic_year->year_start}}-{{$academicYearTerm->academic_year->year_start + 1}}</td>
                                        <td><a href="{{route('create-schedule', $academicYearTerm->id)}}"><em>{{ $academicYearTerm->term->term }}</em></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header text-bg-warning">
                        <strong class="card-title">Create New Schedule</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{route('create-academic-year-term')}}" method="POST" id="addAcademicYearTerm">
                            @csrf
                            <div class="mb-3">
                                <label for="year" class=" form-label">Academic Year</label>
                                <select name="year" id="year" class="form-select">
                                    @foreach ($academicYears as $academicYear)
                                        <option value="{{$academicYear}}">{{$academicYear}}-{{$academicYear + 1}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="term" class=" form-label">Term</label>
                                <select name="term_id" id="term" class="form-select">
                                    <option value="0">Please select</option>
                                    @foreach ($terms as $term)
                                        <option value="{{ $term->id }}">{{ $term->term }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success"><i class="fa fa-folder-open"></i> Create New</button>
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
            $('#addAcademicYearTerm').submit(function(e) {
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
                }).then(response => response.json())
                .then(data => {
                    let toastElement = document.getElementById('liveToast');
                    const toastInstance = bootstrap.Toast.getOrCreateInstance(toastElement)
                    let toastBody = toastElement.querySelector('.toast-body');
                    toastBody.classList.remove('text-bg-danger');
                    toastBody.classList.add('text-bg-success');
                    toastBody.innerHTML = data.success;
                    let route = `{{route('create-schedule', ':id')}}`.replace(':id', data.academicYearTerm.id);
                    if ($('#table tbody tr').hasClass('no-records-found')) {
                        $('#table tbody').empty();
                    }
                    let row = ` <tr>
                                    <td>${data.academicYearTerm.academic_year.year_start}-${parseInt(data.academicYearTerm.academic_year.year_start) + 1}</td>
                                    <td><a href="${route}"><em>${data.academicYearTerm.term.term}</em></a></td>
                                </tr>`;
                    $('#table tbody').prepend(row); 
                    toastInstance.show();
                }).catch(error => {
                    let toastElement = document.getElementById('liveToast');
                    const toastInstance = bootstrap.Toast.getOrCreateInstance(toastElement)
                    let toastBody = toastElement.querySelector('.toast-body');
                    toastBody.classList.remove('text-bg-success');
                    toastBody.classList.add('text-bg-warning');
                    toastBody.innerHTML = 'Schedule already exist';
                    toastInstance.show();
                });
            });
        });
    </script>
@endsection