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
        $services = cache()->remember('public.services.active', 3600, function () {
            return Service::active()->orderBy('sort_order')->limit(6)->get()->toArray();
        });

        $featuredPortfolios = cache()->remember('public.portfolios.featured', 3600, function () {
            return Portfolio::featured()->latest()->limit(6)->get()->toArray();
        });

        $testimonials = cache()->remember('public.testimonials.active', 3600, function () {
            return Testimonial::active()->limit(4)->get()->toArray();
        });

        return Inertia::render('Public/Home', [
            'services' => $services,
            'featuredPortfolios' => $featuredPortfolios,
            'testimonials' => $testimonials,
        ]);
    }

    public function about(): Response
    {
        return Inertia::render('Public/About');
    }
}
