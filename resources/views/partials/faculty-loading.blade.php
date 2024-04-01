<div class="col-4 animated fadeIn">
    <div class="card">
        <div class="card-header bg-dark text-light">
            <h5>Faculty Loading</h5>
        </div>
        <div class="card-body" style="max-height: 66vh; overflow-y: auto;">
            <table class="table table-bordered table-hover" 
                data-toggle="table"
                data-search="true"
                data-searchable="true">
                <thead class="bg-dark text-light">
                    <tr>
                        <th data-field="name" class="col-3">Name</th>
                        <th class="col-1">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($faculties as $faculty)
                    <tr class="faculty-row {{$loop->first ? 'selected-row' : ''}}" data-faculty-id="{{$faculty->id}}" data-faculty-name="{{ htmlspecialchars($faculty->first_name . ' ' . $faculty->last_name) }}">
                        <td class="col-11" style="cursor: pointer;"><a href="{{route('show-faculty', $faculty)}}">{{$faculty->first_name}} {{$faculty->last_name}}</a></td>
                        <td class="text-center col-1">
                            <button class="btn btn-primary rounded px-2 py-0 loadBtn" data-bs-toggle="modal" data-bs-target="#loadSubject" data-toggle="tooltip" title="Add/Edit Load" data-faculty-id="{{$faculty->id}}" data-faculty-first-name="{{$faculty->first_name}}" data-faculty-last-name="{{$faculty->last_name}}"><i class="fa fa-edit"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-8">
    <div class="card">
        <div class="card-header text-bg-info">
            <h5 class="m-0"><i class="fa-regular fa-calendar-days"></i> Faculty Load Overview</h5>
        </div>
        <div class="card-body">
            @if($faculties->isNotEmpty())
                @php
                    $firstFaculty = $faculties->first();
                    $faculty = $firstFaculty->id;
                    $classSchedulesForFirstFaculty = $classSchedules->where('faculty_id', $faculty);
                @endphp
                <div class="d-flex justify-content-between">
                    <p class="d-inline">Name: <strong><span id="facultyName">{{$firstFaculty->first_name}} {{$firstFaculty->last_name}}</span></strong></p>
                    <div class="d-inline">
                        <form action="" method="Post" target="__blank" class="d-inline" id="viewPDF">
                            @csrf
                            <button class="btn btn-light btn-sm py-0 px-1" data-toggle="tooltip" data-placement="top" title="View PDF"><i class="fa-regular fa-file-pdf"></i></button>
                        </form>
                        <form action="" method="Post" target="__blank" class="d-inline">
                            @csrf
                            <button class="btn btn-light btn-sm py-0 px-1" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fa-solid fa-download"></i></button>
                        </form>
                    </div>
                </div>
                <p class="m-0">Total No. of Units: <strong id="totalUnits"></strong></p>
                <hr>
                <table class="table table-bordered table-sm" data-toggle="table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Schedule</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="class-schedule-body">
                        <!-- Table content for faculty schedules -->
                    </tbody>
                </table>
            @else
                <p>No faculty records found.</p>
                <hr>
                <table class="table table-bordered table-sm" data-toggle="table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Schedule</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="class-schedule-body">
                        <!-- Table content for faculty schedules -->
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    
    <div class="card">
        <div class="card-header text-bg-warning">
            Designation
        </div>
        <div class="card-body">
            <form action="" method="POST" id="assignDesignationForm">
                @csrf
                <select name="designation_id" class="form-select form-select-sm w-50 d-inline" aria-label=".form-select-sm example">
                    <option selected>Select Designation</option>
                </select>
                <button type="submit" class="d-inline btn btn-success btn-sm"><i class="fa-solid fa-circle-plus"></i> Assign</button>
            </form>
            <table 
                id="designationTable"
                data-toggle="table" 
                class="table table-bordered mt-3 table-sm">
                <thead>
                    <tr>
                        <th>Designation</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="designation-body">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
