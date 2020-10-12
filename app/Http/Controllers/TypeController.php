<?php

namespace App\Http\Controllers;

use App\Room;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $types = Type::all();
        return view('types.index',compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //validate
        $validator = Validator::make($request->all(), [
            'type_name' => 'required|string|unique:types|min:5|max:20',
            'rent_price' => 'required|numeric',
            'capacity' => 'required|numeric',
            'description' => 'required'
        ],[
            'type_name.required' => 'Type Name must be filled',
            'type_name.unique' => 'Type Name must be unique',
            'type_name.string' => 'Type Name must be string',
            'rent_price.required' => 'Rent Price must be filled',
            'rent_price.numeric' => 'Rent Price must be number',
            'capacity.required' => 'Capacity must be filled',
            'capacity.numeric' => 'Capacity must be number',
            'description.required' => 'Description must be filled',
        ]);

        if ($validator->fails()) {
            return redirect()->route('type.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
            //instansiasi types
            $types = new Type($request->all());
            //store data
            $types->save();

            return redirect()->route('type.index')->with(['success'=>'Type was created successfully!!']);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>  $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $types = Type::find($id);
        $rooms = Room::where('type_id',$id)->get();
        // dd($rooms);
        return view('types.show',compact('types','rooms'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $types = Type::find($id);
        return view('types.edit',compact('types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

          //validate
        $validator = Validator::make($request->all(), [
            'type_name' => 'required|string|min:5|max:20',
            'rent_price' => 'required|numeric',
            'capacity' => 'required|numeric',
            'description' => 'required'

        ],[
            'type_name.required' => 'Type Name must be filled',
            'type_name.string' => 'Type Name must be string',
            'rent_price.required' => 'Rent Price must be filled',
            'rent_price.numeric' => 'Rent Price must be number',
            'capacity.required' => 'Capacity must be filled',
            'capacity.numeric' => 'Capacity must be number',
            'description.required' => 'Description must be filled',

        ]);

        if ($validator->fails()) {
            return redirect()->route('type.edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
            //find id
            $types = Type::findOrFail($id);
            // update data
            $types->update($request->all());

            return redirect()->route('type.index')->with(['success'=>'Type was changed successfully!!']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error'=>  $e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $types = Type::findOrFail($id);
        $types->delete();
        return redirect()->back()->with(['success'=>'Data Type <strong>'.$types->type_name.'</strong> deleted successfully!!']);
    }


}
