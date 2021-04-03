<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class CRUDController extends Controller
{
    protected $model;
    protected $essense;
    protected $th;
    protected $td;
    protected $oneText;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->model::orderBy('id','desc')->paginate(10);
        
        return view('admin.table',[
            'posts' => $posts,
            'title' => ucfirst($this->essense) . ' Table',
            'th' => $this->th,
            'td' => $this->td,
            'essence' => $this->essense,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.new.'.$this->essense);
    }

    public function store(Request $request)
    {
        $this->myValidate($request);
            
        $post = $this->model::create($request->all());

        return redirect()->route($this->essense.'.edit',$post->id)->with('message',$this->oneText.' has been created successfully!');
    }

    public function show()
    {
        return redirect()->back();
    }

    public function edit($id)
    {
        $post = $this->model::findOrFail($id);
        return view('admin.edit.'.$this->essense,[
            'post' => $post,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->myValidate($request);

        $post = $this->model::findOrFail($id);
        $post->update($request->all());
        return redirect()->back()->with('message',$this->oneText . ' has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model::destroy($id);
        
        return redirect()->route($this->essense.'.index')->with('message',$this->oneText.' has been deleted successfully!');
    }


    protected function myValidate(Request $request)
    {
        return $request->validate([]);
    }
    
}