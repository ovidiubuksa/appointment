@extends('layouts.base')
@section('content')
@include('partials.includes')
@include('partials.admin.menu')

<form action="{{ route('admin-consultant-edit',['id'=>$consultant->id]) }}" method="POST">
    @csrf
    <table>
        <tr>
            <td>Full name</td>
            <td><input required name="consultant_name" type="text" value="{{$consultant->name}}"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input required name="consultant_email" type="text" value="{{$consultant->email}}"></td>
        </tr>
        <tr>
            <td>Phone number</td>
            <td><input required name="consultant_phone" type="text" value="{{$consultant->phone}}"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"><input id="consultant_submit_button" type="submit" value="Save"></td>
        </tr>
    </table>
</form>


