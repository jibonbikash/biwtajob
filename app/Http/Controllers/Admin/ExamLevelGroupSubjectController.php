<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ImportExamlevelGroup;
use App\Imports\ImportExamlevelSubject;
use App\Models\Examlevel;
use App\Models\ExamlevelGroup;
use App\Models\ExamlevelSubject;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExamLevelGroupSubjectController extends Controller
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
        $examlevel_group_id= $request->get('examlevel_group_id');
       $examSubjects= ExamlevelSubject::with(['examGroup','examlevel'])
           ->when($name, function ($query) use ( $name) {
               $query->where('name','like', '%'.$name.'%');
           })
           ->when($examlevel_id, function ($query) use ($examlevel_id) {
               $query->where('examlevel_id',$examlevel_id);
           })
           ->when($examlevel_group_id, function ($query) use ($examlevel_group_id) {
               $query->where('examlevel_group_id',$examlevel_group_id);
           })
           ->latest()->paginate(20);
        return view('admin.examlevel.group.subject.index',['examSubjects'=>$examSubjects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $examLevel= Examlevel::orderBy('name')->get();
        return view('admin.examlevel.group.subject.create',['examLevel'=>$examLevel]);
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
            'examlevel_group_id' => 'required',
           // 'name' => 'required|unique:examlevel_subjects,name',
            'name' => 'required',
            'status' => 'required'
        ]);
        if(ExamlevelSubject::create([
            'examlevel_id' =>$request->get('examlevel_id'),
            'examlevel_group_id' =>$request->get('examlevel_group_id'),
            'name' =>$request->get('name'),
            'status' =>$request->get('status'),
        ])){
            return redirect()->route('examlevelgroupsubjects.index')
                ->with('success', 'Data save successfully!!');
        }

        else{
            return redirect()->route('examlevelgroupsubjects.index')
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
        $subject=ExamlevelSubject::find($id);
        $examLevel= Examlevel::orderBy('name')->get();
        $examLevelGroup= ExamlevelGroup::orderBy('name')->get()->pluck('name','id');
        return view('admin.examlevel.group.subject.update',['examLevel'=>$examLevel,'subject'=>$subject,'examLevelGroup'=>$examLevelGroup]);
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
            'examlevel_group_id' => 'required',
            'name' => 'required|unique:examlevel_subjects,name,'.$id,
            'status' => 'required'
        ]);
        $examLevel= ExamlevelSubject::find($id);
        $examLevel->name = $request->input('name');
        $examLevel->examlevel_id = $request->input('examlevel_id');
        $examLevel->examlevel_group_id = $request->input('examlevel_group_id');
        $examLevel->status = $request->input('status');
        // $examLevel->save();
        if($examLevel->save()){
            return redirect()->route('examlevelgroupsubjects.index')
                ->with('success', 'Data update successfully!!');
        }
        else{
            return redirect()->route('examlevelgroupsubjects.index')
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
        $examLevel= ExamlevelSubject::find($id);
        if($examLevel->delete()){
            return redirect()->route('examlevelgroupsubjects.index')
                ->with('success', 'Data Deleted successfully!!');
        }
        else{
            return redirect()->route('examlevelgroupsubjects.index')
                ->with('error', 'Data not Deleted!! Please try later');
        }
    }

    public function importView(Request $request){

        return view('admin.examlevel.group.subject.import');
    }

    public function import(Request $request){

        Excel::import(new ImportExamlevelSubject(), $request->file('file')->store('files'));
        return redirect()->back()->with('success', 'Imported successfully!!');;
    }
}
