<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LandingPageResource;
use App\Models\LandingPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function show(Request $request, string $slug): JsonResponse
    {
        $landingPage = LandingPage::with([
            'announcement',
            'hero.statistics',
            'problem.items',
            'features.features',
            'packages.packages.features',
            'targetAudience.items',
            'socialProof.items',
            'whyUs.items',
            'howItWorks.steps',
            'comparison.items',
            'faq.items',
            'cta',
            'contact.items',
            'footer.linkGroups.links',
            'footer.socialLinks',
        ])->where('slug', $slug)->first();

        if (!$landingPage) {
            return response()->json(['error' => 'Landing page not found'], 404);
        }

        return response()->json((new LandingPageResource($landingPage))->resolve($request));
    }
}
