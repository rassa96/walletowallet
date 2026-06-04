<?php

namespace App\Http\Controllers;

class SimpleVerificationController extends Controller
{
    public function showForm()
    {
        return "Verification page is working! User ID: " . auth()->id();
    }
}