<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use App\Transformer\LessonTransformer;

class LessonController extends ApiController
{


    protected $lessonTransformer;

    public function __construct(LessonTransformer $lessonTransformer)
    {
        $this->lessonTransformer = $lessonTransformer;
        $this->middleware('auth.basic', ['only' => ['store', 'update']]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @node_name api/v4/lesson
     * @link
     * @desc
     */
    public function index()
    {
        $lessons = Lesson::all();
        return $this->response([
            'status' => 'success',
            'code'   => $this->getStatusCode(),
            'data'   => $this->lessonTransformer->transformCollection($lessons->toArray())
        ]);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @node_name api/v4/lesson/{lesson} api/v4/lesson/3
     * Todo 当资源不存在时候返回404 text/html,应该返回json
     * @link
     * @desc
     */
    public function show($id)
    {
        try {
            $lesson = Lesson::findOrFail($id);
        } catch (\Exception $e) {
            $lesson = null;
        }

        if (!$lesson) {
            return $this->setStatusCode(404)->responseNotFound();
        }

        return $this->response([
            'status' => 'success',
            'code'   => 200,
            'data'   => $this->lessonTransformer->transform($lesson)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @node_name api/v4/lesson post
     * @link
     * @desc
     */
    public function store(Request $request)
    {
        if (!$request->get('title') or !$request->get('body')) {
            return $this->setStatusCode(422)->responseError('validate fails');
        }
        Lesson::create($request->all());
        return $this->setStatusCode(201)->response([
            'status'  => 'success',
            'message' => 'lesson created'
        ]);
    }


}
