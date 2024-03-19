<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container-fluid">
        <div class="card" style="overflow:auto;">
            <div class="card-header">
                <h5>S.Y. {{$academicYearTerm->academic_year->year_start}}-{{$academicYearTerm->academic_year->year_start + 1}} {{$academicYearTerm->term->term}}</h5>
                <p id="scheduledDay" data-day1="{{$days[1]->id}}" data-day2="{{$days[2]->id}}" class="mb-0"><i class="fa fa-chevron-left" style="font-size:x-small; cursor: pointer;"></i> {{$days[1]->day}}/{{$days[4]->day}} <i class="fa fa-chevron-right" style="font-size:x-small;cursor: pointer;"></i></p>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x:auto;height:80vh;">
                    <table
                        id="plotScheduleTable" 
                        class="table table-bordered" 
                        style="table-layout:fixed;width:100%;">
                        <thead style="position: sticky;top: 0;z-index: 2;">
                            <tr>
                                <th scope="col" style="width: 150px;">Time\Room</th>
                                @foreach ($classrooms as $room) 
                                    <th scope="col" style="width: 150px;background: rgb(29, 29, 29);">{{$room->room_number}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody id="timeTable">
                            @php
                                $time = strtotime('07:30');
                            @endphp
                            @for ($i = 0; $i < 9; $i++)
                                @php
                                    $current_time = date('h:i A', $time);
                                @endphp
                                <tr>
                                    <td scope="row" style="white-space: nowrap;">{{ $current_time }} - {{ date('h:i A', strtotime(($current_time == '12:00 PM') ? '+60 minutes' : '+90 minutes', $time)) }}
                                    </td>
                                    @foreach ($classrooms as $room)
                                    @php
                                        $classSchedule = $classSchedules->where('time_start', $current_time)->where('classroom_id', $room->id)->first();
                                        if ($classSchedule) {
                                            $yrLevel = $classSchedule->subject->year_level;
                                            $year = "";
                                            switch ($yrLevel) {
                                                case '1st Year':
                                                    $year = "1CS";
                                                    break;
                                                case '2nd Year':
                                                    $year = "2CS";
                                                    break;
                                                case '3rd Year':
                                                    $year = "3CS";
                                                    break;
                                                case '4th Year':
                                                    $year = "4CS";
                                                    break;
                                                default:
                                                    $year = "";
                                                    break;
                                            }
                                        }
                                    @endphp
                                        <td style="background-color: {{$classSchedule?$classSchedule->faculty->color:"None"}}">
                                            {{$classSchedule?$classSchedule->subject->course_code:""}}-{{$classSchedule?$year:""}}{{$classSchedule?$classSchedule->block->block:""}} <br>
                                            {{$classSchedule?$classSchedule->faculty->last_name:""}}
                                        </td>
                                    @endforeach
                                </tr>
                                @php
                                    $time = $current_time=="12:00 PM"?strtotime('+60 minutes', $time):strtotime('+90 minutes', $time);
                                @endphp
                            @endfor
                        </tbody>
                    </table>  
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>