<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\ZKLibrary;
use App\Attendance;
use App\Employee;
use Carbon\Carbon;

class DeviceAttendance {

}
class BiometricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function biometric(Request $request)
    {
     
        // $officeStarts = Carbon::createFromFormat('H:i:s', $company->office_start_time)->modify('+'. $company->late_mark_after .' minutes')->format('H:i:s');
        $zk = new ZKLibrary('103.111.224.132', 4370);
        $conncted = $zk->connect();
        $zk->disableDevice();
        $deviceAttendances = $zk->getAttendance();
        // dd($deviceAttendances);
        $zk->enableDevice();
        $zk->disconnect();
        // dd($conncted);
        $attendancesJSON = Array();
        foreach($deviceAttendances as $key => $deviceAttendance)
        {
            $attendanceJSON = new DeviceAttendance();
            $attendanceJSON->uid = $deviceAttendance[1];
            $attendanceJSON->state = $deviceAttendance[2];
            $attendanceJSON->time = Carbon::createFromFormat('Y-m-d H:i:s', $deviceAttendance[3]);
            $attendanceJSON->date = $attendanceJSON->time->toDateString();
            // $employee = Employee::where('employeeID', $attendanceJSON->uid)->first();
            $employee = User::where('id', $attendanceJSON->uid)->first();

            if ($employee->id == null) {
                continue;
            }
            //Checking if the attendance exists
            $dbAttendance = Attendance::where('date', $attendanceJSON->date)->where('user_id', $attendanceJSON->uid)->first();
            //If not existing add a new one.
            if ($dbAttendance == null) {
                $dbAttendance = new Attendance();
                $dbAttendance->user_id = $employee->id;
                // $dbAttendance->employee_device_id = $attendanceJSON->uid;
                $dbAttendance->date = $attendanceJSON->date;
                $dbAttendance->status = 'present';
                $time = Carbon::createFromFormat('H:i:s', $attendanceJSON->time->toTimeString());
                $dbAttendance->start_time = $time;
                // $timeDiff = $time->diffForHumans($officeStarts);
                // if (Str::contains($timeDiff, 'after')) {
                //     $dbAttendance->is_late = 1;
                // } else {
                //     $dbAttendance->is_late = 0;
                // }
                $dbAttendance->save();
            }
            else {
                $time = Carbon::createFromFormat('H:i:s', $attendanceJSON->time->toTimeString());
                $dbAttendance->end_time = $time;
                $dbAttendance->save();
            }
            array_push($attendancesJSON, $attendanceJSON);
        }

        $result = json_encode($attendancesJSON);

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}