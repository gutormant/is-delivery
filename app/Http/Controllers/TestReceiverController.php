<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class TestReceiverController extends Controller
{
    public function receive(): Response
    {
//        return response('Ok', 200);
        return response('Bad request', 400);
    }
}
