<?php

namespace App\Http\Controllers;

use Validator;
use App\SmClass;
use App\SmStudent;
use App\ApiBaseMethod;
use App\SmFaculity;
use App\SmStudentAttendance;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class SmStudentAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }

    public function index(Request $request)
    {
        $classes = SmClass::where('active_status', 1)->get();
        $faculitys = SmFaculity::all();

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            return ApiBaseMethod::sendResponse($classes, null);
            return ApiBaseMethod::sendResponse($faculitys, null);
        }
        return view('backEnd.studentInformation.student_attendance', compact('classes','faculitys'));
    }

    public function studentSearch(Request $request)
    {
        // dd($request->all());
        $input = $request->all();
        $validator = Validator::make($input, [
            'faculity_id' => "required",
            'class' => 'required',
            'section' => 'required',
            'attendance_date' => 'required'
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $date = $request->attendance_date;
        $classes = SmClass::where('active_status', 1)->get();
        $faculitys = SmFaculity::all();




        $students = SmStudent::where('class_id', $request->class)->where('section_id', $request->section)->where('faculity_id',$request->faculity_id)->get();

        if ($students->isEmpty()) {
            Toastr::error('No Result Found', 'Failed');
            return redirect()->back();
        }

        $already_assigned_students = [];
        $new_students = [];
        $attendance_type = "";
        foreach ($students as $student) {
            $attendance = SmStudentAttendance::where('student_id', $student->id)->where('attendance_date', date('Y-m-d', strtotime($request->attendance_date)))->first();
            if ($attendance != "") {
                $already_assigned_students[] = $attendance;
                $attendance_type =  $attendance->attendance_type;
            } else {
                $new_students[] =  $student;
            }
        }

        $class_id = $request->class;
        $faculity_id = $request->faculity_id;

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            $data = [];
            $data['classes'] = $classes->toArray();
            $data['faculitys'] = $faculitys->toArray();
            $data['date'] = $date;
            $data['class_id'] = $class_id;
            $data['faculity_id'] = $faculity_id;
            $data['already_assigned_students'] = $already_assigned_students;
            $data['new_students'] = $new_students;
            $data['attendance_type'] = $attendance_type;
            return ApiBaseMethod::sendResponse($data, null);
        }
        return view('backEnd.studentInformation.student_attendance', compact('classes', 'date', 'class_id', 'faculity_id', 'date', 'already_assigned_students', 'new_students', 'attendance_type','faculitys'));
    }

    // public function studentAttendanceStore(Request $request)
    // {

    //     foreach ($request->id as $student) {
    //         $attendance = SmStudentAttendance::where('student_id', $student)->where('attendance_date', date('Y-m-d', strtotime($request->date)))->first();
    //         // dd($attendance);






    //         if ($attendance) {
    //             $attendanceTypes = $attendance->attendance_type ?? [];

    //             if (is_string($attendanceTypes)) {
    //                 $attendanceTypes = json_decode($attendanceTypes, true) ?? [];
    //             }

    //             $attendance->attendance_type = $request->attendance_type;


    //             $attendance->update([
    //                 'attendance_type' => $attendanceTypes,
    //                  'notes' => $request->note,
    //             ]);
    //         }












    //         if ($attendance != "") {
    //             $attendance->delete();
    //         }

    //         $attendance = new SmStudentAttendance();
    //         $attendance->student_id = $student;
    //         if (isset($request->mark_holiday)) {
    //             $attendance->attendance_type = "H";
    //         } else {
    //             $attendance->attendance_type = $request->attendance[$student];
    //             $attendance->notes = $request->note[$student];
    //         }
    //         $attendance->attendance_date = date('Y-m-d', strtotime($request->date));
    //         $attendance->save();
    //     }

    //     if (ApiBaseMethod::checkUrl($request->fullUrl())) {
    //         return ApiBaseMethod::sendResponse(null, 'Student attendance been submitted successfully');
    //     }
    //     Toastr::success('Operation successful', 'Success');
    //     return redirect('student-attendance');
    // }
    public function studentAttendanceStore(Request $request)
    {
        dd($request->all());
        foreach ($request->id as $student) {
            // Retrieve existing attendance record
            $attendance = SmStudentAttendance::where('student_id', $student)
                ->where('attendance_date', date('Y-m-d', strtotime($request->date)))
                ->first();
    
            if ($attendance) {
                // Decode existing JSON array
                $attendanceTypes = json_decode($attendance->attendance_type, true) ?? [];
    
                // Add new attendance type to the array if it exists in the request
                if (isset($request->attendance[$student])) {
                    $attendanceTypes[] = $request->attendance[$student];
                }
    
                $attendance->update([
                    'attendance_type' => json_encode($attendanceTypes),
                    'notes' => $request->note[$student] ?? $attendance->notes,
                ]);
            } else {
                // Create new attendance record
                $attendance = new SmStudentAttendance();
                $attendance->student_id = $student;
                if (isset($request->mark_holiday)) {
                    $attendance->attendance_type = json_encode(['H']);
                } else {
                    if (isset($request->attendance[$student])) {
                        $attendance->attendance_type = json_encode([$request->attendance[$student]]);
                    } else {
                        // Handle the case where attendance type is not set
                        $attendance->attendance_type = json_encode([]);
                    }
                    $attendance->notes = $request->note[$student] ?? '';
                }
                $attendance->attendance_date = date('Y-m-d', strtotime($request->date));
                $attendance->save();
            }
        }
    
        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            return ApiBaseMethod::sendResponse(null, 'Student attendance has been submitted successfully');
        }
        Toastr::success('Operation successful', 'Success');
        return redirect()->back();
    }
    


    public function studentAttendanceHoliday(Request $request)
    {
        dd($request->all());
    }
}
