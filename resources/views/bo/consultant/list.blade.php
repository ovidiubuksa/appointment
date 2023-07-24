@extends('layouts.base')
@section('content')
@include('partials.includes')
@include('partials.admin.menu')

<div style="width: 75%; margin-top: 20px;">
    <table id="consultantList">
        <thead>
            <tr>
                <td>#ID</td>
                <td>Name</td>
                <td>Email</td>
                <td>Phone number</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($consultantList as $consultant)
            <tr>
                <td>{{$consultant->id}}</td>
                <td>{{$consultant->name}}</td>
                <td>{{$consultant->email}}</td>
                <td>{{$consultant->phone}}</td>
                <td>@include('partials.admin.actions',['zone'=>'consultant','idItem'=>$consultant->id])</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $('document').ready(function(){
        $("#consultantList").dataTable({
            "columnDefs": [
                { "searchable": false, "targets": [0,4] },
                { "orderable": false, "targets": [4] }
            ]
        });
    });
</script>
