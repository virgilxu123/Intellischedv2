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
        body{
            font-size: 13px;
        }
        td {
            padding: 2px;   
        }
        .image-container {
            text-align: center;
        }
        p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="image-container">
        <img src="{{ public_path('admin-assets/image/nemsuheaderfinal.png') }}" alt="" style="width: 75%; display: block;">
        <hr>
    </div>
    <h4 class="header">FACULTY WORKLOAD SUMMARY</h4> <br>
    <p><?php $today = date('F j, Y'); echo $today; ?></p> <br>
    <p><b>{{strtoupper($VPForAcadAffairs->first_name)}} {{strtoupper($VPForAcadAffairs->middle_initial)}}. {{ strtoupper($VPForAcadAffairs->last_name) }}, {{$VPForAcadAffairs->educ_qualification}}</b></p>
    <p>Vice President for Academic Affairs</p>
    <p>This University</p><br>
    <p style="margin-left:25px;">Thru: <b>{{strtoupper($campusDirector->first_name)}} {{strtoupper($campusDirector->middle_initial)}}. {{ strtoupper($campusDirector->last_name) }}, {{$campusDirector->educ_qualification}}</b></p>
    <p style="margin-left:55px;">Campus Director, Nemsu Main</p><br>
    <p>Dear VPAA:</p> <br>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The college of Information Technology Education of North Eastern Mindanao State University Tandag Campus respectfully submits the faculty workload summary for the {{$academicYearTerm->term->term}} of the Academic Year {{$academicYearTerm->academic_year->year_start}}-{{$academicYearTerm->academic_year->year_start + 1}}.</p>
    <table border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <td>No.</td>
                <td style="width: 35%">Name of the Faculty</td>
                <td><p>Status(Permanent,</p> <p>temporary,</p> <p>COS, Part-time)</p></td>
                <td>Regular Load</td>
                <td>Overload <p>(Undergrad)</p></td>
                <td>Overload <p>(Graduate School)</p></td>
                <td>Emergency Load</td>
                <td>Praise Load</td>
                <td>Total</td>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1;
            @endphp
            @foreach ($faculties as $faculty)
                <tr>
                    <td>@php
                        echo $counter++.'.';
                    @endphp</td>
                    <td style="width: 40%">{{$faculty->last_name}}, {{$faculty->first_name}} {{$faculty->middle_initial}}.</td>
                    <td>{{$faculty->status}}</td>
                    <td>{{$faculty->regularLoad($academicYearTerm)}}</td>
                    <td>{{$faculty->overLoad($academicYearTerm)}}</td>
                    <td></td>
                    <td>{{$faculty->emergencyLoad($academicYearTerm)}}</td>
                    <td>{{$faculty->praiseLoad($academicYearTerm)}}</td>
                    <td><b>{{$faculty->regularLoad($academicYearTerm) + $faculty->overLoad($academicYearTerm) + $faculty->emergencyLoad($academicYearTerm) + $faculty->praiseLoad($academicYearTerm)}}</b></td>
                </tr>
            @endforeach
            <tr>
                <td colspan="9">
                    <i>***Nothing Follows***</i>
                </td>
            </tr>
        </tbody>
    </table>
    <p>Prepared by:</p><br>
    <p><b>ESMAEL V. MALIBERAN, DIT</b></p>
    <p>Department Chair, CITE</p>
    <hr>
    <p style="text-align: center"><b>CERTIFICATION</b></p><br>
    <p>This is to certify that the aforementioned names have rendered Overload, Emergency Load, and/or PRAISE Load, teaching services during the <b>{{$academicYearTerm->term->term}}</b> of the Academic Year <b>{{$academicYearTerm->academic_year->year_start}}-{{$academicYearTerm->academic_year->year_start + 1}}</b> in the <b>College of Information Technology Education.</b></p><br>
    <p style="text-align: center">This is to certify further that the teaching load(s) undertaken are over the regular workload.</p>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; text-align: center; font-size:12px;padding-top:">
                <span"><u><b>BORN CHRISTIAN A. ISIP, DTE</b></u></span><br>
                <span><i>Dean, CITE</i></span>
            </td>
            <td style="width: 50%; text-align: center; font-size:12px;padding-top:">
                <span><u><b>LYNNET A. SARVIDA</b></u></span><br>
                <span><i>Registrar III</i></span>
            </td>
        </tr>
    </table>
    <hr>
    <p>Recommended for approval:</p><br>
    <p><b>{{strtoupper($campusDirector->first_name)}} {{strtoupper($campusDirector->middle_initial)}}. {{ strtoupper($campusDirector->last_name) }}, {{$campusDirector->educ_qualification}}</b></p>
    <p>Campus Director, Nemsu Main</p>
    <div style="float: right">
        <p>Approved:</p>
        <p><b>{{strtoupper($VPForAcadAffairs->first_name)}} {{strtoupper($VPForAcadAffairs->middle_initial)}}. {{ strtoupper($VPForAcadAffairs->last_name) }}, {{$VPForAcadAffairs->educ_qualification}}</b></p>
        <p>Vice President for Academic Affairs</p>
    </div>
</body>
</html>
