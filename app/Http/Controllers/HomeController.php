<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Home\HomeController as InnerHome;

// Lightweight wrapper so routes pointing to App\Http\Controllers\HomeController work in tests
class HomeController extends InnerHome {}
