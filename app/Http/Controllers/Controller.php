<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function create()
    {
        // Retrieve all users from the database
        $users = User::all();
        
        // Retrieve all mapel records from the database
        $mapel = Mapel::all();
        
        // Pass the $users and $mapel variables to the view
        return view('nilai.create', compact('users', 'mapel'));
    }
    
}
