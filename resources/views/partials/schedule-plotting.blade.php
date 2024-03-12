<div class="row animated fadeIn">
    <div class="col-3">
        <div class="card " style="height: 70vh;overflow:auto;">
            <div class="card-header bg-dark text-light">
                <h5 class="card-title">Classes</h5>
            </div>
            <div class="card-body">
                @foreach ($classSchedules as $classSchedule)
                    @if ($classSchedule->faculty_id != null && $classSchedule->classroom_id == null)
                        <div class="badge fill mb-3" draggable="true" style="display: block;background-color: {{$classSchedule->faculty->color}};" data-class-schedule-id="{{$classSchedule->id}}">
                            {{$classSchedule->subject->course_code}}-{{$classSchedule->block->block}} <br>
                            {{$classSchedule->faculty->first_name}} {{$classSchedule->faculty->last_name}}
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-9">
        <div class="card" style="height:80vh;overflow:auto;">
            <div class="card-header">
                <h5>S.Y. {{$academicYearTerm->academic_year->year_start}}-{{$academicYearTerm->academic_year->year_start + 1}} {{$academicYearTerm->term->term}}</h5>
                <p id="scheduledDay" data-day1="{{$days[1]->id}}" data-day2="{{$days[2]->id}}" class="mb-0"><i class="fa fa-chevron-left" style="font-size:x-small; cursor: pointer;"></i> {{$days[1]->day}}/{{$days[4]->day}} <i class="fa fa-chevron-right" style="font-size:x-small;cursor: pointer;"></i></p>
            </div>
            <div class="card-body">
                <div id="tableContainer" class="table-responsive" style="overflow-x:auto;">
                    <table class="table table-bordered" style="table-layout: fixed;width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 150px;">Time\Room</th>
                                @foreach ($rooms as $room) 
                                    <th scope="col" style="width: 150px;">{{$room->room_number}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody id="timeTable">
                            @php
                                $numberOfRooms = count($rooms);
                                $time = strtotime('07:00');
                            @endphp
                            @for ($i = 0; $i < 25; $i++)
                                @php
                                    $current_time = date('h:i', $time);
                                @endphp
                                <tr>
                                    <td scope="row" style="white-space: nowrap;">{{ $current_time }} - {{ date('h:i A', strtotime('+30 minutes', $time)) }}</td>
                                    @foreach ($rooms as $room)
                                        <td class="empty" data-room="{{ $room->id }}" data-time="{{ date('h:i A', $time) }}" data-toggle="tooltip" title="{{$room->room_number}} {{ $current_time }} - {{ date('h:i A', strtotime('+30 minutes', $time)) }}"></td>
                                    @endforeach
                                </tr>
                                @php
                                    $time = strtotime('+30 minutes', $time);
                                @endphp
                            @endfor
                        </tbody>
                    </table>  
                </div>
            </div>
        </div>
    </div>
</div>