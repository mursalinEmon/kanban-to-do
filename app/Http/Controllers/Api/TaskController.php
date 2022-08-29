<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;
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
        return new TaskCollection(Task::all());
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
        // dd($request);
        $last_task_order = Task::latest()->get()[0];
        if($last_task_order){
            $order = $last_task_order->order + 1;
        }else{
            $order = 0;
        }
        $task = new Task();
        $task->created_by = $request->user_id ;
        $task->title = $request->title;
        $task->order = $order;
        $task->status = 1;
        $task->save();

        return response()->json(['status' => 'success', 'message'=>'Task Added Sucessfully']);

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
    public function update(Request $request)
    {

        $task = Task::where('id', $request->task_id)->first();
        $task->update([
            'user_id' => $request->user_id,
            'title' => $request->title
        ]);

        return response()->json(['status' => 'success', 'message'=>'Task Updated Sucessfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $task = Task::where('id', $request->task_id)->first();
        $task->delete();
        return response()->json(['status'=>'success', 'message'=>'Task Deleted Sucessfully']);
    }

    public function sync()
    {
        //
    }

    public function status_update(Request $request){

        $task = Task::where('id',$request->task_id)->first();

        if($task->status == 1){
            $task->status = 2;
        }elseif($task->status == 2){
            $task->status = 3;
        }else{
            $task->status = 1;
        }

        $task->save();

        return response()->json(['status' => 'success', 'message'=>'Task Updated Sucessfully']);
    }
    public function priority_update(Request $request){

        $task = Task::where('id',$request->task_id)->first();

        $priority = (int)$request->priority;
        $task->priority = $priority;
        $task->save();

        return response()->json(['status' => 'success', 'message'=>'Task Updated Sucessfully']);
    }
}
