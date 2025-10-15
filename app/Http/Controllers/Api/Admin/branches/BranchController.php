<?php

namespace App\Http\Controllers\Api\Admin\branches;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\branches\BranchResource;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{

       /* 

    *create new branch
    */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'string'
        ]);

        Branch::create([
            'title' => $data['title']
        ]);
        return response()->json([
            'message' => 'created successfully'
        ]);
    }

    /* 

    *return all branches
    */

    public function index()
    {
        $branches = Branch::all();
        return BranchResource::collection($branches);
    }

   /* 

    *update the selected branch
    */
    public function update(Request $request, Branch $branch)
    {

        $data = $request->validate([
            'title' => 'string'
        ]);


        $branch->update([
            'title' => $data['title']
        ]);
        return response()->json([
            'message' => 'updated successfully'
        ]);
    }



       /* 

    *delete selected branches
    */
    public function show(Branch $branch)
    {
        return new BranchResource($branch);
        
    }
}
