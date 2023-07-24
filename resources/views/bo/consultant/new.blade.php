@extends('layouts.base')
@section('content')
@include('partials.includes')
@include('partials.admin.menu')

<form action="{{ route('admin-consultant-new') }}" method="POST">
    @csrf
    <table>
        <tr>
            <td>Full name</td>
            <td><input required name="consultant_name" type="text"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input required name="consultant_email" type="text"></td>
        </tr>
        <tr>
            <td>Phone number</td>
            <td><input required name="consultant_phone" type="text"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"><input id="consultant_submit_button" type="submit" value="Save"></td>
        </tr>
    </table>
</form>

