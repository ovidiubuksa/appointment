<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Appointment;

class BOController extends Controller
{
    public function index()
    {
        return view('bo.main');
    }

    public function clientList(Request $request): View
    {
        return view('bo.client.list', [
            'clientList'    =>  Client::all(),
        ]);
    }

    public function consultantList(Request $request): View
    {
        return view('bo.consultant.list', [
            'consultantList'    =>  Employee::all(),
        ]);
    }

    public function appointmentList(Request $request): View
    {
        $appointments = DB::table('appointment')->whereNull('deleted_at')->orderBy('id','desc')->get();
        foreach($appointments as $index => $appointment) {
            $client = Client::find($appointment->client_id);
            $consultant = Employee::find($appointment->employee_id);
            $appointments[$index]->client = $client;
            $appointments[$index]->employee = $consultant;
        }
        return view('bo.appointment.list', [
            'appointmentList'    =>  $appointments,
        ]);
    }

    public function clientDelete(Request $request, int $id)
    {
        DB::table('client')->where('id',$id)->update(['deleted_at' => new \DateTime()]);

        DB::table('appointment')->where('client_id',$id)->update(['deleted_at' => new \DateTime()]);

        return redirect()->route('admin-clients-list');
    }

    public function consultantDelete(Request $request, int $id)
    {
        DB::table('employee')->where('id',$id)->update(['deleted_at' => new \DateTime()]);

        DB::table('appointment')->where('employee_id',$id)->update(['deleted_at' => new \DateTime()]);

        return redirect()->route('admin-consultants-list');
    }

    public function appointmentDelete(Request $request, int $id)
    {
        DB::table('appointment')->where('id',$id)->update(['deleted_at' => new \DateTime()]);

        return redirect()->route('admin-appointments-list');
    }

    public function clientEdit(Request $request, int $id)
    {
        if($request->isMethod('post')) {
            return redirect()->route('admin-clients-list');
        }

        return view('bo.client.edit',['client'=>$client]);
    }

    public function consultantEdit(Request $request, int $id)
    {
        if($request->isMethod('post')) {
            return redirect()->route('admin-consultants-list');
        }

        return view('bo.consultant.edit',['consultant'=>$employee]);
    }

    public function appointmentEdit(Request $request, int $id)
    {
        $appointment = DB::table('appointment')->where('id', $id)->first();
        $appointmentDate = date('Y-m-d', strtotime($appointment->start_time));
        $busyTimes = DB::select('select start_time from appointment where employee_id = '.$appointment->employee_id.' and start_time like "'.$appointmentDate.'%" and deleted_at IS NULL');
        foreach($busyTimes as $index => $busyTime) {
            $tempVar = new \DateTime($busyTime->start_time);
            $busyTimes[$index] = $tempVar->format('H:i');
        }

        if($request->isMethod('post')) {
            $consultant = Employee::find($request->input("consultant"));
            $start_time = \DateTime::createFromFormat('Y-m-d H:i', $request->input("appointment_date") . " " . $request->input("appointment_start_hour"));
            $finish_time = $start_time->add(new \DateInterval("PT1H"));
            DB::table('appointment')->where('employee_id',$id)->update([
                'employee_id'   =>  $consultant->id,
                'start_time'    =>  $start_time,
                'finish_time'   =>  $finish_time
            ]);

            return redirect()->route('admin-appointments-list');
        }

        return view('bo.appointment.edit',[
            'busyHours'     =>  $busyTimes,
            'hours'         =>  Appointment::HOURS,
            'appointment'   =>  $appointment,
            'consultants'   =>  Employee::all(),
            'client'        =>  DB::table('client')->where('id', $appointment->client_id)->first()
        ]);
    }
}
