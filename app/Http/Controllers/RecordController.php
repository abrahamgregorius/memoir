<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Record::get();

        return response()->json([
            'records' => $records->map(function($record) {
                return [
                    'id' => $record->id,
                    'title' => $record->title,
                    'content' => $record->content,
                    'author' => $record->user->username,
                    'category' => $record->category->name,
                    
                ];
            })
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ], 422);
        }

        $record = Record::create($request->all());
        
        return response()->json([
            'message' => 'Record created successfully',
            'record' => $record
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $record = Record::find($id);

        if(!$record) {
            return response()->json([
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Record found',
            'category' => $record
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record, Request $request)
    {
        $record = Record::find($request->id)->delete();

        if(!$record) {
            return response()->json([
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Record deleted successfully'
        ]);
    }
}
