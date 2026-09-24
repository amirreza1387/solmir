<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Public/Home', [
            'services' => Service::active()->orderBy('sort_order')->limit(6)->get(),
            'featuredPortfolios' => Portfolio::featured()->latest()->limit(6)->get(),
            'testimonials' => Testimonial::active()->limit(4)->get(),
        ]);
    }

    public function about(): Response
    {
        return Inertia::render('Public/About');
    }
}
