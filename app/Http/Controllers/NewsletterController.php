<?php

namespace App\Http\Controllers;

use App\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    //
    public function subscribe(Request $request) {

        $found = Newsletter::where('email', $request->input('email'))->first();

        if ($found) {
            $request->session()->flash('newsletter', 'Diese Email-Adresse ist bereits registriert.');
            return redirect()->route('home');
        }

        $request->session()->flash('newsletter', 'Cool, du bist für den Newsletter registriert.');

        Newsletter::create([
            'email' => $request->input('email')
        ]);

        return redirect()->route('home');

    }

}
