<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Appointment;

class FOController extends Controller
{
    public function new(Request $request): View
    {
        return view('fo.new', [
            'consultants'   =>  Employee::all(),
        ]);
    }

    public function registerNewAppointment(Request $request)
    {
        if($request->isMethod('post')) {
            // Search for the client by email
            $client = Client::firstOrNew([
                'email' => $request->input("client_email"),
            ]);
            $client->name = $request->input("client_name");
            $client->phone = $request->input("client_phone");
            $client->save();
            $consultant = Employee::find($request->input("consultant"));
            $appointment = new Appointment();
            $appointment->client_id = $client->id;
            $appointment->employee_id = $consultant->id;
            $appointment->start_time = \DateTime::createFromFormat('Y-m-d H:i', $request->input("appointment_date") . " " . $request->input("appointment_start_hour"));
            $appointment->finish_time = $appointment->start_time->add(new \DateInterval("PT1H"));
            $appointment->save();
            $message['message'] = "Appointment registered";
            $message['type'] = 'success';
        } else {
            $message['message'] = "Appointment not registered";
            $message['type'] = 'error';
        }

        return redirect()->route('new-appointment-form')->with($message['type'],$message['message']);
    }

    public function getConsultantAppointments(Request $request, int $consultant, string $date): View
    {
        $busyTimes = DB::select('select start_time from appointment where employee_id = '.$consultant.' and start_time like "'.$date.'%" and deleted_at IS NULL');
        foreach($busyTimes as $index => $busyTime) {
            $tempVar = new \DateTime($busyTime->start_time);
            $busyTimes[$index] = $tempVar->format('H:i');
        }
        return view('partials.hours', [
            'busyHours' =>  $busyTimes,
            'hours'     =>  Appointment::HOURS,
        ]);
    }
}
