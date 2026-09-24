<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioController extends Controller
{
    public function index(): Response
    {
        $portfolios = Portfolio::all();

        return Inertia::render('Public/Portfolio', [
            'portfolios' => $portfolios,
        ]);
    }

    public function show(Portfolio $portfolio): Response
    {
        return Inertia::render('Public/PortfolioDetail', [
            'portfolio' => $portfolio,
        ]);
    }
}
