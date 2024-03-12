@extends('layouts.layout')
@section('links')
    <style>
        .selected-row {
            background-color: #396246;
            border-left: 5px solid #00a128;
        }
        .added-classes {
            
        }
        .added-classes:hover {
            background-color: rgb(255, 241, 241);
            border-bottom: 2px solid rgb(255, 114, 114);
            cursor: pointer;
        }
        
    </style>
@endsection
@section('content')
    {{-- toast --}}
    <div class="toast-container top-0 start-50 translate-middle-x">
        <div id="liveToast" class="toast align-items-centerborder-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    {{-- toast --}}
    <div class="container-fluid">
        <div class="row animate__animated animate__bounceInRight">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p data-academic-year-term="{{$academicYearTerm->id}}" class="academic_year_term">S.Y. {{$academicYearTerm->academic_year->year_start}}-{{$academicYearTerm->academic_year->year_start + 1}}: <em>{{$academicYearTerm->term->term}}</em></p>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="pills-classes-tab" data-bs-toggle="pill" data-bs-target="#pills-classes" type="button" role="tab" aria-controls="pills-classes" aria-selected="true">Classes/Blocks</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="pills-loading-tab" data-bs-toggle="pill" data-bs-target="#pills-loading" type="button" role="tab" aria-controls="pills-loading" aria-selected="false">Faculty Loading</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Plot Schedule</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-classes" role="tabpanel" aria-labelledby="pills-classes-tab" tabindex="0">
                                @include('partials.create-classes')
                            </div>
                            <div class="tab-pane fade" id="pills-loading" role="tabpanel" aria-labelledby="pills-loading-tab" tabindex="0">
                                <div class="row">
                                    @include('partials.faculty-loading')
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                                @include('partials.schedule-plotting')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- open classes modal --}}
    <div id="openClasses" class="modal fade fadeIn" tabindex="-1">
        <div class="modal-dialog">
            <form action="" method="POST" id="openClassesForm">
            @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Open New Classes/Blocks</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="subjectId[]" value="">
                        <label class="form-label" for="blocks">Enter number of blocks for selected subjects</label>
                        <input id="blocks" name="blocks" class="form-control" type="number">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary rounded">Ok</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- open classes modal --}}
    {{-- loadSubject --}}
    <div class="modal fade" id="loadSubject" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" method="POST" id="loadSubjectForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-3">
                            <h6 class="modal-title" id="largeModalLabel "></h6>
                        </div>
                        <div class="col-2">
                            <p>Regular: </h5>
                        </div>
                        <div class="col-2">
                            <p>Praise: </h5>
                        </div>
                        <div class="col-2">
                            <p>Overload: </h5>
                        </div>
                        <div class="col-2">
                            <p>Emergency: </h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body card-block">
                            <div class="row">
                                
                                <div class="col-lg-9 col-md-3" style="max-height: 460px; overflow-y: auto;">
                                <select class="form-select mb-3" id="filterYear" style="position: sticky;top: 0;z-index: 1;">
                                    <option value="all" selected>All</option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                </select>
                                <table class="table table-hover table-bordered">
                                    <thead class="bg-dark text-light" >
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Blocks</th>
                                            <th>Year Level</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($classSchedules as $class)
                                            @if ($class->faculty_id==null)
                                                <tr class="subject-row" data-year="{{$class->subject->year_level}}" data-class-id="{{$class->id}}" data-course-code="{{$class->subject->course_code}}" data-block="{{$class->block->block}}">
                                                    <td>{{$class->subject->course_code}}</td>
                                                    <td>{{$class->subject->description}}</td>
                                                    <td>{{$class->block->block}}</td>
                                                    <td>{{$class->subject->year_level}}</td>
                                                    
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                <div class="col-lg-3 col-md-3" style="max-height: 460px; overflow-y:auto">
                                    <div class="card">
                                        <div class="card-header text-bg-success">
                                            Selected:
                                        </div>
                                        <div id="loadedSubjects" class="card-body">
                                        </div>
                                        <div class="card-footer">
                                            Total Units:
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="class_ids[]">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded mr-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- loadSubject --}}
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            let $table = $('#table');
            let $button = $('#button');
            let $modal = $('#openClasses');
            let $filterSelect = $('#filterSelect');
            let academicYearTerm = $('#button').data('academic-year-term');
            let academicYearTermId = $('.academic_year_term').data('academic-year-term');
            // select subjects to be opened
            $button.click(function () {
                let $selected = $table.bootstrapTable('getSelections');
                let selectedSubjectIds = [];
                if($selected.length > 0){
                    $selected.forEach(function (row) {
                        selectedSubjectIds.push(row._data['subject-id']);
                    });
                    $modal.find('input[name="subjectId[]"]').val(selectedSubjectIds);
                    $('#openClassesForm').attr('action', '{{route("create-class-schedule", ":academicYearTerm")}}'.replace(':academicYearTerm', academicYearTerm));
                    $modal.modal('show');
                }else {
                    alert('Please select a subject');
                }
            });
            //filter subjects by year level
            // $(function() {
            //     $filterSelect.change(function () {
            //         let selectedValue = $filterSelect.val();
            //         if (selectedValue === "") {
            //             // Reset the table to display all data
            //             $table.bootstrapTable('filterBy', {});
            //         } else {
            //             // Filter the table by the selected value
            //             $table.bootstrapTable('filterBy', {
            //                 year_level: [selectedValue]
            //             });
            //         }
            //     });
            // });
            //script to open modal for loading of subject/classes
            let facultyId;
            $(document).on('click', '.loadBtn', function(e) {
                if ($(this).hasClass('loadBtn')) {
                    facultyId = $(this).data('faculty-id'); 
                    let firstName = $(this).data('faculty-first-name');
                    let lastName = $(this).data('faculty-last-name');
                    $('#loadSubjectForm .modal-title').html(`<em>${firstName} ${lastName}</em>`);
                    $('#loadSubjectForm').attr('action', '{{route("assign-classes", ":facultyId")}}'.replace(':facultyId', facultyId));
                }
            });
            //ajax POST request for assigning classes to faculty
            $('#loadSubjectForm').on('submit', function(e) {
                e.preventDefault();
                let url = $(this).attr('action');
                let formData = new FormData(this);
                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Add CSRF token header
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json(); // Parse the JSON response
                })
                .then(data => {
                    $('.subject-row.selected-row').remove();
                    const modalElement  = document.querySelector('#loadSubject');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide(); // Close the modal
                    fetchClassSchedules(facultyId, academicYearTerm);
                })
            });
            //script for loading subject modal
            //filter in modal faculty loading
            $('#filterYear').on('change', function() {
                const selectedYear = $(this).val();
                $('.subject-row').each(function() {
                    const year = $(this).data('year');
                    if (selectedYear === 'all' || year === selectedYear) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
            let selectedClasses = [];
            $('.subject-row').click(function() {
                let classId = $(this).data('class-id');
                $(this).toggleClass('selected-row');
                if ($(this).hasClass('selected-row')) {
                    selectedClasses.push({
                        id: classId,
                        course_code: $(this).data('course-code'),
                        block: $(this).data('block'),
                        year: $(this).data('year'),
                    });
                } else {
                    selectedClasses = selectedClasses.filter(item => item.id !== classId);
                }
                $('#loadSubjectForm').find('input[name="class_ids[]"]').val(selectedClasses.map(function(classObj) {
                    return classObj.id;
                }));
                displaySelectedClasses(selectedClasses);
            })
            function displaySelectedClasses(selectedClasses) {
                let html = '';
                let yearLevel = ''
                selectedClasses.forEach(item => {
                    if (item.year === '1st Year') {
                        yearLevel = '1CS';
                    } else if (item.year === '2nd Year') {
                        yearLevel = '2CS';
                    } else if (item.year === '3rd Year') {
                        yearLevel = '3CS';
                    } else if (item.year === '4th Year') {
                        yearLevel = '4CS';
                    }
                    html += `<span class="text-secondary added-classes py-1 px-1 d-inline-block">
                                ${item.course_code}
                                ${yearLevel}${item.block}
                                <i class="remove-btn fa-regular fa-trash-can text-sm text-danger" data-class-id="${item.id}" style="visibility:hidden"></i>
                            </span>`;
                });
                $('#loadedSubjects').html(html);
            }
            //dynamically show the delete button when hovering over
            $('#loadedSubjects').on('mouseenter', '.added-classes', function() {
                $(this).find('.remove-btn').css('visibility', 'visible');
            }).on('mouseleave', '.added-classes', function() {
                $(this).find('.remove-btn').css('visibility', 'hidden');
            });
            // Remove the selected class
            $('#loadedSubjects').on('click', '.remove-btn', function() {
                const classId = $(this).data('class-id');
                selectedClasses = selectedClasses.filter(item => item.id !== classId);
                displaySelectedClasses(selectedClasses);
                $(`.subject-row[data-class-id="${classId}"]`).removeClass('selected-row');
            });
            $('#loadSubject').on('hidden.bs.modal', function (e) {
                // Reset the modal selection here
                selectedClasses = []; // Reset the selectedClasses array
                $('#loadedSubjects').empty(); // Clear the HTML content inside #loadedSubjects
                $('.subject-row').removeClass('selected-row'); // Remove
                $("#filterYear").val("all").trigger('change');
            });
            //script for loading subject modal
            //script for tab 2
            fetchClassSchedules($('.faculty-row.selected-row').data('faculty-id'), academicYearTerm);
            fetchDesignations($('.faculty-row.selected-row').data('faculty-id'), academicYearTerm);
            $('.faculty-row').click(function () {
                let facultyId = $(this).data('faculty-id');
                let facultyName = $(this).data('faculty-name');
                $('#facultyName').text(facultyName);
                $('.faculty-row').removeClass('selected-row');
                $(this).addClass('selected-row');

                fetchClassSchedules(facultyId, academicYearTerm);
                fetchDesignations(facultyId, academicYearTerm);
            });
            //submit assign designation form
            $('#assignDesignationForm').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                facultyId = $('.faculty-row.selected-row').data('faculty-id');
                console.log(facultyId);
                assignDesignation(facultyId, academicYearTerm, formData)
            })
        //function to fetch schedule of faculty a and render in load overview
            function fetchClassSchedules(facultyId, academicYearTerm) {
                fetch(`{{ route("show-faculty-load", [":facultyId", ":academicYearTerm"]) }}`.replace(':facultyId', facultyId).replace(':academicYearTerm', academicYearTerm))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json(); // Parse the JSON response
                })
                .then(data => {
                    // Clear existing class schedules
                    $('#class-schedule-body').empty();

                    // Loop through class schedules and append HTML to the tbody
                    if (data.classSchedules.length === 0) {
                        let html = `<tr><td colspan="3" class="text-center">No Classes to Show</td></tr>`;
                        $('#class-schedule-body').append(html);
                    } else {
                        data.classSchedules.forEach(classSchedule => {
                            let yearLevel;
                            if (classSchedule.subject.year_level === '1st Year') {
                                yearLevel = '1CS';
                            } else if (classSchedule.subject.year_level === '2nd Year') {
                                yearLevel = '2CS';
                            } else if (classSchedule.subject.year_level === '3rd Year') {
                                yearLevel = '3CS';
                            } else if (classSchedule.subject.year_level === '4th Year') {
                                yearLevel = '4CS';
                            }

                            let html = `<tr class="class-schedule-row animate fadeIn" data-faculty-id="${classSchedule.faculty_id}">
                                            <td>${classSchedule.subject.course_code}- <em>${classSchedule.subject.description}</em> ${yearLevel}${classSchedule.block.block}</td>
                                            <td style="font-size:small;"><em>${classSchedule.time ? `${classSchedule.days[0].day}/${classSchedule.days[1].day}<br>${classSchedule.time}` : 'TBD'}</em></td>
                                            <td class="text-center"><button class="btn btn-danger py-0 px-2 rounded" data-toggle="tooltip" title="Delete Class"><i class="fa-regular fa-trash-can"></i></button></td>
                                        </tr>`;
                            $('#class-schedule-body').append(html);
                        });
                    }

                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
            }
        //function to fetch schedule of faculty a and render in load overview
        //script for fetching designations   
            function fetchDesignations(facultyId, academicYearTerm) {
                fetch(`{{ route("show-designation", [":facultyId", ":academicYearTerm"]) }}`.replace(':facultyId', facultyId).replace(':academicYearTerm', academicYearTerm),{
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json(); // Parse the JSON response
                })
                .then(data => {
                    // Clear existing designations
                    $('#designation-body').empty();
                    // Loop through designations and append HTML to the tbody
                    if (data.designations.length === 0) {
                        let html = `<tr><td colspan="3" class="text-center">No Designations to Show</td></tr>`;
                        $('#designation-body').append(html);
                    } else {
                        data.designations.forEach(designation => {
                            let html = `<tr class=" animate fadeIn" data-faculty-id="${designation.faculty_id}">
                                            <td>${designation.designation}</td>
                                            <td class="text-center"><button class="btn btn-danger py-0 px-2 rounded" data-toggle="tooltip" title="Delete Class"><i class="fa-regular fa-trash-can"></i></button></td>
                                        </tr>`;
                            $('#designation-body').append(html);
                        });
                    }
                // Clear existing options
                    let selectElement = document.getElementById('assignDesignationForm').querySelector('.form-select');
                    selectElement.innerHTML = '';
                    let defaultOption = document.createElement('option');
                    defaultOption.innerText = 'Select Designation';
                    defaultOption.setAttribute('selected', 'selected');
                    selectElement.appendChild(defaultOption);
                // Clear existing options
                    data.designationsToDisplayInOptions.forEach(designationsToDisplayInOption => {
                        let option = document.createElement('option');
                        option.value = designationsToDisplayInOption.id;
                        option.innerText = designationsToDisplayInOption.designation;
                        document.getElementById('assignDesignationForm').querySelector('.form-select').appendChild(option);
                    });
                });
            }
        //script for fetching designations   
        //script for assigning designation
            function assignDesignation(facultyId, academicYearTerm, formData) {
                fetch(`{{ route("assign-designation", [":facultyId", ":academicYearTerm"]) }}`.replace(':facultyId', facultyId).replace(':academicYearTerm', academicYearTerm), {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Add CSRF token header
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json(); // Parse the JSON response
                })
                .then(data => {
                    fetchDesignations(facultyId, academicYearTerm);
                })
                .catch(error => {

                })
            }
        //script for assigning designation

        //script for tab 2

            //script for tab 3 drag and drop operation
            let dayId = $('#scheduledDay').data('day1');
            fetchClasses(academicYearTermId, dayId);
                
            $('#scheduledDay').on('click', '.fa', function() {
                let day1Id = $('#scheduledDay').data('day1');
                let day2Id = $('#scheduledDay').data('day2');
                let day = "";
                if (dayId === day1Id) {
                    dayId = day2Id;
                    day = "{{$days[2]->day}}/{{$days[5]->day}}"; // Replace with Blade syntax to get the day
                } else {
                    dayId = day1Id;
                    day = "{{$days[1]->day}}/{{$days[4]->day}}"; // Replace with Blade syntax to get the day
                }
                $("#scheduledDay").html(`<i class="fa fa-chevron-left" style="font-size:x-small; cursor: pointer;"></i> ${day} <i class="fa fa-chevron-right" style="font-size:x-small;cursor: pointer;"></i>`);
                fetchClasses(academicYearTermId, dayId);
            });
            

            
            const fills = document.querySelectorAll('.fill');
            const empties = document.querySelectorAll('.empty');
            // Loop through empties and call drag events
            fills.forEach(fill => {
                fill.addEventListener('dragstart', dragStart);
                fill.addEventListener('dragend', dragEnd);
            });
            // Add listeners for each fill element
            empties.forEach(empty => {
                empty.addEventListener('dragover', dragOver);
                empty.addEventListener('dragenter', dragEnter);
                empty.addEventListener('dragleave', dragLeave);
                empty.addEventListener('drop', dragDrop);
            });
            

            // Drag functions
            function dragStart() {
                this.classList.add('hold');
                setTimeout(() => this.classList.add('invisible'), 0);
            }

            function dragEnd() {
                this.classList.remove('hold', 'invisible');
            }

            function dragOver(e) {
                e.preventDefault();
            }

            function dragEnter(e) {
                e.preventDefault();
                this.classList.add('hovered');
            }

            function dragLeave() {
                this.classList.remove('hovered');
            }

            function dragDrop() {
                this.classList.remove('hovered');
                const emptyCell = this;
                const filledCell = document.querySelector('.hold');
                const roomNumber = emptyCell.dataset.room;
                const time = emptyCell.dataset.time;
                const classScheduleId = filledCell.dataset.classScheduleId; // Retrieve classScheduleId
                const url = '{{route("assign-time-room-day", ":classScheduleId")}}'.replace(':classScheduleId', classScheduleId);
                // Send AJAX request to save data
                assignRoomTimeDay(classScheduleId, roomNumber, time);
                fetchClasses(academicYearTermId, dayId);
                // // Update UI immediately if needed
                emptyCell.appendChild(filledCell);
                filledCell.classList.remove('mb-3');
            }
            function assignRoomTimeDay(classScheduleId,room,time) {
                const url = '{{route("assign-time-room-day", ":classScheduleId")}}'.replace(':classScheduleId', classScheduleId);
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        room_id: room,
                        time_start: time,
                        day_id: dayId,
                        // Add other data as needed
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            console.log(data.error); // Log the error message
                        });
                    }
                })
                .catch(error => {
                });
            }

            //ajax request to fetch classes
            function fetchClasses($academicYearTerm, dayId) {
                let url = '{{route("create-schedule", ":academicYearTerm")}}'.replace(':academicYearTerm', $academicYearTerm);
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Network response was not ok');
                    }
                })
                .then(data => {
                    // console.log(data.classSchedulesWithRooms);
                    displayPlottedClasses(data.classSchedulesWithRooms, dayId);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
            
            function displayPlottedClasses(classSchedulesWithRooms, dayId) {
                const schedulesArray = Array.from(classSchedulesWithRooms);
                const filteredSchedules = schedulesArray.filter(classSchedule => {
                    // Assuming the days array is an array of day names (e.g., ['Monday', 'Tuesday', ...])
                    return classSchedule.days.some(scheduleDay => scheduleDay.id === dayId);
                });
                $('td.empty').empty().removeAttr('rowspan').css('display', 'table-cell');
                filteredSchedules.forEach(classSchedule => {
                    const roomId = classSchedule.classroom.id;
                    const time = classSchedule.time_start;
                    const yearLevel = classSchedule.subject.year_level;
                    const block = classSchedule.block.block;
                    const courseCode = classSchedule.subject.course_code;
                    const description = classSchedule.subject.description;
                    const facultyName = classSchedule.faculty.first_name + ' ' + classSchedule.faculty.last_name;
                    const facultyColor = classSchedule.faculty.color;
                    const rowsToSpan = 3;
                    const html = `<div class="rounded fill p-1" draggable="true" style="display: block;font-size: small;background-color: ${facultyColor};height:120px;" data-class-schedule-id="${classSchedule.id}">
                        ${courseCode} <em>${description}</em>-${block} <br>
                        <b>${facultyName}</b>
                    </div>`;

                    // Find the first empty cell for the given room and time
                    const timeCell = document.querySelector(`.empty[data-room="${roomId}"][data-time="${time}"]`);

                    // Set the innerHTML of the timeCell with the HTML content
                    if (timeCell) {
                        // Set rowspan for the first cell
                        timeCell.innerHTML = html;
                        timeCell.setAttribute('rowspan', rowsToSpan);

                        // Set the rowspan attribute to the remaining rows for the same room and time
                        let nextRow = timeCell.parentElement.nextElementSibling;
                        let rowspanCount = 1;
                        while (nextRow && rowspanCount < rowsToSpan) {
                            const nextTimeCell = nextRow.querySelector(`.empty[data-room="${roomId}"][data-time="${time}"]`);
                            if (nextTimeCell) {
                                nextTimeCell.style.display = 'none'; // Hide the cell
                                rowspanCount++;
                                nextRow = nextRow.nextElementSibling;
                            } else {
                                break;
                            }
                        }
                    } else {
                        console.error('No empty cell found for room', roomId, 'and time', time);
                    }
                });
            }
            function showToast(status, message) {
                const toast = document.getElementById('liveToast');
                const toastBody = toast.querySelector('.toast-body');
                toastBody.textContent = message;
                if(status==='success'){
                    toast.classList.add('bg-success');
                }
                if(status==='danger'){
                    toast.classList.add('bg-danger');
                }
                toast.classList.remove('hide');
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                    toast.classList.add('hide');
                }, 4000);
            }
        //script for tab 3
        });
    </script>
@endsection