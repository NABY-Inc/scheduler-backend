<?php

namespace App\Http\Controllers;

use App\Model\Lecturer;
use Illuminate\Http\Request;
use App\Model\LecturerCourse;

class lecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Lecturer::orderBy('id','desc')->with('department','lecturerCourses.course',)->get();
        return $data;
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
        $data = $this->validator($request); // Validating incoming required fields

        if ($request->hasFile('profile')) {
            $request->validate(['profile' => 'Image|mimes:png,jpeg,jpg|max:3000']);
            $fileNameToStore = time(). '.' .$request->file('profile')->getClientOriginalExtension();
            $request->file('profile')->move(public_path('uploads/lecturers'), $fileNameToStore); // Saving image into directory
            // Appending Img to data
            $data = $this->array_push_assoc($data,'profile',$fileNameToStore);
        }

        $lecturer = Lecturer::create($data);
        $courses = array_map('intval', explode(',', $request->courses));

        // Looping through courses to store
        foreach ($courses as $course) {
            LecturerCourse::create(['lecturer_id' => $lecturer->id, 'course_id' => $course]);
        }

        return $this->index();
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
        $data = $this->validator($request); // Validating incoming required fields

        if ($request->hasFile('profile')) { // Checking if profile is in request
            $request->validate(['profile' => 'Image|mimes:png,jpeg,jpg|max:3000']);
            $fileNameToStore = time(). '.' .$request->file('profile')->getClientOriginalExtension();
            if ($request->oldProfile != 'default.jpg') { // Deleting old profile if not default
                \File::delete(public_path('uploads/lecturers/'.$request->oldProfile));
            }
            $request->file('profile')->move(public_path('uploads/lecturers'), $fileNameToStore); // Saving image into directory
            // Appending Img to data
            $data = $this->array_push_assoc($data,'profile',$fileNameToStore);
        }

        $lecturer = Lecturer::findOrFail($id)->update($data); // Updating lecturer details

        $this->updateLecturerCourse($id,$request); // Updating the lecturer course
        
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lecturer::findOrFail($id)->delete();
        LecturerCourse::where('lecturer_id',$id)->delete();
        return $this->index();
    }

    // Updating Lecturer Course
    public function updateLecturerCourse($id,$request)
    {
        // Get previous Courses for this lecturer
        $lecturerCourses = LecturerCourse::where('lecturer_id',$id)->get();

        $oldCourses = []; // Array to hol old courses
        for ($i=0; $i < count($lecturerCourses); $i++) { 
            array_push($oldCourses,$lecturerCourses[$i]->course_id);
        }
        $newCourses = explode(',',$request->courses); // Converting request courses into array
        $difference = count($newCourses) > count($oldCourses) ? array_diff($newCourses,$oldCourses) : array_diff($oldCourses,$newCourses);
        if (count($difference) > 0) {   // If there is a difference
            $differenceIds = []; // Array to store the difference IDs
            foreach ($difference as $ids) {
                array_push($differenceIds,$ids); // Storing IDs into the array
            }
            for ($i=0; $i < count($differenceIds); $i++) { // We loop and get the courses
                $courses = LecturerCourse::where(['lecturer_id' => $id, 'course_id' => $differenceIds[$i]])->get();
                if (count($courses) > 0) { // If course is in already, means it has been removed so we delete
                    LecturerCourse::where(['lecturer_id'=>$id,'course_id' => $differenceIds[$i]])->delete();
                }else{ // If course dont exist we create 
                    LecturerCourse::create(['lecturer_id'=>$id,'course_id' => $differenceIds[$i]]);
                }
            }
        }
    }

    // Custom function to add default password
    public function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }

    // Validating field dat
    public function validator($request)
    {
        $data = $request->validate([
            'department_id' =>  'required',
            'code'          =>  'required',
            'name'          =>  'required',
            'status'        =>  'required',
        ]);
        return $data;
    }
}
