<h5>Course Offerings</h5>
<div id="toolbar" class="me-1">

    <button id="button" class="btn btn-primary rounded" data-academic-year-term="{{$academicYearTerm->id}}"><i class="fa fa-plus-square"></i> Open|Edit</button>
    {{-- <select id="filterSelect" class="form-control" >
        <option value="">All</option>
        <option value="1st Year">1st Year</option>
        <option value="2nd Year">2nd Year</option>
        <option value="3rd Year">3rd Year</option>
        <option value="4th Year">4th Year</option>
    </select> --}}
</div>
<table 
    id="table" 
    data-toggle="table" 
    data-toolbar="#toolbar" 
    data-click-to-select="true"  
    data-search="true"
    data-toolbar-align="left"
    data-pagination="true"
    data-pagination-h-align="left"
    data-pagination-detail-h-align="right"
    data-pagination-v-align="bottom"
    class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="course_code" data-sortable="true">Subject Code</th>
            <th data-field="description" data-sortable="true">Description</th>
            <th data-field="year_level" data-sortable="true" >Year Level</th>
            <th data-field="blocks" data-sortable="true">Blocks</th>
            <th data-click-to-select="false">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subjects as $subject)
            <tr data-subject-id="{{$subject->id}}">
                <td></td>
                <td>{{$subject->course_code}}</td>
                <td>{{$subject->description}}</td>
                <td>{{$subject->year_level}}</td>
                <td class="text-center">{{$classSchedules->where('subject_id', $subject->id)->where('class_type','lecture')->count()}}</td>
                <td class="text-center">
                    <button class="btn btn-primary rounded px-2 py-0 loadBtn" data-toggle="tooltip" title="Add/Remove Blocks"><i class="fa fa-edit"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>