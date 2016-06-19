<?php

namespace App\Http\Controllers;

use App\Blocker;
use App\Report;
use App\Team;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\lib\Html2Text;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function userReports(User $id){
        if(Auth::user()->role !== 'admin') return redirect('/login');
        $user = $id;
        $user_reports = $user
            ->reports()
            ->paginate(10);
        $user_blockers = $user
            ->blockers()
            ->paginate(10);
        $user_teams = $user->teams()->get();
        return view::make('individual-person-report', [
            'user'               => $user,
            'user_reports'       => $user_reports,
            'user_blockers'      =>  $user_blockers,
            'user_teams'         =>  $user_teams
        ]);
    }

    public function teamReports(Team $team_id){
        if(Auth::user()->role !== 'admin') return redirect('/login');
        $team_member_ids = $team_id->members()->pluck('id');
        $team_reports = Report::with('user')
            ->whereIn('user_id', $team_member_ids)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        $team_members = $team_id->members()->get();
        return view::make('individual-team-report', [
            'team_reports' => $team_reports,
            'team_members'    => $team_members,
            'team'    => $team_id,
        ]);

    }

    public function filteredReports(Request $request){
        $date = Carbon::parse($request->dateFilter);

        $reports = \App\User::all();
        $reports->load(['reports' =>function ($query) use($date) {
            $query->where('created_at', '=', $date);
            $query->orderBy('created_at', 'desc');
        }]);
        return $reports;

    }


    public function generateTodayDocReport(){
        if(Auth::user()->role !== 'admin') return redirect('/login');
        if(Auth::user()->role !== 'admin') return redirect('/login');
        return $this->generateDocReport(Carbon::today()->toDateString());
    }
    
    
    public function generateCustomDocReport($date){
        if(Auth::user()->role !== 'admin') return redirect('/login');

        return $this->generateDocReport($date);
    }

    public function generateDocReport($date){
        if($date == null){
            $date = Carbon::today()->toDateString();
        }else{
            $date = Carbon::parse($date)->toDateString();
        }
        if(Auth::user()->role !== 'admin') return redirect('/login');
        $teams = \App\Team::all();
        $teams->load(['members.reports' => function ($query) use($date){
            $query->wheredate('created_at', '=', $date);
        }]);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $header = array('size' => 16, 'bold' => true,'alignment' => 'center');
        $reportHeader = 'StandUp Report for the day of '. Carbon::parse($date)->format('jS F, Y');
        $section->addText(htmlspecialchars($reportHeader, ENT_COMPAT, 'UTF-8'), $header);
        $lineStyle = array('weight' => 1, 'width' => 300, 'height' => 0, 'color' => 635552);
        $section->addLine($lineStyle);
        foreach ($teams as $team){
            $section->addTextBreak(3);
            $section->addText(htmlspecialchars($team->team_name, ENT_COMPAT, 'UTF-8'), $header);
            $styleTable = array('borderSize' => 1, 'borderColor' => '000', 'cellMargin' => 80, 'alignment' => 'center');
            $styleFirstRow = array('borderBottomSize' => 2, 'borderBottomColor' => '000');
            $styleCell = array('valign' => 'center','alignment' => 'center');
            $fontStyle = array('bold' => true);
            $phpWord->addTableStyle('Team Table', $styleTable, $styleFirstRow);
            $table = $section->addTable('Team Table');
            $table->addRow(900);
            $table->addCell(3000, $styleCell)->addText(htmlspecialchars('Name', ENT_COMPAT, 'UTF-8'), $fontStyle);
            $table->addCell(6000, $styleCell)->addText(htmlspecialchars('Task Done', ENT_COMPAT, 'UTF-8'), $fontStyle);
            $fontStyle = array('valign' => 'center','alignment' => 'left');
            foreach ($team->members as $team_member){
                $table->addRow();
                $table->addCell(3000)->addText(htmlspecialchars($team_member->name, ENT_COMPAT, 'UTF-8'));
                if(count($team_member->reports->toArray())>0){
                    foreach ($team_member->reports as $report){
                        $html = new Html2Text($report->task_done);
                        $task = $html->getText();
                        $table->addCell(6000)->addText(htmlspecialchars($task, ENT_COMPAT, 'UTF-8'), $fontStyle);

                        $table->addCell(6000)->addText(trim(htmlspecialchars(strip_tags($report->task_done), ENT_COMPAT, 'UTF-8')));

                    }
                }else{
                    $table->addCell(6000)->addText(htmlspecialchars('X', ENT_COMPAT, 'UTF-8'));
                }
            }
        }
        $parentFolder = date('Y');
        $childFolder = date('M');
        $fileName   = 'Reports-'. date('d-m-y').'.docx';
        $dirStrucre = './'.$parentFolder.'/'.$childFolder.'/';
        if(!is_dir($dirStrucre)){
            mkdir("./".$parentFolder.'/'.$childFolder,  0777, true);
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($dirStrucre.'/'.$fileName);
        return redirect('/'.$parentFolder.'/'.$childFolder.'/'.$fileName);

    }

    /**
     *  Stores new report in the DB
     */
    public function store(Request $request){
        // @todo have to validate the form

//        return $request->all();
        $todaysReport = null;
        $lastDayReport= null;
        $user = User::find(Auth::user()->id);

        $todaysReport = Report::where('user_id',$user->id)->whereDate('created_at','=',Carbon::today()->toDateString())->first();
        $lastDayReport = $user->lastReport()->get();

        if($todaysReport){
            DB::table('reports')
                ->where('id', $todaysReport->id)
                ->update(['task_done' => $request->task_done]);
        }else{
            $report = new Report();
            $report->user_id  = $user->id;
            $report->task_done  = $request->task_done;
            $report->save();
        }

        if(isset($request->task_done_last_day) && !empty($request->task_done_last_day) && $lastDayReport){
            $lastDayReport = $lastDayReport[0];
            DB::table('reports')
                ->where('id', $lastDayReport->id)
                ->update(['task_done' => $request->task_done_last_day,'updated_at' => Carbon::now()]);
        }

        if($request->add_blocker == 'yes' && !empty($request->blocker )){
                $blocker = new Blocker();
                $blocker->user_id = $user->id;
                $blocker->blocker = $request->blocker;
                $blocker->status  = 1;
                $blocker->save();
            }



        return redirect('/');
    }

    
}
