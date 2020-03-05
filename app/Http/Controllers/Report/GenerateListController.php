<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DealStaff;
use App\Models\Deal;
use App\Models\EmailTemplate;

use PDF;

class GenerateListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $hospitalList = [];

        $template = EmailTemplate::all();

        $hospital = Deal::with(['org_details'])->where('is_active', 1)->orderBy('id', 'DESC')->get();

        foreach ($hospital as $key => $value) {
            $staff = DealStaff::with(['deal'])->where('deal_id', $value->id)->orderBy('id', 'DESC')->get();
            $hospitalList[$key]['id'] = $value->id;
            $hospitalList[$key]['org_name'] = $value->org_details['org_name'];
            $hospitalList[$key]['staff_count'] = $staff->count();
        }
        \JavaScript::put([
            'hospitalList' => $hospitalList,
        ]);

        return view('reports.generate-list');
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
    }

    public function getStaffList() {
        $staffList = [];
        $hospital = Deal::with(['org_details'])->where('is_active', 1)->orderBy('id', 'DESC')->get();

        foreach ($hospital as $key => $value) {
            $staff = DealStaff::with(['deal'])->where('deal_id', $value->id)->orderBy('id', 'DESC')->get();
            foreach ($staff as $k => $v) {
                $staffList[] = [
                    'id' => $v['id'],
                    'deal_id' => $value['id'],
                    'title' => $v['title'],
                    'certification' => $v['certification'],
                    'firstname' => $v['firstname'],
                    'lastname' => $v['lastname'],
                    'email' => $v['email'],
                    'org_name' => $value->org_details['org_name'],
                    'created_at' => $v['created_at']->format('d-m-Y'),
                ];
            }
        }
        return $staffList;
    }

    public function fetchData($deal_id, $template_id){
        $hospital = Deal::with(['org_details'])->where('is_active', 1)->where('id', $deal_id)->orderBy('id', 'DESC')->get();
        $staff = DealStaff::with(['deal'])->where('deal_id', $deal_id)->orderBy('id', 'DESC')->get();
        $template = EmailTemplate::where('id', $template_id)->first();

        // dd($staff);

        // return view('reports.pdf-templates.template', compact('staff'));
        
        $pdf = PDF::loadView('reports.pdf-templates.template', compact('staff', 'hospital', 'template'));
        return $pdf->stream();
    }

    // public function generatePdf(){

    //     $this->fetchData;
    //     $data = 'sasasas';
    //     $pdf = PDF::loadView('reports.pdf-templates.template', compact('data'));
    //     return $pdf->stream();
    // }
}
