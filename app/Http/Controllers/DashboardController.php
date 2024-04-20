<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\SubscribeTransaction;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $coursesQuery = Course::query();

        if($user->hasRole('teacher')){
            $coursesQuery->whereHas('teacher',function($query) use ($user){
                $query->where('user_id',$user->id);
            });
            
            $students = CourseStudent::whereIn('course_id', $coursesQuery->select('id'))->distinct('user_id')->count('user_id');
        }else{
            $students = CourseStudent::distinct('user_id')->count('user_id');
        }

        $courses = $coursesQuery->count();
        $categories = Category::count();
        $transactions = SubscribeTransaction::count();
        $teachers = Teacher::count();

        return view('dashboard', compact('categories','courses','transactions','students','teachers'));
    }
}
