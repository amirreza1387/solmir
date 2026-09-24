<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        $services = Service::active()->orderBy('sort_order')->get();

        return Inertia::render('Public/Services', [
            'services' => $services,
        ]);
    }

    public function show(Service $service): Response
    {
        return Inertia::render('Public/ServiceDetail', [
            'service' => $service,
        ]);
    }
}
