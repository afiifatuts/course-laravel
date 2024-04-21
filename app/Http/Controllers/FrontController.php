<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionTransactionRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\SubscribeTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index(){
        $courses = Course::with(['category','teacher','students'])->orderByDesc('id')->get();
        return view('front.index',compact('courses'));
    }

    public function details(Course $course){
        
        return view('front.details',compact('course'));
    }

    public function category(Category $category){
        $courses = $category->courses()->get();
        return view('front.category',compact('courses'));
    }

    public function pricing(){
        $user = Auth::user();
        
        if($user->hasActiveSubscription()){
            return redirect()->route('front.index');
        }
        return view('front.pricing');
    }
    public function learning(Course $course, $courseVideoId){
        $user = Auth::user();

        if(!$user->hasActiveSubscription()){
            return redirect()->route('front.pricing');
        }
        $video = $course->course_videos->firstWhere('id',$courseVideoId);
        $user->courses()->syncWithoutDetaching($course->id);
        return view('front.learning',compact('course','video'));
    }

    public function checkout(){
        $user = Auth::user();
        
        if($user->hasActiveSubscription()){
            return redirect()->route('front.index');
        }
        return view('front.checkout');
    }

    public function checkout_store(StoreSubscriptionTransactionRequest $request){
        $user = Auth::user();
        
        if($user->hasActiveSubscription()){
            return redirect()->route('front.index');
        }

        
        DB::transaction(function () use($user, $request) {
            $validated = $request->validated();
        
            if($request->hasFile('proof')){
                $proofPath = $request->file('proof')->store('proof','public');
                $validated['proof']= $proofPath;
            }

            $validated['user_id']= $user->id;
            $validated['total_amount']= 429000;
            $validated['is_paid']= false;

            $transaction = SubscribeTransaction::create($validated);
        });

        return redirect()->route('dashboard');
    }
}
