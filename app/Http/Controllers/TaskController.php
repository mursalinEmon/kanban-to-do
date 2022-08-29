<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::all();
        $all_tasks = Task::orderBy('updated_at', 'DESC')->orderBy('priority', 'DESC')->get();
        // dd($statuses);
        return view('tasks.index', compact('statuses','all_tasks'));
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
        $newTask = $request->newTask;

        $task = new Task();
        $userId = Auth::id();
        $task->created_by = $userId ;
        $task->title = $newTask['title'];
        $task->status = 1;
        $task->save();

        return response()->json(['status' => 'success', 'task'=> $task, 'message'=>'Task Added Sucessfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $task->update([
            'title' => $request->editTask['title']
        ]);

        $all_tasks = Task::orderBy('updated_at', 'DESC')->orderBy('priority', 'DESC')->get();
        return response()->json(['status' => 'success', 'tasks'=> $all_tasks, 'message'=>'Task Updated Sucessfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['status'=>'success', 'message'=>'Task Deleted Sucessfully']);
    }

    public function sync()
    {
        //
    }

    public function status_update(Request $request){

        $task = Task::where('id',$request->task['id'])->first();

        if($task->status == 1){
            $task->status = 2;
        }elseif($task->status == 2){
            $task->status = 3;
        }else{
            $task->status = 1;
        }

        $task->save();

        $all_tasks = Task::orderBy('updated_at', 'DESC')->orderBy('priority', 'DESC')->get();
        return response()->json(['status' => 'success', 'tasks'=> $all_tasks, 'message'=>'Task Updated Sucessfully']);
    }
    public function priority_update(Request $request){

        $priority_task = $request->priorityTask;
        $task = Task::where('id',$priority_task['id'])->first();

        $priority = (int)$priority_task['prioritySelect'];
        $task->priority = $priority;
        $task->save();

        $all_tasks = Task::orderBy('updated_at', 'DESC')->orderBy('priority', 'DESC')->get();
        return response()->json(['status' => 'success', 'tasks'=> $all_tasks, 'message'=>'Task Updated Sucessfully']);
    }
}
