<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', true)
            ->latest()
            ->get()
            ->map(function ($slider) {
                return [
                    'id' => $slider->id,
                    'image' => asset('storage/' . $slider->image),
                ];
            });

        return response()->json([
            'status' => true,
            'data' => $sliders,
        ]);
    }
}
