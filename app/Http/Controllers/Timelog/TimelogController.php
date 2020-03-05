<?php

namespace App\Http\Controllers\Timelog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;
use App\User;
use App\Models\Timelog;
use App\Models\TimelogBreak;

class TimelogController extends Controller
{

    private function _hts($time)
    {
        list($h, $m, $s) = explode(':', $time);
        return ($h * 3600) + ($m * 60) + $s;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // Timelog Checker if timelog exist
        $timelogChecker = Timelog::select(['id','user_id', 'time_in', 'time_out', 'total_mins_break'])->where([
            ['user_id', Auth::user()->id],
        ])->whereDate('time_in', Carbon::now()->format('Y-m-d'))->first();


        // Breaks Checker if timelog exist
        if ($timelogChecker != null) {
            # code...
            $breaksChecker = TimelogBreak::select(['timelog_id', 'break_start', 'break_end'])->where([
                ['timelog_id', $timelogChecker->id],
            ])->whereDate('break_start', Carbon::now()->format('Y-m-d'))->orderBy('break_start', 'DESC')->first();
            
        }
        

        \JavaScript::put([
            'timelogDetails' => $timelogChecker,
            'breakDetails' => $timelogChecker != null ? $breaksChecker : '',
        ]);

        return view('timelog.index');
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

    // Timelog and Breaks
    public function today_timelog() {
        $timelogList = [];
        $todayTimelog = Timelog::with('breaks')->where('user_id', Auth::user()->id)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->orderBy('created_at', 'DESC')->get();

        foreach ($todayTimelog as $key => $value) {
            $timelogList['id'] = $value->id;
            $timelogList['user_id'] = $value->user_id;
            $timelogList['time_in'] = $value->time_in;
            $timelogList['time_out'] = $value->time_out;
            $timelogList['total_mins_break'] = $value->total_mins_break;
            $timelogList['total_mins_tardy'] = $value->total_mins_tardy;
            $timelogList['on_leave'] = $value->on_leave;
            $timelogList['is_absent'] = $value->is_absent;
            foreach ($value->breaks as $k => $v) {
                $timelogList['breaks'][] = [
                    'id' => $v->id,
                    'timelog_id' => $v->timelog_id,
                    'break_start' => $v->break_start,
                    'break_end' => $v->break_end,
                    'total_breaks' => $v->total_breaks,
                    'notes' => $v->notes,
                ];
            }
        }
        return $timelogList;
    }

    // Timelog
    public function time_in(Request $request){
        // dd($request->time_in);
        // dd(Carbon::now());
        $timelogProcess = new Timelog();
        $data = [
            'user_id' => Auth::user()->id,
            'time_in' => $request->time_in,
            'total_mins_tardy' => Carbon::parse(Auth::user()->logintime)->diffInMinutes(Carbon::createFromFormat('Y-m-d H:i:s', $request->time_in))
        ];
        $timelogProcess->fill($data);
        $timelogProcess->save();
    }

    public function time_out(Request $request, $id){
        $updateTimelog = Timelog::where('id', $id)->whereDate('time_in', Carbon::now()->format('Y-m-d'))->first();
        $updateTimelog->time_out = $request->time_out;
        $updateTimelog->update();
    }

    // Break
    public function start_break(Request $request) {
        $breakProcess = new TimelogBreak();
        $data = [
            'timelog_id' => $request->timelog_id,
            'break_start' => $request->break_start,
            'notes' => $request->notes,
        ];
        $breakProcess->fill($data);
        $breakProcess->save();
    }
    
    public function end_break(Request $request, $id) {

        // Breaks Checker if timelog exist
        $breaksChecker = TimelogBreak::with(['timelog'])->where([
            ['timelog_id', $id],
        ])->whereDate('break_start', Carbon::now()->format('Y-m-d'))->orderBy('break_start', 'DESC')->first();

        $totalPerBreaks = $breaksChecker->break_start->diffInMinutes($request->break_end);

        if ($breaksChecker->break_end === null) {
            $breaksChecker->break_end = $request->break_end;
            $breaksChecker->total_breaks = $totalPerBreaks;
            $breaksChecker->timelog['total_mins_break'] = $breaksChecker->timelog['total_mins_break'] + $totalPerBreaks;
            $breaksChecker->update();
            $breaksChecker->timelog->update();
        }
    }

    public function summary() {

        $current_date = Carbon::now()->setTimezone('Asia/Manila');
        $firstLogin = Timelog::where('user_id', Auth::user()->id)->orderBy('time_in', 'ASC')->first();

        if ($current_date->format('Y-m') == $firstLogin->time_in->format('Y-m')) {
            $from_date = new Carbon($user->time_in);
        } else {
            $from_date = Carbon::now()->startOfMonth();
        }
        
        return view('timelog.summary');
    }

    public function summary_list() {
        $findTimelog = Timelog::select(['id', 'user_id', 'time_in', 'time_out', 'total_mins_break', 'total_mins_tardy'])->where('user_id', Auth::user()->id)->orderBy('time_in', 'DESC')->get();
        return $findTimelog;
    }
}
