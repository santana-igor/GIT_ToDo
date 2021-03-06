<?php

namespace App\Http\Controllers;

use App\Models\ToDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = ToDo::all();
        return json_encode($todos);
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
        $user_auth = 1;

        $rules = [
            'title' => 'required | max:40',
            'description' => 'required',
            'status' => 'required',
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return json_encode($validate->errors());
        }

        try {
            $todo = new ToDo();
            $todo->title = $request->title;
            $todo->description = $request->description;
            $todo->status = $request->status;
            $todo->user_id = $user_auth;
            $todo->save();

            return json_encode(['status' => 'Criado com com sucesso!']);
        } catch (\PDOException $e) {
            return json_encode($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ToDo  $toDo
     * @return \Illuminate\Http\Response
     */
    public function show(ToDo $toDo, $id)
    {
        try {
            $todo = ToDo::find($id);
            if (!empty($todo)) {
                return json_encode($todo);
            } else {
                return json_encode(['status' => 'Not found!']);
            }
        } catch (\PDOException $e) {
            return json_encode($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ToDo  $toDo
     * @return \Illuminate\Http\Response
     */
    public function edit(ToDo $toDo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ToDo  $toDo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ToDo $toDo, $id)
    {
        $user_auth = 1;

        $todo = ToDo::find($id);

        if (empty($todo)) {
            return json_encode(['status' => 'Not found!']);
        }

        $rules = [
            'title' => 'required | max:40',
            'description' => 'required',
            'status' => 'required',
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return json_encode($validate->errors());
        }

        try {

            $todo->title = $request->title;
            $todo->description = $request->description;
            $todo->status = $request->status;
            $todo->user_id = $user_auth;
            $todo->save();

            return json_encode(['status' => 'Success']);
        } catch (\PDOException $e) {
            return json_encode($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ToDo  $toDo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToDo $toDo, $id)
    {

        try {
            $todo = ToDo::destroy($id);

            if ($todo == 1) {
                return json_encode(['status' => 'Success']);
            } else {
                return json_encode(['status' => 'Not found!']);
            }
        } catch (\PDOException $e) {
            return json_encode($e->getMessage());
        }
    }
}
