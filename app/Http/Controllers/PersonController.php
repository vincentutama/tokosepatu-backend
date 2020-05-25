<?php

// DUMMY CONTROLLER TO GET USED TO LARAVEL





namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Person;

class PersonController extends Controller
{

    public function all()
    {
        return Person::all();
    }


    public function show($id)
    {
        return Person::find($id);
    }

    public function store(Request $request)
    {
        if($request->first_name && $request->last_name){
            return Person::create($request->all());
        }
        return '{"status": false, "message": "Error! Error! BIP BIP BUP BUP"}';
    }


    public function update($id, Request $request)
    {
        $person = Person::find($id);
        $person->update($request->all());
        return $person;
    }


    public function delete($id)
    {
        $person = Person::find($id);
        $person->delete();
        return 204;
    }
}