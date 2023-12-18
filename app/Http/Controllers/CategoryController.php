<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try {
            $categories = Category::orderBy('id', "desc");
            $page = $request->input('page') ?: 1;
            $take = $request->input('count') ?: 20;
            $count = $categories->count();
            if ($page) {
                $skip = $take * ($page - 1);
                $categories = $categories->take($take)->skip($skip);
            } else {
                $categories = $categories->take($take)->skip(0);
            }
            return [
                'data' => $categories->get(),
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
     * Show the form for creating a new resource.
     *
     * @param BrandRequest $request
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $category = Category::create($data);
            return response()->json([
                'data' => $category,
                'status' => true,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false
            ], 500);
        }
    }

    /**
     * @param BrandRequest $request
     * @param $id
     * @return BrandResource
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update(['name' => $request->name]);
            return response()->json([
                'data' => $category,
                'status' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false
            ], 500);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json([
                'message' => "Category Deleted successfully!",
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false
            ], 500);
        }
    }

    /**
     * @return JsonResponse
     */
    public function getAllCategories()
    {
        try {
            $categories = Category::all();
            return response()->json([
                'data' => $categories,
                'status' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false
            ], 500);
        }
    }
}
