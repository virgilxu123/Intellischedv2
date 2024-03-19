<div class="table-responsive" style="overflow-x:auto;height:80vh;">
    <table id="plotScheduleTable" class="table table-bordered" style="table-layout:fixed;width:100%;">
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