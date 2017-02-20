<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Teacher;
use App\Course;

class TeacherViewController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $middleware = ['auth.phoenix:teacher', 'teacher'];
        $this->middleware($middleware);
    }

    /**
     * 后台首页视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('teacher.index');
    }

    /**
     * 教师课程视图
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function course(Request $request)
    {
        $courses = $request->teacher->courses()->get();
        return view('teacher.course', compact('courses'));
    }

    /**
     * 课程信息视图
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function courseInfo(Request $request)
    {
        $course = $request->course;
        $lessons = $course->lessons()->orderBy('created_at', 'desc')->paginate(9);
        return view('teacher.courseInfo', compact('course', 'lessons'));
    }

    /**
     * 创建章节视图
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createLesson(Request $request)
    {
        $course = $request->course;
        return view('teacher.createLesson', compact('course'));
    }

    /**
     * 章节信息视图
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lessonInfo(Request $request)
    {
        $course = $request->course;
        $lesson = $request->lesson;
        return view('teacher.lessonInfo', compact('course', 'lesson'));
    }

    public function message(Request $request)
    {
        $teacher          = $request->teacher;
        $sentMessages     = $teacher->sentMessages()->with('studentReceiver')->latest()->paginate(5);
        $receivedMessages = $teacher->receivedMessages()->with('studentSender')->latest()->paginate(5);
        return view('teacher.message', compact('teacher', 'sentMessages', 'receivedMessages'));
    }

    /**
     * 站点设置视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setting()
    {
        return view('teacher.setting');
    }
}
