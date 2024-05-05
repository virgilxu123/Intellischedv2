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
            <td>{{$faculty->educ_qualification}}</td>
        </tr>
        <tr>
            <td>Years in Service:</td>
            <td>{{$faculty->years_in_service}}</td>
            <td>Major:</td>
            <td>0</td>
        </tr>
        <tr>
            <td>Status:</td>
            <td>{{$faculty->status}}</td>
            <td>Eligibility/PRC:</td>
            <td>{{$faculty->eligibility}}</td>
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
                        return $class->days->contains('day', $dayName)&&$class->load_type_id == 1;
                    });
                    $class = $classesForMonday->where('time_start', $curTime)->first();
                @endphp
                @if ($class)
                    <td style="text-align: center"></td>
                    <td style="text-align: center">{{$class->subject->course_code}}-{{$class->block->block}}</td>
                    <td style="text-align: center">{{$class->subject->description}}</td>
                    <td style="text-align: center">{{$class->units}}</td>
                    <td style="text-align: center">{{$class->student_count}}</td>
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
                    <td style="text-align: center">{{$class->student_count}}</td>
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
                $curTime = date('h:i A', $time);
            @endphp
            <tr>
                <td style="text-align: center">{{ $current_time }} - {{ date('h:i', strtotime('+90 minutes', $time)) }}</td>
                @php
                    $dayName = 'Tuesday'; // The name of the day you want to filter

                    $classesForTuesday = $classes->filter(function ($class) use ($dayName) {
                        return $class->days->contains('day', $dayName)&&$class->load_type_id == 1;
                    });
                    $class = $classesForTuesday->where('time_start', $curTime)->first();
                @endphp
                @if ($class)
                    <td style="text-align: center"></td>
                    <td style="text-align: center">{{$class->subject->course_code}}-{{$class->block->block}}</td>
                    <td style="text-align: center">{{$class->subject->description}}</td>
                    <td style="text-align: center">{{$class->units}}</td>
                    <td style="text-align: center">{{$class->student_count}}</td>
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
            <td style="text-align: center;background-color:rgb(175, 175, 175)">Tuesday/Friday-Afternoon</td>
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
        @for ($i=1; $i<4; $i++)
            @php
                $current_time = date('h:i', $time);
                $curTime = date('h:i A', $time);
            @endphp
            <tr>
                <td style="text-align: center">{{ $current_time }} - {{ date('h:i', strtotime('+90 minutes', $time)) }}</td>
                @php
                    $dayName = 'Tuesday'; // The name of the day you want to filter

                    $classesForTuesday = $classes->filter(function ($class) use ($dayName) {
                        return $class->days->contains('day', $dayName)&&$class->load_type_id == 1;
                    });
                    $class = $classesForTuesday->where('time_start', $curTime)->first();
                @endphp
                @if ($class)
                    <td style="text-align: center"></td>
                    <td style="text-align: center">{{$class->subject->course_code}}-{{$class->block->block}}</td>
                    <td style="text-align: center">{{$class->subject->description}}</td>
                    <td style="text-align: center">{{$class->units}}</td>
                    <td style="text-align: center">{{$class->student_count}}</td>
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
            <td style="color:white;">0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="color:white;">0</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"><span style="margin-left: 180px">No. of Units</span></td>
            <td></td>
            <td style="text-align: center">{{$regularLoad}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"><span style="margin-left: 180px">No. of Preparations</span></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"><span style="margin-left: 180px">Mandatory Deloading</span></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"><span style="margin-left: 180px">Designation</span></td>
            <td style="text-align: center">
                @foreach ($designations as $designation)
                    {{$designation->designation}}
                @endforeach
            </td>
            <td style="text-align: center">{{$designationLoad}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"><span style="margin-left: 180px">Special Assignments</span></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td style="text-align: center;"><strong>Total No.of Units</strong></td>
            <td style="text-align: center">{{$regularLoad + $designationLoad}}</td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
<br>
<table style="width: 100%">
    <tr>
        <td style="width: 50%; text-align: left; font-size:12px;">
            Prepared by:
        </td>
        <td style="width: 50%; text-align: left; font-size:12px;">
            Conformed:
        </td>
    </tr>
    <tr>
        <td style="width: 50%; text-align: center; font-size:12px;padding-top: 20px;">
            <span"><u><b>ESMAEL V. MALIBERAN, DIT</b></u></span><br>
            <span><i>Department Chairperson</i></span>
        </td>
        <td style="width: 50%; text-align: center; font-size:12px;padding-top: 20px;">
            <span><u><b>{{ strtoupper($faculty->first_name) }} {{ strtoupper($faculty->last_name) }}</b></u></span><br>
            <span><i>{{$faculty->rank}}</i></span>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 20px; font-size: 12px;">Recommending Approval:</td>
    </tr>
    <tr>
        <td style="width: 50%; text-align: center; font-size:12px;padding-top: 20px;">
            <span"><u><b>BORN CHRISTIAN ISIP, DTE</b></u></span><br>
            <span><i>Dean, CITE</i></span>
        </td>
        <td style="width: 50%; text-align: center; font-size:12px;padding-top: 20px;">
            <span"><u><b>{{strtoupper($campusDirector->first_name)}} {{strtoupper($campusDirector->middle_initial)}}. {{ strtoupper($campusDirector->last_name) }}, {{$campusDirector->educ_qualification}}</b></u></span><br>
            <span><i>Campus Director, Nemsu Main</i></span>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding: 20px 0 0 220px; font-size: 12px;">
            Approved:
        </td>
        
    </tr>
    <tr>
        <td colspan="2" style="text-align: center; font-size:12px;padding-top: 10px;">
            <span"><u><b>{{strtoupper($VPForAcadAffairs->first_name)}} {{strtoupper($VPForAcadAffairs->middle_initial)}}. {{ strtoupper($VPForAcadAffairs->last_name) }}, {{$VPForAcadAffairs->educ_qualification}}</b></u></span><br>
            <span><i>Vice President for Academic Affairs</i></span>
        </td>
    </tr>
</table>