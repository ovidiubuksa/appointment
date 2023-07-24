<select required name="appointment_start_hour" id="appointment_start_hour" style="width: 100%">
    <option value="">Select a hour</option>
    @foreach ($hours as $hour)
        <option value="{{ $hour }}"  @if(in_array($hour,$busyHours)) disabled @endif
        @isset($appointment)
            @if(date('H:i',strtotime($appointment->start_time)) == $hour)
            selected
            @endif
        @endisset
        >{{ $hour }}</option>
    @endforeach
</select>

