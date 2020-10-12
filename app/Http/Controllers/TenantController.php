<?php

namespace App\Http\Controllers;

use App\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $tenants = Tenant::all();
        return view('tenants.index',compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenants.create');
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
            'tenant_name' => 'required|string',
            'IDcard_number' => 'required|unique:tenants,IDcard_number',
            'type_IDcard' => 'required',
            'no_HP' => 'required|numeric|unique:tenants,no_HP',
            'address' => 'required|string',
            'email' => 'required|email:rfc,dns,filter|max:50|unique:tenants,email',
        ],[
            'tenant_name.required' => 'Tenant Name must be filled',
            'tenant_name.string' => 'Tenant Name should not contain a number',
            'IDcard_number.required' => 'ID Number must be filled',
            'IDcard_number.unique' => 'ID Number must be unique',
            'type_IDcard.required' => 'Type ID Number must be filled',
            'no_HP.required' => 'Phone Number must be filled',
            'no_HP.numeric' => 'Phone Number should numeric',
            'no_HP.unique' => 'Phone Number must be unique',
            'address.required' => 'Address must be filled',
            'address.string' => 'Address must be string',
            'email.required' => 'Email must be filled',
            'email.unique' => 'Email must be unique',
        ]);

        if($request->type_IDcard == 'KTP'){
            $validator = Validator::make($request->all(),
                ['IDcard_number' => 'numeric|digits:16'],
                [
                    'IDcard_number.digits' => 'ID number for KTP must be 16 digits',
                    'IDcard_number.numeric' => 'ID number for KTP must contain number only'
                ]);
        }
        if($request->type_IDcard == 'Passport'){
            $validator = Validator::make($request->all(),
                ['IDcard_number' => 'size:8'],
                ['IDcard_number.size' => 'ID number for Passport must be 8 digits']);
        }
        if($request->type_IDcard == 'SIM'){
            $validator = Validator::make($request->all(),
                ['IDcard_number' => 'numeric|digits:12'],
                ['IDcard_number.digits' => 'ID number for SIM must be 12 digits',
                'IDcard_number.numeric' => 'ID number for SIM must contain number only'
                ]);
        }

        if ($validator->fails()) {
            return redirect('tenant/create')
                        ->withErrors($validator)
                        ->withInput();
        }


        try {
            //instansiasi tenant
            $tenants = new Tenant($request->all());
            //store data
            $tenants->save();

            return redirect()->route('tenant.index')->with(['success'=>'Data created successfully!!']);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tenants = Tenant::with('bookings')->find($id);
        return view('tenants.show',compact('tenants'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $tenants = Tenant::find($id);
        return view('tenants.edit',compact('tenants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //validate
        $validator = Validator::make($request->all(), [
            'tenant_name' => 'required|string',
            'IDcard_number' => 'required',
            'type_IDcard' => 'required',
            'no_HP' => 'required|numeric|max:12',
            'address' => 'required|string',
            'status' => 'required',
            'email' => 'required|string|email:rfc,dns,filter|max:50',

        ],[
            'tenant_name.required' => 'Tenant Name must be filled',
            'tenant_name.string' => 'Tenant Name should not contain a number',
            'IDcard_number.required' => 'ID Number must be filled',
            'type_IDcard.required' => 'Type ID Number must be filled',
            'no_HP.required' => 'Phone Number must be filled',
            'no_HP.numeric' => 'Phone Number should numeric',
            'address.required' => 'Address must be filled',
            'address.string' => 'Address must be string',
            'status.required' => 'Status required',
            'email.required' => 'Email must be filled',
        ]);

        if($request->type_IDcard == 'KTP'){
            $validator = Validator::make($request->all(),
                ['IDcard_number' => 'numeric|digits:16'],
                [
                    'IDcard_number.digits' => 'ID number for KTP must be 16 digits',
                    'IDcard_number.numeric' => 'ID number for KTP must contain number only'
                ]);
        }
        if($request->type_IDcard == 'Passport'){
            $validator = Validator::make($request->all(),
                ['IDcard_number' => 'size:8'],
                ['IDcard_number.size' => 'ID number for Passport must be 8 digits']);
        }
        if($request->type_IDcard == 'SIM'){
            $validator = Validator::make($request->all(),
                ['IDcard_number' => 'numeric|digits:12'],
                ['IDcard_number.digits' => 'ID number for SIM must be 12 digits',
                'IDcard_number.numeric' => 'ID number for SIM must contain number only'
                ]);
        }

        if ($validator->fails()) {
            return redirect('tenant/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
            //find id
            $tenants = Tenant::findOrFail($id);
            // update data
            $tenants->update($request->all());

            return redirect()->route('tenant.index')->with(['success'=>'Data updated successfully!!']);

        } catch (\Exception $e) {
           return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tenants = Tenant::findOrFail($id);
        $tenants->delete();
        return redirect()->back()->with(['success'=>'Tenant <strong>'.$tenants->tenant_name.'</strong> deleted successfully!']);
    }
}
