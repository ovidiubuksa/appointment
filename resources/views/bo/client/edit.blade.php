@extends('layouts.base')
@section('content')
@include('partials.includes')
@include('partials.admin.menu')

<form action="{{ route('admin-client-edit',['id'=>$client->id]) }}" method="POST">
    @csrf
    <table>
        <tr>
            <td>Full name</td>
            <td><input required name="client_name" type="text" value="{{$client->name}}"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input required name="client_email" type="text" value="{{$client->email}}"></td>
        </tr>
        <tr>
            <td>Phone number</td>
            <td><input required name="client_phone" type="text" value="{{$client->phone}}"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"><input id="consultant_submit_button" type="submit" value="Save"></td>
        </tr>
    </table>
</form>
