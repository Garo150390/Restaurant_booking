<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seat;
use Validator;


class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->offset) and isset($request->limit)) {


            $seats = Seat::skip($request->input('offset'))->take($request->input('limit'))->get();
            if ($seats->isEmpty()) {
                $not_exist = collect(['Seat' => ['Seat table data not exist.']]);
                return response()->json([
                    'success' => false,
                    'message' => 'Error',
                    'data' => [],
                    'errors' => $not_exist
                ],200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Seat table all data.',
                'data' => $seats,
                'errors' => false
            ],200);

        } else {
            $not_specified = collect(['Seat' => ['Order is not specified.']]);
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'data' => [],
                'errors' => $not_specified
            ],404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|numeric',
            'total' => 'required|numeric',
            'name' => 'required',
            'price' => 'required',

        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'data' => [],
                'errors' => $validator->errors()
            ],401);
        }

        $seat = Seat::create($request->all());
        if ($seat) {
            return response()->json([
                'success' => true,
                'message' => 'Created a new seat.',
                'data' => $seat,
                'errors' => false
            ],201);
        } else {
            $not_created = collect(['Seat' => ['Seat is not created.']]);
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'data' => [],
                'errors' => $not_created
            ],404);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seat = Seat::find($id);
        if ($seat == null) {

            $not_found = collect(['Seat' => ['Data not found or not exist.']]);
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'data' => [],
                'errors' => $not_found
            ],404);
        }

        //if we need seat data wrapped into array
        //$seat = collect([$seat]);
        return response()->json([
            'success' => true,
            'message' => 'Single seat data.',
            'data' => $seat,
            'errors' => false
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $seat = Seat::find($id);
        if ($seat == null) {
            $not_found = collect(['Seat' => ['Data not found or not exist.']]);
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'data' => [],
                'errors' => $not_found
            ],404);
        }

        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|numeric',
            'total' => 'required|numeric',
            'name' => 'required',
            'price' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'data' => [],
                'errors' => $validator->errors()
            ],401);
        }

        $seat->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Seat data updated.',
            'data' => $seat,
            'errors' => false
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $seat = Seat::find($id);
        if ($seat == null) {
            $not_found = collect(['Seat' => ['Data not found or not exist.']]);
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'data' => [],
                'errors' => $not_found
            ],404);
        }

        $seat->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted seat data.',
            'data' => $seat,
            'errors' => false
        ],204);
    }
}
