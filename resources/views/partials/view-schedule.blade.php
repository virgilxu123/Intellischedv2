<div class="row animated fadeIn">
    <div class="col-2">
        <div class="card " style="max-height: 90vh;overflow:auto;">
            <div class="card-header bg-dark text-light">
                <h5 class="card-title">Classes</h5>
                <div class="row">
                    <div class="col">
                        <label class="form-label" for="selectYear">Year Level</label>
                        <select class="form-select form-select-sm" aria-label="Select Class Type" id="selectYear">
                            <option value="all" selected>All</option>
                            <option value="lecture">1st Year</option>
                            <option value="laboratory">2nd Year</option>
                            <option value="laboratory">3rd Year</option>
                            <option value="laboratory">4th Year</option>
                          </select>
                          
                    </div>
                </div>
            </div>
            <div class="card-body d-flex flex-column align-items-center">
                @php
                    $yearMapping = [
                        "First Year" => 1,
                        "Second Year" => 2,
                        "Third Year" => 3,
                        "Fourth Year" => 4
                    ];
                @endphp
                @foreach ($blockCounts as $yearLevel => $blockCount)
                    <h5 class="text-center text-dark fw-bold">{{ $yearLevel }} Blocks</h5>
                    
                    @foreach ($blocks as $block)
                        @if ($block->id > $blockCount)
                            @php break; @endphp
                        @endif
                        <div class="col-6 card mb-2 text-center bg-primary text-light" 
                            style="cursor: pointer;" 
                            data-id="{{ $block->id }}" 
                            data-year="{{ $yearLevel }}" 
                            data-academicYearTerm="{{$academicYearTerm->id}}" 
                            onclick="showBlockDetails(this)">
                            {{ $yearMapping[$yearLevel] ?? '' }} CS - {{ $block->block }}
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-10">
        <div class="card">
            <div class="card-header bg-success text-light">
                <h5 id="card-header"> </h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="scheduleByBlock">
                    <thead>
                        <tr>
                            <th scope="col" class="bg-warning text-dark">Subject</th>
                            <th scope="col" class="bg-warning text-dark">Day</th>
                            <th scope="col" class="bg-warning text-dark">Time</th>
                        </tr>
                    </thead>
                    <form action="" method="Post">
                    @csrf
                    <tbody>
                            
                    </tbody>
                    </form>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector("#scheduleByBlock tbody").addEventListener("change", function (event) {
                let target = event.target;
                // Check if the changed element is either the day or time dropdown
                if (target.classList.contains("day-select") || target.classList.contains("time-select")) {
                    let row = target.closest("tr"); // Get the parent row of the changed dropdown
                    let daySelect = row.querySelector(".day-select"); // Find the day dropdown in the same row
                    let timeSelect = row.querySelector(".time-select"); // Find the time dropdown in the same row

                    let selectedDay = daySelect.value;
                    let selectedTime = timeSelect.value;
                    let classId = daySelect.getAttribute("data-classId"); // Get class ID
                    console.log(selectedDay, selectedTime, classId);

                    // Ensure both dropdowns have values before making the request
                    if (selectedDay && selectedTime) {
                        assignDayAndTime(classId, selectedDay, selectedTime, row);
                    }
                }
            });
        });
        function showBlockDetails(element) {
            let block = element.getAttribute('data-id');
            let yearLvl = element.getAttribute('data-year');
            let acadYrTerm = element.getAttribute('data-academicYearTerm');
            document.getElementById('card-header').innerHTML = element.innerHTML;
            let url = `{{ route('get-subjects', ['academicYearTerm' => '__ACADEMIC_YEAR_TERM__', 'year' => '__YEAR_LVL__', 'block' => '__BLOCK__']) }}`;
        
            url = url.replace('__ACADEMIC_YEAR_TERM__', acadYrTerm)
                    .replace('__YEAR_LVL__', yearLvl)
                    .replace('__BLOCK__', block);
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
        
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    displaySchedule(data);
                })
                .catch(error => console.error('Error:', error));
        }
        function displaySchedule(data) {
            document.querySelector("#scheduleByBlock tbody").innerHTML = ""; // Clear table
            data.subjects.forEach(subject => {
                // console.log(subject.subject.subject_type);
                let isMinor = subject.subject.subject_type === 'Minor';
                // Get saved day from database (if exists)
                let savedDay = subject.days && subject.days.length > 0 ? subject.days[0].id : "";
                // Get saved time from database (if exists)
                let savedTime = subject.time_start || "";
                let dayOptions = `
                    <option value="">Select Day</option>
                    <option value="2" ${savedDay == 2 ? "selected" : ""}>Monday/Thursday</option>
                    <option value="3" ${savedDay == 3 ? "selected" : ""}>Tuesday/Friday</option>
                    <option value="4" ${savedDay == 4 ? "selected" : ""}>Wednesday</option>
                `;
                let timeOptions = "";
                if (subject.subject.units === "2") {
                    // 1-hour intervals for 2-unit subjects
                    timeOptions = `
                        <option value="">Select Time</option>
                        <option value="7:30 AM" ${savedTime == "7:00 AM" ? "selected" : ""}>7:00 AM - 8:00 AM</option>
                        <option value="8:30 AM" ${savedTime == "8:00 AM" ? "selected" : ""}>8:00 AM - 9:00 AM</option>
                        <option value="9:30 AM" ${savedTime == "9:00 AM" ? "selected" : ""}>9:00 AM - 10:00 AM</option>
                        <option value="10:30 AM" ${savedTime == "10:00 AM" ? "selected" : ""}>10:00 AM - 11:00 AM</option>
                        <option value="1:00 PM" ${savedTime == "1:00 PM" ? "selected" : ""}>1:00 PM - 2:00 PM</option>
                        <option value="2:00 PM" ${savedTime == "2:00 PM" ? "selected" : ""}>2:00 PM - 3:00 PM</option>
                        <option value="3:00 PM" ${savedTime == "3:00 PM" ? "selected" : ""}>3:00 PM - 4:00 PM</option>
                        <option value="4:00 PM" ${savedTime == "4:00 PM" ? "selected" : ""}>4:00 PM - 5:00 PM</option>
                        <option value="5:00 PM" ${savedTime == "5:00 PM" ? "selected" : ""}>5:00 PM - 6:00 PM</option>
                        <option value="6:00 PM" ${savedTime == "6:00 PM" ? "selected" : ""}>6:00 PM - 7:00 PM</option>
                        <option value="7:00 PM" ${savedTime == "7:00 PM" ? "selected" : ""}>7:00 PM - 8:00 PM</option>
                    `;
                } else {
                    // Default 1 hour 30 minutes for 3-unit subjects
                    timeOptions = `
                        <option value="">Select Time</option>
                        <option value="7:30 AM" ${savedTime == "7:30 AM" ? "selected" : ""}>7:30 AM - 9:00 AM</option>
                        <option value="9:00 AM" ${savedTime == "9:00 AM" ? "selected" : ""}>9:00 AM - 10:30 AM</option>
                        <option value="10:30 AM" ${savedTime == "10:30 AM" ? "selected" : ""}>10:30 AM - 12:00 PM</option>
                        <option value="1:00 PM" ${savedTime == "1:00 PM" ? "selected" : ""}>1:00 PM - 2:30 PM</option>
                        <option value="2:30 PM" ${savedTime == "2:30 PM" ? "selected" : ""}>2:30 PM - 4:00 PM</option>
                        <option value="4:00 PM" ${savedTime == "4:00 PM" ? "selected" : ""}>4:00 PM - 5:30 PM</option>
                        <option value="5:30 PM" ${savedTime == "5:30 PM" ? "selected" : ""}>5:30 PM - 7:00 PM</option>
                        <option value="7:00 PM" ${savedTime == "7:00 PM" ? "selected" : ""}>7:00 PM - 8:30 PM</option>
                    `;
                }
                let dayCell = isMinor
                    ? `<select class="form-select day-select form-select-sm" data-blockId="${subject.block.id}" data-classId="${subject.id}">${dayOptions}</select>`
                    : `<em>${subject.days && subject.days.length > 0 
                        ? subject.days.map(d => d.day).join('/') 
                        : 'TBD'}</em>`;

                let timeCell = isMinor
                    ? `<select class="form-select time-select" form-select-sm>${timeOptions}</select>`
                    : `<em>${subject.time_start && subject.time_end 
                        ? `${subject.time_start} - ${subject.time_end}` 
                        : 'TBD'}</em>`;
                let html = `<tr class="class-schedule-row animate fadeIn">
                                <td>${subject.subject.course_code} - <em>${subject.subject.description}</em></td>
                                <td style="">${dayCell}</td>
                                <td style="">${timeCell}</td>
                            </tr>`;
                document.querySelector("#scheduleByBlock tbody").insertAdjacentHTML('beforeend', html);
            });
        }
        function assignDayAndTime(classId, selectedDay, selectedTime, row) {
            let url = `/assign-day-time/${classId}`;
            let daySelect = row.querySelector(".day-select");
            let timeSelect = row.querySelector(".time-select");

            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json", // Forces Laravel to return JSON instead of HTML
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") // Laravel CSRF Token
                },
                body: JSON.stringify({
                    day_id: selectedDay,
                    time_start: selectedTime,
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP Error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Day & Time Assigned Successfully:", data);
                toastr.success(data.message);
                // Optional: Replace dropdowns with static text after saving
                // row.querySelector(".day-select").outerHTML = `<em>${selectedDay}</em>`;
                // row.querySelector(".time-select").outerHTML = `<em>${selectedTime}</em>`;
            })
            .catch(error => {
                message = "Schedule Conflict: Time conflict";
                toastr.error(message);
            });
        }
    </script>
@endpush