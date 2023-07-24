@extends('layouts.base')
@section('content')
@include('partials.includes')
@include('partials.admin.menu')

<div style="width: 75%; margin-top: 20px;">
    <table id="clientList">
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
            @foreach ($clientList as $client)
            <tr>
                <td>{{$client->id}}</td>
                <td>{{$client->name}}</td>
                <td>{{$client->email}}</td>
                <td>{{$client->phone}}</td>
                <td>@include('partials.admin.actions',['zone'=>'client','idItem'=>$client->id])</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $('document').ready(function(){
        $("#clientList").dataTable({
            "columnDefs": [
                { "searchable": false, "targets": [0,4] },
                { "orderable": false, "targets": [4] }
            ]
        });
    });
</script>
