<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BrandRequests\StoreBrandRequest;
use App\Http\Requests\V1\BrandRequests\UpdateBrandRequest;
use App\Http\Services\ImageService;
use App\Models\Admin\V1\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService){
        $this->imageService = $imageService;
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('admin.brand.index', [
            'brands' => Brand::latest()->paginate(10)
        ]);
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('admin.brand.create');
    }

    public function store(Request $request){
        $validated = $request->validate(StoreBrandRequest::rules());

        try {
            $brand = new Brand();
            $brand->fillAttributes($validated);

            if ($request->hasFile('image')) {
                $brand->image = $this->imageService->saveImage($request->file('image'), 'brands');
            }

            $brand->save();

            return redirect()->route('brand.index')->withSuccess('Brand created successfully.');
        } catch (\Exception $e) {
            Log::error('Brand creation failed: ' . $e->getMessage());
            return back()->withError('Failed to create brand. Please try again.');
        }
    }

    public function edit(Brand $brand): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Brand $brand, Request $request){

        $validated = $request->validate(UpdateBrandRequest::rules($brand));

        try {
            $brand->fillAttributes($validated);

            if ($request->hasFile('image')) {
                $brand->image = $this->imageService->saveImage($request->file('image'), 'brands');
            }

            $brand->save();

            return redirect()->route('brand.index')->withSuccess('Brand updated successfully.');

        } catch (\Exception $e) {
            Log::error('Brand update failed: ' . $e->getMessage());
            return back()->withError('Failed to update brand. Please try again.');
        }
    }

    public function destroy(Brand $brand){
        try {
            $brand->delete();
            $this->imageService->deleteImage($brand->image, 'brands');
            return redirect()->route('brand.index')->withSuccess('Brand deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Brand deletion failed: ' . $e->getMessage());
            return back()->withError('Failed to delete brand. Please try again.');
        }
    }

}
