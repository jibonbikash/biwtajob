<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Examlevel;
use App\Models\ExamlevelGroup;
use Illuminate\Http\Request;

class ExamLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name= $request->get('name');
        $examLevels= Examlevel::
            when($name, function ($query) use ( $name) {
                $query->where('name','like', '%'.$name.'%');
            })
        ->latest()->paginate(20);
       // dd($examLevels);
        return view('admin.examlevel.index',['examLevels'=>$examLevels]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $examLevel= Examlevel::find($id);
        // dd($examLevels);
        return view('admin.examlevel.update',['examLevel'=>$examLevel]);
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
            'name' => 'required|unique:examlevels,name,'.$id,
            'status' => 'required'
        ]);

        $examLevel= Examlevel::find($id);
        $examLevel->name = $request->input('name');
        $examLevel->status = $request->input('status');
       // $examLevel->save();
        if($examLevel->save()){
            return redirect()->route('examlevels.index')
                ->with('success', 'Data save successfully!!');
        }
        else{
            return redirect()->route('examlevels.index')
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
        //
    }

    public function groupadd(Request $request, $id){
        $examLevel= Examlevel::find($id);
        return view('admin.examlevel.groupadd',['examLevel'=>$examLevel]);
    }

    public function groupaddsave(Request $request, $id){
        $this->validate($request, [
            'name' => 'required|unique:examlevel_groups,name',
            'status' => 'required'
        ]);
        $examgroup=ExamlevelGroup::create([
            'examlevel_id'=>$id,
            'name'=>$request->input('name'),
            'status'=>$request->input('status'),
        ]);
        if($examgroup){
            return redirect()->route('examlevels.groupadd', ['id' => $id])
                ->with('success', 'Data save successfully!!');
        }
        else{
            return redirect()->route('examlevels.groupadd', ['id' => $id])
                ->with('error', 'Data not save!!');
        }
    }
}
