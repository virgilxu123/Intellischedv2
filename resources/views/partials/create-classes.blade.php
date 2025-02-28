<h5>Course Offerings</h5>
<div class="row">
    <div class="col-7">
        <div id="toolbar" class="me-1">
        
            <button id="button" class="btn btn-primary rounded btn-sm" data-academic-year-term="{{$academicYearTerm->id}}"><i class="fa fa-plus-square d-inline"></i> Open|Edit</button>
            <div class="dropdown d-inline">
                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-filter"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#" data-value="1">First Semester</a></li>
                    <li><a class="dropdown-item" href="#" data-value="2">Second Semester</a></li>
                </ul>
            </div>
        </div>
        <div class="table-responsive" style="overflow-x:auto;height:75vh;">
            <table 
            id="table" 
            data-toggle="table" 
            data-toolbar="#toolbar" 
            data-click-to-select="true"  
            data-search="true"
            data-toolbar-align="left"
            class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th data-field="state" data-checkbox="true"></th>
                        <th data-field="course_code" data-sortable="true">Subject Code</th>
                        <th data-field="description" data-sortable="true">Description</th>
                        <th data-field="year_level" data-sortable="true" >Year Level</th>
                        {{-- <th data-field="blocks" data-sortable="true" data-click-to-select="false">Blocks</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects as $subject)
                        <tr class="subject_to_offer" data-subject-id="{{$subject->id}}" data-term-id={{$subject->term_id}}>
                            <td></td>
                            <td>{{$subject->course_code}}</td>
                            <td>{{$subject->description}}</td>
                            <td>{{$subject->year_level}}</td>
                            {{-- <td class="text-center col-1 ">
                                <form action="" method="POST">
                                    @csrf
                                    <input name="blocks" class="form-control form-control-sm text-center classCount" readonly="true" type="number" min="0" max="21" data-subject-id={{$subject->id}} value="{{$classSchedules->where('subject_id', $subject->id)->where('class_type','lecture')->count()}}">
                                </form>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
    <div class="col-5">
        <div class="card">
            <div class="card-header text-bg-danger">
                Courses Offered
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x:auto;max-height:65vh;">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Description</th>
                                <th>Blocks</th>
                                <th>Sched_Id</th>
                            </tr>
                        </thead>
                        <tbody id="courseOfferings">
                            @foreach (['First Year', 'Second Year', 'Third Year', 'Fourth Year'] as $yearLevel)
                                <tr>
                                    <td colspan="4" class="bg-success"><strong>{{ $yearLevel }}</strong></td>
                                </tr>
                                @foreach ($classSchedules2->filter(fn($cs) => $cs->subject->year_level === $yearLevel) as $classSchedule)
                                    <tr class="courseOffering" data-subject-id="{{ $classSchedule->subject_id }}">
                                        <td class="col-3">{{ $classSchedule->subject->course_code }}</td>
                                        <td class="col-6">{{ $classSchedule->subject->description }}</td>
                                        <td class="text-center col-2">
                                            <form action="" method="POST">
                                                @csrf
                                                <input name="blocks" class="form-control form-control-sm text-center classCount" readonly="true" type="number" min="0" max="21" data-subject-id="{{ $classSchedule->subject_id }}" value="{{ $classSchedule->sections_count }}">
                                            </form>
                                        </td>
                                        <td class="text-center col-1"><button class="rounded px-2 py-0" data-bs-toggle="modal" data-bs-target="#addEditSchedId" data-toggle="tooltip" title="Add/Edit Load" data-subject-id="{{ $classSchedule->subject_id }}" onclick="populateScheduleId(this)"><i class="fa fa-edit"></button></i></td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="addEditSchedId" class="modal fade fadeIn" tabindex="-1">
    <div class="modal-dialog">
        <form action="" method="POST" id="addEditScheduleIdForm">
        @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Schedule Id: <b id="subject_code"></b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary rounded">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
