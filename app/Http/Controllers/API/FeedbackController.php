<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Validator;

class FeedbackController extends Controller
{
    public function all()
    {
        $feedbacks = Feedback::with('user')->paginate(10);
        $response = [
            'success' => true,
            'data'    => $feedbacks->items(),
            'pagination' => [
                'total'        => $feedbacks->total(), 
                'per_page'     => $feedbacks->perPage(), 
                'current_page' => $feedbacks->currentPage(), 
                'last_page'    => $feedbacks->lastPage(), 
            ],
        ];        
        return response()->json($response, 200);        
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'category' => 'required'
        ]);
        $data = [
            'user_id' => auth()->id(),
            'title' => $request->category,
            'description' => $request->category,
            'category' => $request->category,
        ];
        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => 'Validation Error',
            ];
            if(!empty($validator->errors())){
                $response['data'] = $validator->errors();
            }
            return response()->json($response, 404);  
        }
        $feedback = Feedback::create($data);
        $response = [
            'success' => true,
            'message' => 'Feedback submitted successfully',
        ];
        return response()->json($response, 200);
    }

    public function single($id)
    {
        $feedback = Feedback::find($id);
        if(is_null($feedback)) {
            $response = [
                'success' => false,
                'message' => 'Feedback not found',
            ];
            return response()->json($response, 404);
        }
        $response = [
            'success' => true,
            'data' => $feedback,
        ];
        return response()->json($response, 200);   
    }
}