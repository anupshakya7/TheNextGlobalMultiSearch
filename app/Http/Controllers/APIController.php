<?php

namespace App\Http\Controllers;

use App\Country;
use App\Course;
use App\Institute;
use App\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    public function mainsearch(Request $request)
    {
        $select = 'courses.id as courseId, courses.name as courseName, institutes.name as instituteName, country.name as countryName,levels.name as levelName';
        $join = 'JOIN levels ON courses.level = levels.id JOIN course_institute ON courses.id = course_institute.course_id JOIN institutes ON course_institute.institute_id=institutes.id JOIN country ON institutes.country = country.id';
        $where = '';
        if(isset($request->country) && !empty($request->country)) {
            $where .= " AND country.id=".$request->country."";
        }
        if(isset($request->institute) && !empty($request->institute)) {
            $where .= " AND institutes.id=".$request->institute."";
        }
        if(isset($request->level) && !empty($request->level)) {
            $where .= " AND levels.id=".$request->level."";
        }
        if(isset($request->course) && !empty($request->course)) {
            $where .= " AND courses.id=".$request->course."";
        }
        $seach_results = DB::select('SELECT DISTINCT '.$select.' FROM courses '.$join.' WHERE 1 '.$where.'');

        if($seach_results) {
            return response()->json([
                'status' => 200,
                'search_result' => $seach_results
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'search_result' => "No Result Found"
            ]);
        }
    }
    public function all(Request $request)
    {
        $institutes_select = 'institutes.id as institutesId, institutes.name as institutesName';
        $courses_select = 'courses.id as courseId, courses.name as courseName';
        $level_select = 'levels.id as levelId,levels.name as levelName';
        $country_select = 'country.id as countryId,country.name as countryName';
        $join = 'JOIN levels ON courses.level = levels.id JOIN course_institute ON courses.id = course_institute.course_id JOIN institutes ON course_institute.institute_id=institutes.id JOIN country ON institutes.country = country.id';
        $where = '';
        if(isset($request->country) && !empty($request->country)) {
            $where .= " AND country.id=".$request->country."";
        }
        if(isset($request->institute) && !empty($request->institute)) {
            $where .= " AND institutes.id=".$request->institute."";
        }
        if(isset($request->level) && !empty($request->level)) {
            $where .= " AND levels.id=".$request->level."";
        }
        if(isset($request->course) && !empty($request->course)) {
            $where .= " AND courses.id=".$request->course."";
        }
        $institute_results = DB::select('SELECT DISTINCT '.$institutes_select.' FROM courses '.$join.' WHERE 1 '.$where.'');
        $course_results = DB::select('SELECT DISTINCT '.$courses_select.' FROM courses '.$join.' WHERE 1 '.$where.'');
        $level_results = DB::select('SELECT DISTINCT '.$level_select.' FROM courses '.$join.' WHERE 1 '.$where.'');
        $country_results = DB::select('SELECT DISTINCT '.$country_select.' FROM courses '.$join.' WHERE 1 '.$where.'');
        return response()->json([
            'status' => 200,
            'country' => $country_results,
            'institute' => $institute_results,
            'course' => $course_results,
            'study_level' => $level_results
        ]);
    }
    public function country($id)
    {
        $institute = Institute::with('course')->where('country', $id)->get();
        $finalArray = [];
        foreach ($institute as $institutes) {
            $instituteData = $institutes->toArray(); // Get the basic attributes

            // Flatten the "course" array
            $courses = [];
            foreach ($instituteData['course'] as $course) {
                $courses[] = $course;
            }

            $instituteData['course'] = $courses;

            $finalArray[] = $instituteData;
        }
        $allCourseArray = [];

        foreach ($finalArray as $item) {
            if (isset($item['course'])) {
                $allCourseArray = array_merge($allCourseArray, $item['course']);
            }
        }
        $course = array_values(array_map("unserialize", array_unique(array_map("serialize", $allCourseArray), SORT_REGULAR)));
        //$course = $this->uniqueArray($course,'name');

        $level = array();
        foreach($course as $key => $level_ids) {
            $levels = Level::where('id', $level_ids['level'])->get();
            $level[] = $levels;
        }
        $flattenedArray = collect($level)->flatten()->toArray();
        $study_level = array_values(array_map("unserialize", array_unique(array_unique(array_map("serialize", $flattenedArray), SORT_REGULAR))));

        return response()->json([
            'status' => 200,
            'institute' => $institute,
            'course' => $course,
            'study_level' => $study_level
        ]);
    }

    public function institute($id)
    {
        $institute = Institute::find($id);
        $country = Country::where('id', $institute->country)->get();
        $course_array = $institute->course->toArray();

        $course = $this->uniqueArray($course_array);
        $level_data = array();
        foreach($course as $courses) {
            $level_array = Level::find($courses['level']);
            $level_data[] = $level_array;
        }

        $level = $this->uniqueArray($level_data);


        return response()->json([
            'status' => 200,
            'country' => $country,
            'course' => $course,
            'study_level' => $level
        ]);
    }

    public function level($id)
    {
        $country_id = 1;

        $course = Course::with('institute')->where('level', $id)->get();
        dd($course);


        $institute_array = array();
        foreach($course as $courses) {
            $institute_array[] = $courses->institute;
        }

        $institute_collect = collect($institute_array)->flatten()->toArray();
        $institute = $this->uniqueArray($institute_collect);

        $country_array = array();
        foreach($institute as $institutes) {
            $countries = Country::find($institutes['country']);
            $country_array[] = $countries;
        }

        $country = $this->uniqueArray($country_array);

        return response()->json([
            'status' => 200,
            'country' => $country,
            'course' => $course,
            'institute' => $institute
        ]);

    }



    public function uniqueArray($array)
    {
        $unique_array = array_values(array_map("unserialize", array_unique(array_map("serialize", $array))));
        return $unique_array;
    }
}
