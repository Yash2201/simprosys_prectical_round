<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Validator;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{

    protected $response;
    public function __construct() {
        $this->response = [
            'status' => 200,
            'success' => true,
            'message' => '',
            'data' => '',
            'error' => '',
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            $this->response['status'] = 401;
            $this->response['success'] = false;
            $this->response['message'] = 'Validation Errors';
            $this->response['error'] = $validator->messages();
        } else {
            try {
                $product = Product::create([
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'price' => $request->price,
                    'status' => $request->status,
                ]);
    
                if($product){
                    $this->response['status'] = 201;
                    $this->response['message'] = 'Product Saved Successfully';
                } else {
                    $this->response['status'] = 500;
                    $this->response['success'] = false;
                    $this->response['error'] = 'Something Went Wroung';
                }
    
    
            } catch (\Throwable $th) {
                $this->response['status'] = 500;
                $this->response['success'] = false;
                $this->response['message'] = 'Something Went Wroung';
                $this->response['error'] = $th;
            }
        }

        $JsonData = json_encode($this->response);
        return response()->json(Crypt::encryptString($JsonData));
    }

    /**
     * Liting The Products.
     */
    public function product_list()
    {
        try {
            $product =  Product::Select('id','title','description','price','status')->get();

            if($product){
                $this->response['message'] = 'Product Fetch Successfully';
                $this->response['data'] = $product;
            } else {
                $this->response['status'] = 500;
                $this->response['success'] = false;
                $this->response['error'] = 'Something Went Wroung';
            }


        } catch (\Throwable $th) {
            $this->response['status'] = 500;
            $this->response['success'] = false;
            $this->response['message'] = 'Something Went Wroung';
            $this->response['error'] = $th;
        }

        $JsonData = json_encode($this->response);
        return response()->json(Crypt::encryptString($JsonData));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $this->response['status'] = 401;
            $this->response['success'] = false;
            $this->response['message'] = 'Validation Errors';
            $this->response['error'] = $validator->messages();
        } else {
            try {

                $product = Product::find($request->id);
                if($product){
                    $this->response['message'] = 'Product Fetch Successfully';
                    $this->response['data'] = $product;
                } else {
                    $this->response['status'] = 404;
                    $this->response['success'] = false;
                    $this->response['message'] = 'Product Not Found';
                }
            } catch (\Throwable $th) {
                $this->response['status'] = 500;
                $this->response['success'] = false;
                $this->response['message'] = 'Something Went Wroung';
                $this->response['error'] = $th;
            }
        }   
         
        $JsonData = json_encode($this->response);
        return response()->json(Crypt::encryptString($JsonData));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'required',
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            $this->response['status'] = 401;
            $this->response['success'] = false;
            $this->response['message'] = 'Validation Errors';
            $this->response['error'] = $validator->messages();
        } else {
            try {

                $product =  Product::Select('id','title','description','price','status','category_id')->where('id',$request->id)->first();
                $product->category_id  = $request->category_id;
                $product->title  = $request->title;
                $product->description  = $request->description;
                $product->price  = $request->price;
                $product->status  = $request->status;
                    
                if($product->save()){
                    $this->response['status'] = 201;
                    $this->response['message'] = 'Product Updated Successfully';
                } else {
                    $this->response['status'] = 500;
                    $this->response['success'] = false;
                    $this->response['error'] = 'Something Went Wroung';
                }
    
    
            } catch (\Throwable $th) {
                $this->response['status'] = 500;
                $this->response['success'] = false;
                $this->response['message'] = 'Something Went Wroung';
                $this->response['error'] = $th;
            }
        }

        $JsonData = json_encode($this->response);
        return response()->json(Crypt::encryptString($JsonData));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        
        try {
            $product = Product::find($id);

            if($product){
                $product->delete();
                $this->response['message'] = 'Product Deleted Successfully';
            } else {
                $this->response['status'] = 404;
                $this->response['success'] = false;
                $this->response['message'] = 'Product Not Found';
            }
        } catch (\Throwable $th) {
            $this->response['status'] = 500;
            $this->response['success'] = false;
            $this->response['message'] = 'Something Went Wroung';
            $this->response['error'] = $th;
        }
            
        $JsonData = json_encode($this->response);
        return response()->json(Crypt::encryptString($JsonData));
    }
}
