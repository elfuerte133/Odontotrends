<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = User::doctors()->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'dni' => 'digits:8',
            'address' => 'min:5',
            'phone' => 'min:7'

        ];
        $this->validate($request, $rules);

        //asignación masiva
        User::create(
            $request->only('name', 'email', 'dni', 'address' ,'phone')
            + [
                'role' => 'doctor', 
                'password' => bcrypt($request->input('password'))
            ]
        );

        $notification = 'El médico se ha registrado exitosamente';
        return redirect('/doctors')->with(compact('notification'));
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
        $doctor = User::doctors()->findOrFail($id);
        return view('doctors.edit', compact('doctor'));
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
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'dni' => 'digits:8',
            'address' => 'min:5',
            'phone' => 'min:7'

        ];
        $this->validate($request, $rules);

        $user = User::doctors()->findOrFail($id);
        
        $data = $request->only('name', 'email', 'dni', 'address' ,'phone');
        $password = $request->input('password');
        if ($password)
            $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save(); //UPDATE

        $notification = 'La información del médico se ha actualizado exitosamente';
        return redirect('/doctors')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $doctor)
    {
        $doctorName = $doctor->name;
        $doctor->delete();

        $notification = "El médico $doctorName se ha eliminado correctamente";
        return redirect('/doctors')->with(compact('notification'));
    }
}
