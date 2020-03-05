<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmailTemplate;

class EmailTemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('email.templates.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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
        //
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
        $template = EmailTemplate::find($id);
        $template->delete();
    }

    public function get_templates_list() {
        return EmailTemplate::all();
    }

    public function template_store_update(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email_subject' => 'required',
        ]);


        $et = EmailTemplate::updateOrCreate(
            [
                'name' => $request->name,
            ],
            [
                'name' => $request->name,
                'email_subject' => $request->email_subject,
                'email_content' => $request->email_content,
                'active' => $request->active ? 1 : 0
            ]
        );

        // dd($this->generate_number($et));

        if($et->serial_no == null){
            $et->serial_no = $this->generate_number($et);
            $et->update();
        }

    }

    public function generate_number($et)
    {
        $generate = $et->id.'/'.$this->RandomString().'.'.$this->RandomString().'.'.$this->RandomString().'/'. sprintf("%'.03d", mt_rand(1,999)).'/'.date('Y');
        // $generate .= $et->id.'/';
        if(EmailTemplate::where('serial_no', $generate)->first()){
            $this->generate_number($et);
        }
        return $generate;

    }
    public function RandomString()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 3; $i++) {
            $randstring .= $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }
}
