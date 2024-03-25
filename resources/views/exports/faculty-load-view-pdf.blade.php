<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .header {
            text-align: center;
            margin-top: 0;
            margin-bottom: 0;
        }
        .table-schedule {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <img src="{{public_path('admin-assets/image/nemsuheaderfinal.png')}}" alt="" style="width: 100%">
    <hr>
    <h4 class="header">College of Information Technology Education</h4>
    <h4 class="header">Department of Computer Studies</h4>
    <h4 style="text-align: center;margin:10px 0 2px 0;">{{$academicYearTerm->term->term}}, A.Y. {{$academicYearTerm->academic_year->year_start}}-{{$academicYearTerm->academic_year->year_start + 1}}</h4>
    <h4 style="text-align: center; background-color:rgb(172, 255, 172); color:rgb(0, 114, 0);margin:5px;">REGULAR LOAD</h4>
    <table style="width: 100%; border-collapse: collapse; font-size:12px">
        <tbody>
            <tr>
                <td>Name:</td>
                <td>{{ strtoupper($faculty->last_name) }}, {{ strtoupper($faculty->first_name) }}</td>
                <td>Educational Qualification:</td>
                <td>DTE</td>
            </tr>
            <tr>
                <td>Years in Service:</td>
                <td>15</td>
                <td>Major:</td>
                <td>0</td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>{{$faculty->status}}</td>
                <td>Eligibility/PRC:</td>
                <td>RA</td>
            </tr>
        </tbody>
    </table>
    <table border="1" style="width: 100%; border-collapse: collapse; margin-top:5px" class="table-schedule">
        <thead>
            <tr style="background-color: rgb(204, 236, 204)">
                <th>Day and Time</th>
                <th>Sched_ID</th>
                <th>Subject Code</th>
                <th>Description</th>
                <th>Unit</th>
                <th>Students</th>
                <th>Room</th>
            </tr>
            
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;background-color:rgb(175, 175, 175)">Monday/Thursday-Morning</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php
                $time = strtotime('07:30');
            @endphp
            @for ($i=1; $i<4; $i++)
                @php
                    $current_time = date('h:i', $time);
                    $curTime = date('h:i A', $time);
                @endphp
                <tr>
                    <td style="text-align: center">{{ $current_time }} - {{ date('h:i', strtotime('+90 minutes', $time)) }}</td>
                    @php
                        $dayName = 'Monday'; // The name of the day you want to filter

                        $classesForMonday = $classes->filter(function ($class) use ($dayName) {
                            return $class->days->contains('day', $dayName);
                        });
                        $class = $classesForMonday->where('time_start', $curTime)->first();
                    @endphp
                    @if ($class)
                        <td style="text-align: center"></td>
                        <td style="text-align: center">{{$class->subject->course_code}}-{{$class->block->block}}</td>
                        <td style="text-align: center">{{$class->subject->description}}</td>
                        <td style="text-align: center">{{$class->units}}</td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center">{{$class->classroom->room_number}}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
                @php
                    $time = strtotime('+90 minutes', $time);
                @endphp
            @endfor
            <tr>
                <td style="text-align: center;background-color:rgb(175, 175, 175)">Monday/Thursday-Afternoon</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php
                $time = strtotime('13:00');
            @endphp
            @for ($i=1; $i<6; $i++)
                @php
                    $current_time = date('h:i', $time);
                    $curTime = date('h:i A', $time);
                @endphp
                <tr>
                    <td style="text-align: center">{{ $current_time }} - {{ date('h:i', strtotime('+90 minutes', $time)) }}</td>
                    @php
                        $class = $classesForMonday->where('time_start', $curTime)->first();
                    @endphp
                    @if ($class)
                        <td style="text-align: center"></td>
                        <td style="text-align: center">{{$class->subject->course_code}}-{{$class->block->block}}</td>
                        <td style="text-align: center">{{$class->subject->description}}</td>
                        <td style="text-align: center">{{$class->units}}</td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center">{{$class->classroom->room_number}}</td>
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
                @php
                    $time = strtotime('+90 minutes', $time);
                @endphp
            @endfor
            
            <tr>
                <td style="text-align: center;background-color:rgb(175, 175, 175)">Tuesday/Friday-Morning</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php
                $time = strtotime('07:30');
            @endphp
            @for ($i=1; $i<4; $i++)
                @php
                    $current_time = date('h:i', $time);
                @endphp
                <tr>
                    <td style="text-align: center">{{ $current_time }} - {{ date('h:i', strtotime('+90 minutes', $time)) }}</td>
                    <td ></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @php
                    $time = strtotime('+90 minutes', $time);
                @endphp
            @endfor
            <tr>
                <td style="text-align: center;background-color:rgb(175, 175, 175)">Tuesday/Friday-Afternoon</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php
                $time = strtotime('01:00');
            @endphp
            @for ($i=1; $i<6; $i++)
                @php
                    $current_time = date('h:i', $time);
                @endphp
                <tr>
                    <td style="text-align: center">{{ $current_time }} - {{ date('h:i', strtotime('+90 minutes', $time)) }}</td>
                    <td ></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @php
                    $time = strtotime('+90 minutes', $time);
                @endphp
            @endfor
        </tbody>
    </table>
</body>
</html>