<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioSectionResource;
use App\Models\PortfolioSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function all(Request $request): JsonResponse
    {
        $sections = PortfolioSection::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->mapWithKeys(fn (PortfolioSection $section) => [
                $section->module => (new PortfolioSectionResource($section))->resolve($request),
            ]);

        return response()->json($sections);
    }

    public function index(Request $request, string $module): JsonResponse
    {
        abort_unless(isset(PortfolioSectionResource::modules()[$module]), 404);

        $section = PortfolioSection::query()
            ->where('module', $module)
            ->where('is_active', true)
            ->first();

        abort_unless($section, 404);

        return response()->json((new PortfolioSectionResource($section))->resolve($request));
    }
}
