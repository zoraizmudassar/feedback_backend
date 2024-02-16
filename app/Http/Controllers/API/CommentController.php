<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Validator;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'content' => 'required',
        ]);
        $data = [
            'user_id' => auth()->id(),
            'content' => $request->content,
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
        $feedback = Comment::create($data);
        $response = [
            'success' => true,
            'message' => 'comment submitted successfully',
        ];
        return response()->json($response, 200);
    }
}
