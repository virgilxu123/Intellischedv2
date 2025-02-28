@extends('layouts.layout')
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
    <div class="container-fluid mt-3 animate__animated animate__bounceInRight">
        <div class="">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="mx-autod-block">
                                <div class="row justify-content-md-center">
                                    <img class="rounded-circle col-lg-9" src="{{asset('admin-assets/image/no-image-icon.png')}}" alt="Profile Pic">
                                </div>
                                <h5 class="text-sm-center mt-2 mb-1">{{$faculty->first_name}} {{$faculty->last_name}}</h5>
                                <div class="location text-sm-center">{{$faculty->rank}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header text-bg-info">
                            <strong class="card-title">Personal Details</strong>
                        </div>
                        
                            <div class="card-body card-block">
                                <form action="{{route('update-faculty',['faculty'=>$faculty->id])}}" method="post" id="updateFacultyForm">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="form-group col-lg-6">
                                            <label for="name" class=" form-label">First Name</label>
                                            <input type="text" id="name" name="first_name" value="{{$faculty->first_name}}" class="form-control">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name" class=" form-label">Last Name</label>
                                            <input type="text" id="name" name="last_name" value="{{$faculty->last_name}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group col-lg-6">
                                            <label for="rank" class=" form-label">Rank</label>
                                            <select name="rank" data-placeholder="sdfasfsa" class="form-control form-select" tabindex="1">
                                                <option value="{{$faculty->rank}}">{{$faculty->rank}}</option>
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
                                                <option value="University Professor">University Professor</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="nf-password" class=" form-label">Status</label>
                                            <select name="status" data-placeholder="" class="form-control form-select" tabindex="1">
                                                <option value="Regular" {{$faculty->status == 'Regular' ? 'selected' : ''}}>Regular</option>
                                                <option value="Contractual" {{$faculty->status == 'Contractual' ? 'selected' : ''}}>Contractual</option>
                                                <option value="Part time" {{$faculty->status == 'Part time' ? 'selected' : ''}}>Part time</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-group col-lg-6">
                                            <label for="workload" class=" form-label">Units</label>
                                            <input type="text" id="workload" name="workload" disabled value="{{!$totalLoad?"":$totalLoad}}" class="form-control">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="designation" class=" form-label">Designation</label>
                                            <input class="form-control" type="text" id="designation" name="designation" disabled value="@if (isset($designations) && $designations->count() > 0)@foreach ($designations as $designation){{$designation->designation }}{{ !$loop->last ? ', ' : '' }}@endforeach @else None @endif">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded float-right">Update</button>
                                </form>
                            </div>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-bg-success">
                            <strong class="card-title">Work Load</strong>
                        </div>
                        <div class="card-body">
                            <div class="toolbar">
                                <form action="@if ($academicYearTerm)
                                {{route('view-pdf',['faculty' => $faculty->id, 'academicYearTerm'=>$academicYearTerm->id])}}"@endif method="Post" target="__blank" class="d-inline">
                                
                                    @csrf
                                    <button class="btn btn-light btn-sm py-0 px-1" datatoggle="tooltip" data-placement="top" title="View PDF"><i class="fa-regular fa-file-pdf"></i></button>
                                </form>
                                <form action="" method="Post" target="__blank" class="d-inline">
                                    @csrf
                                    <button class="btn btn-light btn-sm py-0 px-1" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fa-solid fa-download"></i></button>
                                </form>
                                <a href=@if ($academicYearTerm)"{{route('create-schedule', ['academic_year_term'=>$academicYearTerm->id])}}"@endif style="font-size: small">&nbsp;&nbsp;Faculty loading >></a>
                            </div>
                            <table 
                                id="table" 
                                data-toggle="table" 
                                data-search="true"
                                data-toolbar=".toolbar"
                                class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th data-field="day" data-sortable="true" scope="col">Day</th>
                                        <th data-field="time" data-sortable="true" scope="col">Time</th>
                                        <th data-field="code" data-sortable="true" scope="col">Code</th>
                                        <th data-field="desc" data-sortable="true" scope="col">Description</th>
                                        <th data-field="units" data-sortable="true" scope="col">Units</th>
                                        <th data-field="room" data-sortable="true" scope="col">Room</th>
                                        <th data-field="stud" data-sortable="true" scope="col">Students</th>
                                        <th data-field="type" data-sortable="true" scope="col">Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classes as $class)
                                        @php
                                            if($class->time_start){
                                                $day = $class->days[0]->day == "Monday" ? "MTh" : ($class->days[0]->day == "Wednesday" ? "W" : "TF");
                                                $schedule = $day." ".$class->time_start."-".$class->time_end;
                                                $room = $class->classroom->room_number;
                                            }else {
                                                $schedule = "TBD";
                                                $room = "TBD";
                                            }
                                        @endphp
                                        <tr data-class-id="{{$class->id}}">
                                            <form action="" method="POST">
                                                <td class="col-1">
                                                    @if ($class->units == '3')
                                                        {{ count($class->days) > 0 ? $class->days[0]->day : 'TBD' }}
                                                    @else
                                                        <div class="d-flex align-items-center">
                                                            @csrf
                                                            <select name="day_id" id="day" class="form-select w-auto">
                                                                <option value="">Select Day</option>
                                                                @foreach ($days as $day)
                                                                <option value="{{ $day->id }}" {{ isset($class->days[0]) && $class->days[0]->id == $day->id ? 'selected' : '' }}>
                                                                    {{ $day->day }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="col-1">
                                                @if ($class->units == '3')
                                                    {{$class->time_start ."-". $class->time_end}}
                                                @else
                                                    @php
                                                        $mthtfTime = ['7:30AM','9:00AM','10:30AM','1:00PM','2:30PM','4:00PM','5:30PM', '7:00PM'];
                                                    @endphp
                                                    <select name="time_start" id="time" class="form-select w-auto time-select" data-classId="{{$class->id}}" data-day="{{ count($class->days) > 0 ? $class->days[0]->day : 'N/A' }}">
                                                        <option value="">Select Time</option>
                                                        @foreach ($mthtfTime as $time)
                                                        @php
                                                            // Convert time to DateTime and add 90 minutes
                                                            $originalTime = DateTime::createFromFormat('g:iA', $time);
                                                            $endTime = (clone $originalTime)->modify('+90 minutes');
                                                        @endphp
                                                             <option value="{{ $time }}" {{ $class->time_start == $time ? 'selected' : '' }}>
                                                                {{ $time }} - {{ $endTime->format('g:iA') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </form>
                                            </td>
                                            <td class="col-1">{{$class->subject->course_code}}-{{$class->block->block}}</td>
                                            <td class="col-3">{{$class->subject->description}} <em>({{$class->class_type=='lecture'?'Lec.':'Lab.'}})</em></td>
                                            <td class="col-1">{{$class->units}}</td>
                                            <td class="col-1">
                                                @if ($class->units == '3')
                                                    {{$room}}
                                                @else
                                                    <form action="" method="POST">
                                                        @csrf
                                                        <select class="form-select room-select w-auto room-select" id="room" name="room_id">
                                                            <option value="">Select Room</option>
                                                            @foreach ($rooms as $room)
                                                            <option value="{{ $room->id }}" {{ isset($class->classroom) && $class->classroom->id == $room->id ? 'selected' : '' }}>
                                                                {{ $room->room_number }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </form>
                                                @endif
                                            </td>
                                            <td class="col-1">
                                                <form action="{{route('update-student-count', ['classSchedule'=>$class->id])}}" method="POST" id="studentCountForm">
                                                    @csrf
                                                    <input data-class-id={{$class->id}} type="number" name="student_count" class="form-control form-control-sm studentCount" value="{{$class->student_count}}" {{$class->units==1.25?"disabled":""}}>
                                                </form>
                                            </td>
                                            <td class="col-2">
                                                <form action="{{route('update-load-type', ['classSchedule'=>$class->id])}}" method="POST">
                                                    @csrf
                                                    <select class="form-select form-select-sm loadTypeSelect" aria-label="Load Type">
                                                        <option value="{{ $class->load_type ? $class->load_type->id : '' }}">
                                                            {{ $class->load_type ? $class->load_type->load_type : 'Load Type' }}
                                                        </option>
                                                        @foreach ($loadTypes as $loadType)
                                                            @if (!$class->load_type || $class->load_type->id !== $loadType->id)
                                                                <option value="{{ $loadType->id }}">{{ $loadType->load_type }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-bg-warning">
                            <div class="row">
                                <div class="col-3">Regular load: <span id="regularLoad">{{$regularLoad}}</span></div>
                                <div class="col-3">Overload: <span id="overLoad">{{$overLoad}}</span></div>
                                <div class="col-3">Emergency Load: <span id="emergencyLoad">{{$emergencyLoad}}</span></div>
                                <div class="col-3">Praise Load: <span id="praiseLoad">{{$praiseLoad}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/libs/jsPDF/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/extensions/export/bootstrap-table-export.min.js"></script>  
    <script>
        faculty = @json($faculty);
        $(document).ready(function() {
            // let tableBody = document.querySelector("#table tbody");
            // if (tableBody) {
            //     tableBody.addEventListener("change", function (event) {
            //         let target = event.target;
            //         if (target.classList.contains("time-select") || target.classList.contains("room-select")) {
            //             let row = target.closest("tr"); // Get the parent row of the changed dropdown
            //             let roomSelect = row.querySelector(".room-select"); // Find the day dropdown in the same row
            //             let timeSelect = row.querySelector(".time-select"); // Find the time dropdown in the same row

            //             let selectedRoom = roomSelect.value;
            //             let selectedTime = timeSelect.value;
            //             let classId = timeSelect.dataset.classid;
            //             let day = timeSelect.dataset.day;
            //             console.log(day);
            //             if (selectedRoom && selectedTime) {
            //                 console.log(classId, selectedRoom, selectedTime, day, row);
            //             }
            //         }
            //     });
            // } else {
            //     console.warn("⚠️ Table body #facultyLoadTable tbody not found!");
            // }
            let initialStudCount;
            $('#updateFacultyForm').on('submit', function(e) {
                e.preventDefault();
            })
            let prevValue;
            $(document).on('focus', '.loadTypeSelect', function() {
                prevValue = $(this).val();
            });
            
            $(document).on('change', '.loadTypeSelect',function(e){
                let thisSelect = $(this);
                let form = $(this).closest('form');
                let url = form.attr('action');
                let selectedValue = $(this).val();
                let formData = new FormData(form[0]);
                formData.append('load_type', selectedValue);
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json(); // Parse the JSON response
                })
                .then(data => {
                    $('#regularLoad').text(data.regularLoad);
                    $('#overLoad').text(data.overLoad);
                    $('#emergencyLoad').text(data.emergencyLoad);
                    $('#praiseLoad').text(data.praiseLoad);
                    if(data.message){
                        toastr.success(data.message);
                    }else {
                        toastr.error(data.error);
                        thisSelect.val(prevValue);
                    }
                })
                .catch(error => {
                    toastr.error('An Error has occurred');

                });
            });
            //fetch when focus is lost        
            $('.studentCount').on('focusout', function(e){
                e.preventDefault();
                let value = $(this).val();
                if(value != initialStudCount) {
                    let form = $(this).closest('form');
                    let url = form.attr('action');
                    let formData = new FormData(form[0]);
                    formData.append('student_count', value);
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // Parse the JSON response
                    })
                    .then(data => {
                        $('.studentCount').each(function(){
                            if(data.labSchedule!=null && $(this).data('class-id') == data.labSchedule.id){
                                $(this).val(data.labSchedule.student_count);
                            }
                        })
                        toastr.success(data.message);
                    })
                    .catch(error => {
                        let message = "An error has occured";
                        toastr.error(message);
                    });
                }
            });
            $('.studentCount').on('focusin', function () {
                initialStudCount = $(this).val();
            });
            $('#day, #time, #room').on('change', function(e){
                let row = $(this).closest('tr');
                let class_id = row.data('class-id');
                // Get the values of each select in the row
                let day_id = row.find('#day').val().trim();
                let time_start = row.find('#time').val().trim();
                let room_id = row.find('#room').val().trim();

                // console.log(day, time, room);
                if(day_id && time_start && room_id) {
                    let facultyId = faculty.id;
                    let url = `{{route('assign-day-time-room-for-lab', ['classSchedule'])}}`.replace('classSchedule', class_id);
                    url += `?day_id=${encodeURIComponent(day_id)}&time_start=${encodeURIComponent(time_start)}&room_id=${encodeURIComponent(room_id)}`;
                    console.log(url);
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // Parse the JSON response
                    })
                    .then(data => {
                        console.log(data);
                        let message = data.message;
                        toastr.success(message);
                    })
                    .catch(error => {
                        let message = "An error has occured";
                        toastr.error(message);
                    });
                    
                }
                // fetch(url, {
                //     method: 'GET',
                //     headers: {
                //         'X-Requested-With': 'XMLHttpRequest',
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // })
                // .then(response => {
                //     if (!response.ok) {
                //         throw new Error('Network response was not ok');
                //     }
                //     return response.json(); // Parse the JSON response
                // })
                // .then(data => {
                //     let timeSelect = $(this).closest('tr').find('.time-select');
                //     timeSelect.empty();
                //     timeSelect.append(`<option value="">Select Time</option>`);
                //     console.log(data);
                //     data.forEach(time => {
                //         timeSelect.append(`<option value="${time.id}">${time.time_start}-${time.time_end}</option>`);
                //     });
                // })
                // .catch(error => {
                //     let message = "An error has occured";
                //     toastr.error(message);
                // });
            });
        });
        function assignTimeRoom(classId, selectedRoom, selectedTime, day, row) {
            let url = `/assign-day-time-room/${classId}`;
            let roomSelect = row.querySelector(".room-select");
            let timeSelect = row.querySelector(".time-select");
        }
    </script>
    @if (Session::has('success'))
        <script>
            toastr.success('{{ Session::get('success') }}');
        </script>
    @endif
@endsection