<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if($request->hasFile('picture') && $request->file('picture')->isValid())
        {
            $picture = request()->file('picture');
            $picName = str_random(32).'.'.$picture->getClientOriginalExtension();
            $picture->storeAs('',$picName,'public');

            $user->image = $picName;
        }
        else {
            $user->image = 'userDefault.png';
        }

        $user->save();

        return response('Ok',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function validateEmail(Request $request)
    {
        $user = User::where('email','=',$request->value)->first();
        if($user)
        {
            $response = array(
                'isValid' => false,
                'value' => 'taken'
            );
            return response()->json($response);
        }
        else {
            $response = array(
                'isValid' => true,
                'value' => 'available'
            );
            return response()->json($response);
        }
    }
}
