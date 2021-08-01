<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
class TodoController extends Controller
{
    public function create(Request $request)
    {
      $todo = new Todo();
      $todo->description = $request->description;
      $todo->status = 0;
      $todo->save();
      return redirect('/');
    }

    public function updateStatus(Request $request)
    {
      // return $request->id;
      $todo = Todo::where('id',$request->todo_id)->update(['status' => $request->status]);
      return redirect('/');
    }

    public function deleteTodo(Request $request)
    {
      $todo = Todo::where('id',$request->todo_id)->delete();
      return redirect('/');
    }

    public function deleteAllTodo()
    {
      Todo::truncate();
      return redirect('/');
    }
}
