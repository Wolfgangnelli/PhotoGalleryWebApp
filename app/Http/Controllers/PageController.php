<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    protected $data = [
        [
            'name' => 'Andrew',
            'lastname' => 'Nelli'

        ],
        [
            'name' => 'James',
            'lastname' => 'Bond'

        ],
        [
            'name' => 'Harry',
            'lastname' => 'Potter'

        ]
    ];

    public function about()
    {

        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function staff()
    {
        //modo 1
        /*    return view(
            'staff',
            [
                'title' => 'Our staff',
                'staff' => $this->data
            ]
        ); */

        //modo 2
        /* return view('staff')
            ->with('title', 'Our staff')
            ->with('staff', $this->data); */

        //modo 3
        /* return view('staff')
            ->withStaff($this->data)
            ->withTitle('Our staff'); */

        //modo 4    
        $staff = $this->data;
        $title = 'Our staff';
        return view('staffb', compact('title', 'staff'));
    }

}
