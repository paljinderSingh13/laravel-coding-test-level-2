<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a User listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        $request['password'] =  Hash::make($request['password']);
        $user = User::create($request->all());
        return response()->json(['user' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json(['user' => $user], 200);
    }
/**
     * Update the specified idempotent resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function idempotent_update(Request $request, $id)
        {
            $user = User::findOrFail($id);

            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->save();

            return response()->json([
                'message' => 'User updated successfully',
                'data' => $user
            ], 200);
        }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        try {
            $this->validate($request, [
                'name' => 'required',
                'username' => 'required',
                'email' => 'required|unique:users,email,'.$user->id,

            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $user->update($request->all());
        return response()->json(['user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User delete successfully'], 204);
    }
}
