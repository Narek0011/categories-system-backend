<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $brands = Brand::orderBy('id', "desc");
            $page = $request->input('page') ?: 1;
            $take = $request->input('count') ?: 20;
            $count = $brands->count();
            if ($page) {
                $skip = $take * ($page - 1);
                $brands = $brands->take($take)->skip($skip);
            } else {
                $brands = $brands->take($take)->skip(0);
            }
            return [
                'data' => $brands->get(),
                'pagination' => [
                    'category_pages' => ceil($count / $take),
                    'count' => $count,
                ],
                'status' => true
            ];
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false
            ], 500);
        }
    }

    /**
     * @param BrandRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BrandRequest $request)
    {
        $data = $request->validated();
        try {
            $model = Brand::create([
                'name' => $data['name'],
                'category_id' => $data['category_id'],
            ]);
            return response()->json([
                "data" => $model,
                'status' => true
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false
            ], 500);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->delete();
            return response()->json([
                'messages' => "Brand Deleted successfully!",
                'status' => true,
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false
            ], 500);
        }
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->update(['name' => $request->name]);
            return $brand;
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBrandsByCategory(Request $request,$id)
    {
        try{
            $brands = Brand::where('category_id',$id)->get();
            return response()->json([
                "data" => $brands,
                'status' => true
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false
            ], 500);
        }
    }
}
