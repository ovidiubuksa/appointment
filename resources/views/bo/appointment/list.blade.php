@extends('layouts.base')
@section('content')
@include('partials.includes')
@include('partials.admin.menu')

<div style="width: 75%; margin-top: 20px;">
    <table id="appointmentList">
        <thead>
            <tr>
                <td>#ID</td>
                <td>Client Name</td>
                <td>Client Email</td>
                <td>Client Phone number</td>
                <td>Consultant Name</td>
                <td>Consultant Email</td>
                <td>Consultant Phone number</td>
                <td>Appointment date</td>
                <td>Appointment start time</td>
                <td>Appointment finish time</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointmentList as $appointment)
            <tr>
                <td>{{$appointment->id}}</td>
                <td>{{$appointment->client->name}}</td>
                <td>{{$appointment->client->email}}</td>
                <td>{{$appointment->client->phone}}</td>
                <td>{{$appointment->employee->name}}</td>
                <td>{{$appointment->employee->email}}</td>
                <td>{{$appointment->employee->phone}}</td>
                <td>{{date('Y-m-d',strtotime($appointment->start_time))}}</td>
                <td>{{date('H:i',strtotime($appointment->start_time))}}</td>
                <td>{{date('H:i',strtotime($appointment->finish_time))}}</td>
                <td>@include('partials.admin.actions',['zone'=>'appointment','idItem'=>$appointment->id])</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $('document').ready(function(){
        $("#appointmentList").dataTable({
            "order": [[0,"desc"]],
            "columnDefs": [
                { "searchable": false, "targets": [0,10] },
                { "orderable": false, "targets": [10] }
            ]
        });
    });
</script>
