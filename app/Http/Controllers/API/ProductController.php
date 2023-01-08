<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::get();

        if ($product) {
            // response if success
            return ResponseFormatter::success(
                $product,
                'Get Data Product Successfully!'
            );
        } else {
            // response if error
            return ResponseFormatter::error(
                null,
                'Data Product Not Found!',
                404
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // validation input
            $validator = Validator::make( $request->all(),[
                'code' => 'required|max:255',
                'name' => 'required|max:255',
                'quantity' => 'required|integer|digits_between:1,11',
            ]);

            // validation errors
            if ($validator->fails()) {
                return ResponseFormatter::error(
                    ['error' => $validator->errors()], 
                    'Validation Error!', 
                    401
                );    
            }

            // save data
            $product = Product::create([
                'code' => $request->code,
                'name' => $request->name,
                'quantity' => $request->quantity,
            ]);

            // if success save data
            if ($product) {
                return ResponseFormatter::success(
                    $product,
                    'Data Created Successfully!'
                );
            }
            
        } catch (Exception $error) {
            // if error
            return ResponseFormatter::error([
                'message' => 'Something went Wrong!',
                'error' => $error
            ], 'Authentication Failed!', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // validation input
            $validator = Validator::make( $request->all(),[
                'code' => 'required|max:255',
                'name' => 'required|max:255',
                'quantity' => 'required|integer|digits_between:1,11',
            ]);

            // validation errors
            if ($validator->fails()) {
                return ResponseFormatter::error(
                    ['error' => $validator->errors()], 
                    'Validation Error!',
                    401
                );    
            }
            
            // find data by id
            $item = Product::findOrFail($id);
            
            // set data value
            $data['code'] = $request->code;
            $data['name'] = $request->name;
            $data['quantity'] = $request->quantity;
            
            // save data
            $item->update($data);

            // if success save data
            if ($item) {
                return ResponseFormatter::success(
                    $item,
                    'Data Update Successfully!'
                );
            }

        } catch (Exception $error) {
            // if error
            return ResponseFormatter::error([
                'message' => 'Something went Wrong!',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // find data by id
            $item = Product::find($id);

            // deleted
            $item->delete();

            // if response success
            if ($item) {
                return ResponseFormatter::success(
                    'Data Deleted Successfully',
                    'Data Deleted Successfully!'
                );
            }
        } catch (Exception $error) {
            // if error success
            return ResponseFormatter::error([
                'message' => 'Something went Wrong!',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }
}
