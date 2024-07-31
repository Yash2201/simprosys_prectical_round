<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Category;
use Illuminate\Support\Facades\Crypt;

class CategoryController extends Controller
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
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            $this->response['status'] = 401;
            $this->response['success'] = false;
            $this->response['message'] = 'Validation Errors';
            $this->response['error'] = $validator->messages();
        } else {
            try {
                $category = new Category;
                $category->name = $request->name;
    
                if($category->save()){
                    $this->response['status'] = 201;
                    $this->response['message'] = 'Category Saved Successfully';
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
     * Category List.
     */
    public function category_list(Request $request)
    {
        try {
            $category =  Category::all()->toArray();

            if($category){
                $this->response['message'] = 'Category Fetch Successfully';
                $this->response['data'] = $category;
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
}