<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patients;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController
{


    public function register(Request $request)
    {

        try {
            $fields = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string|confirmed',
                'dob' => 'required|date',
                'gender' => 'required|string',
                'address' => 'required|string',
                'role' => 'required|string|in:patient,doctor,admin',
                'phone' => 'required|string',
            ]);

            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password']),
                'role' => $fields['role'],
            ]);

            Patients::create([
                'user_id' => $user->id,
                'date_of_birth' => $fields['dob'],
                'gender' => $fields['gender'],
                'address' => $fields['address'],
                'phone' => $fields['phone'],
            ]);
            return response([
                "message" => "Successfully registered.",
            ], 201);


        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response([
                "message" => $e->getMessage(),
                1
            ], 500);
        }
    }
    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response([
            "message" => "Successfully logged in.",
            "data" => $response,
        ], 200);
    }


    public function index()
    {

    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response(["message" => "Logged out."], 200);
    }
}
