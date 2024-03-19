<table 
    id="table" 
    data-toggle="table" 
    data-search="true"
    class="table table-bordered">
    <thead>
        <tr>
            <th data-field="date" data-sortable="true" scope="col">Day/Time</th>
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
                    $day = $class->days[0]->day== "Monday"&&$class->days[1]->day=="Thursday"?"MTh":"TF";
                    $schedule = $day." ".$class->time_start."-".$class->time_end;
                    $room = $class->classroom->room_number;
                }else {
                    $schedule = "TBD";
                    $room = "TBD";
                }
            @endphp
            <tr>
                <td class="col-2">{{$schedule}}</td>
                <td class="col-1">{{$class->subject->course_code}}</td>
                <td class="col-4">{{$class->subject->description}}</td>
                <td class="col-1">{{$class->units}}</td>
                <td class="col-1">{{$room}}</td>
                <td class="col-1"><input type="number" class="form-control form-control-sm" value="{{$class->student_count}}"></td>
                <td class="col-2">
                    <select class="form-select form-select-sm" aria-label="Load Type">
                        <option selected>Load Type</option>
                        @foreach ($loadTypes as $loadType)
                        <option value="{{$loadType->id}}">{{$loadType->load_type}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>