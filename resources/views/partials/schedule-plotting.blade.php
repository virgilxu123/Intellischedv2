<div class="row animated fadeIn">
    <div class="col-3">
        <div class="card " style="max-height: 90vh;overflow:auto;">
            <div class="card-header bg-dark text-light">
                <h5 class="card-title">Classes</h5>
                <div class="row">
                    <div class="col-6">
                        <label class="form-label" for="selectType">Type</label>
                        <select class="form-select form-select-sm" aria-label="Select Class Type" id="selectType">
                            <option value="all" selected>All</option>
                            <option value="lecture">Lectures</option>
                            <option value="laboratory">Laboratories</option>
                          </select>
                          
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="selectYrLvl">Year Level</label>
                        <select class="form-select form-select-sm" aria-label="Select Year Level" id="selectYrLvl">
                            <option value="all" selected>All</option>
                            <option value="First Year">First Year</option>
                            <option value="Second Year">Second Year</option>
                            <option value="Third Year">Third Year</option>
                            <option value="Fourth Year">Fourth Year</option>

                          </select>
                    </div>
                </div>
            </div>
            <div id="" class="card-body classesWithNoRoomAndTime">
                
            </div>
        </div>
    </div>
    <div class="col-9">
        <div class="card" style="overflow:auto;">
            <div class="card-header">
                <div class="row">

                    <div class="col-8">
                        <h5>S.Y. {{$academicYearTerm->academic_year->year_start}}-{{$academicYearTerm->academic_year->year_start + 1}} {{$academicYearTerm->term->term}}</h5>
    
                        <p id="scheduledDay" class="mb-0 d-inline-block"><i class="fa fa-chevron-left" style="font-size:x-small; cursor: pointer;"></i> {{$days[1]->day}}/{{$days[4]->day}} <i class="fa fa-chevron-right" style="font-size:x-small;cursor: pointer;"></i></p>
                    </div>
                    <div class="col-4">
                        <form action="" method="POST" target="__blank" id="export_plotted_schedule">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm float-end d-inline-block"><i class="fa-solid fa-file-excel"></i> Export Excel</button>
                        </form>
                    </div>
                </div>
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
                                @foreach ($rooms as $room) 
                                    <th scope="col" style="width: 150px;background: rgb(29, 29, 29);">{{$room->room_number}}</th>
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
                                <tr class="classesWithRoomAndTime">
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