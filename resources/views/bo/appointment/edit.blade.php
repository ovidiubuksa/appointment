@extends('layouts.base')
@section('content')
@include('partials.includes')
@include('partials.admin.menu')

<script>
    $(document).ready(function(){
        $("#appointment_date").datepicker({
            firstDay: 1,
            minDate: new Date(),
            beforeShowDay: $.datepicker.noWeekends,
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

        $("#appointment_date").on("change", function() {
            loadHours($("#consultant").val(),$("#appointment_date").val());
        });

        $("#consultant").on("change", function() {
            if($("#appointment_date").val() != '') {
                loadHours($("#consultant").val(),$("#appointment_date").val());
            }
        });

        $("#appointment_start_hour").on("change", function() {
            console.log("dddd");
            if($("#appointment_date").val() != '') {
                $("#appointment_submit_button").removeAttr('disabled');
            }
        });

        function loadHours(consultant = "", date = "") {
            let valid = 1;
            if(consultant == "") {
                alert("Please select a consultant");
                $("#appointment_hours_row").hide();
                $("#appointment_submit_button").attr("disabled", true);
                valid = 0;
            }
            if(date != "" && valid == 1) {
                let url = "/employee/appointments/" + consultant + "/" + date;
                $.ajax({
                    url: url,
                    success: function (result) {
                            $("#appointment_hours").empty();
                            $("#appointment_hours").html(result);
                            $("#appointment_submit_button").removeAttr('disabled');
                        }
                });
            }
        }
    });
</script>
<form action="{{ route('new-appointment-register') }}" method="POST">
    @csrf
    <table>
        <tr>
            <td>Full name</td>
            <td><input disabled type="text" value="{{$client->name}}"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input disabled type="text" value="{{$client->email}}"></td>
        </tr>
        <tr>
            <td>Phone number</td>
            <td><input disabled type="text" value="{{$client->phone}}"></td>
        </tr>
        <tr>
            <td>Consultant</td>
            <td>
                <select required name="consultant" id="consultant" style="width: 100%;">
                    <option value="">Select a consultant</option>
                    @foreach ($consultants as $consultant)
                        <option value="{{ $consultant->id }}" @if($appointment->employee_id == $consultant->id) selected @endif>{{ $consultant->name }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>Appointment date</td>
            <td><input required name="appointment_date" id="appointment_date" type="text" value="{{date('Y-m-d',strtotime($appointment->start_time))}}"></td>
        </tr>
        <tr id="appointment_hours_row">
            <td>Appointment time</td>
            <td id="appointment_hours">
                @include('partials.hours', [
                    'hours'         =>  $hours,
                    'appointment'   =>  $appointment,
                    'busyHours'     =>  $busyHours
                ])
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"><input id="appointment_submit_button" type="submit" value="Save the appointment" disabled></td>
        </tr>
    </table>
</form>
