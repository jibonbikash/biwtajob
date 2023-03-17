<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Examlevel;
use App\Models\ExamlevelGroup;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class ExamLevelGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $name= $request->get('name');
       $examlevel_id= $request->get('examlevel_id');
       $ExamlevelGroups=ExamlevelGroup::with(['examLevel','examSubject'])
           ->when($name, function ($query) use ( $name) {
               $query->where('name','like', '%'.$name.'%');
           })
           ->when($examlevel_id, function ($query) use ($examlevel_id) {
               $query->where('examlevel_id',$examlevel_id);
           })
           ->latest()->paginate(20);

        return view('admin.examlevel.group.index',['ExamlevelGroups'=>$ExamlevelGroups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $examLevel= Examlevel::orderBy('name')->get();
        return view('admin.examlevel.group.create',['examLevel'=>$examLevel]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'examlevel_id' => 'required',
            'name' => 'required|unique:examlevel_groups,name',
            'status' => 'required'
        ]);
        if(ExamlevelGroup::create([
            'examlevel_id' =>$request->get('examlevel_id'),
            'name' =>$request->get('name'),
            'status' =>$request->get('status'),
        ])){
            return redirect()->route('examlevelgroups.index')
                ->with('success', 'Data save successfully!!');
        }

        else{
            return redirect()->route('examlevelgroups.index')
                ->with('error', 'Data not save!!');
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
       $group=ExamlevelGroup::find($id);
        $examLevel= Examlevel::orderBy('name')->get();
        return view('admin.examlevel.group.update',['examLevel'=>$examLevel,'group'=>$group]);
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
        $this->validate($request, [
            'examlevel_id' => 'required',
            'name' => 'required|unique:examlevel_groups,name,'.$id,
            'status' => 'required'
        ]);
        $examLevel= ExamlevelGroup::find($id);
        $examLevel->name = $request->input('name');
        $examLevel->examlevel_id = $request->input('examlevel_id');
        $examLevel->status = $request->input('status');
        // $examLevel->save();
        if($examLevel->save()){
            return redirect()->route('examlevelgroups.index')
                ->with('success', 'Data update successfully!!');
        }
        else{
            return redirect()->route('examlevelgroups.index')
                ->with('error', 'Data not save!! Please try later');
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
        $examLevel= ExamlevelGroup::find($id);
        if($examLevel->delete()){
            return redirect()->route('examlevelgroups.index')
                ->with('success', 'Data Deleted successfully!!');
        }
        else{
            return redirect()->route('examlevelgroups.index')
                ->with('error', 'Data not save!! Please try later');
        }
    }

    public function examgroup(Request $request){

        $group=  ExamlevelGroup::where([
                ['examlevel_id', $request->examlevel],
            ])->get();
        return response()->json(['success' => true, 'data' => $group]);
    }
}
