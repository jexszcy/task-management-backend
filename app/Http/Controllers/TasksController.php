<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TasksController extends Controller
{
    public function index(Request $request){

        if($request->isMethod('post')){
            $data = $request->validate([
                'title' => ['required', 'string', 'max:20'],
                'description' => ['nullable', 'string', "max:255"],
            ]);

            try {
                DB::beginTransaction();
                $user = $request->user()->tasks()->create($data);
                DB::commit();
                return response()->json([
                    'message' => "Task has been created.",
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                return response()->json([
                    'message' => 'Failed to update tasks. please try again.',
                ], 500);
            }
        }

        return response()->json($request->user()->tasks()->get(), 200);

    }

    public function complete(Task $task, Request $request){
        if($request->isMethod("patch")){
            // Ensure the task belongs to the authenticated user
            if ($task->user_id !== $request->user()->id) {
                abort(403, "Unauthorized action.");
            }
            $data = $request->validate([
                'is_complete' => ['required', "boolean"],
            ]);
            try {
                DB::beginTransaction();
                $task->update([
                    "is_completed" => $data["is_complete"],
                ]);
                DB::commit();
                return response()->json([
                    'message' => "Task has been mark as ".($data["is_complete"] ? "completed" : "pending").".",
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                return response()->json([
                    'message' => 'Failed to delete task, please try again.',
                ], 500);
            }
        }
    }

    public function delete(Task $task, Request $request){
        if($request->isMethod("delete")){
            // Ensure the task belongs to the authenticated user
            if ($task->user_id !== $request->user()->id) {
                abort(403, "Unauthorized action.");
            }

            try {
                DB::beginTransaction();
                $task->delete();
                DB::commit();
                return response()->json([
                    'message' => "Task has been deleted.",
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                return response()->json([
                    'message' => 'Failed to delete task, please try again.',
                ], 500);
            }
        }
    }
}
