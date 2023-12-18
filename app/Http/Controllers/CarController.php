<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $category_id = $request->category_id;
            $cars = Car::orderBy('id', "desc");
            if ($category_id) {
                $cars->where('category_id', $category_id);
            }
            $page = $request->input('page') ?: 1;
            $take = $request->input('count') ?: 20;
            $count = $cars->count();
            if ($page) {
                $skip = $take * ($page - 1);
                $cars = $cars->take($take)->skip($skip);
            } else {
                $cars = $cars->take($take)->skip(0);
            }
            return [
                'data' => $cars->with('category')->get(),
                'pagination' => [
                    'cars_pages' => ceil($count / $take),
                    'count' => $count
                ],
                'status' => true,
            ];
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false
            ], 500);
        }
    }

    /**
     * @param CarRequest $request
     * @return mixed
     */
    public function store(CarRequest $request)
    {
        $data = $request->validated();
        try {
            $car = Car::create($data);
            return response()->json([
                'data' => $car,
                'status' => true
            ], 201);
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
            $car = Car::findOrFail($id);
            $car->delete();
            return response()->json([
                'messages' => "Brand Deleted successfully!",
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
