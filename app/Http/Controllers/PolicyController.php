<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PolicyResource;
use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    // For the control panel list
    public function index() {
        return PolicyResource::collection(Policy::all());
    }
    // For the control panel edit page
    public function show(Policy $policy) {
        return new PolicyResource($policy);
    }
    // For the public website
    public function showBySlug(string $slug) {
        $policy = Policy::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return new PolicyResource($policy);
    }
    // To save edits from the control panel
    public function update(Request $request, Policy $policy) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'required|boolean',
        ]);
        $policy->update($validated);
        return new PolicyResource($policy);
    }
}
