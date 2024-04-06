<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\BillLogRequest;
use App\Models\BillLog;

use Carbon\Carbon;

class BillLogsController extends Controller
{
    public function index(Request $request)
    {
        $bill_logs = BillLog::where('user_id', $request->user()->id)
                    ->orderBy('logdate', 'desc')
                    ->orderBy('logtime', 'desc')
                    ->orderBy('id', 'desc')
                    ->get();
        
        return response()->json($bill_logs);
    }

    public function show(Request $request, $id)
    {
        $bill_log = BillLog::select('type', 'amount', 'logdate', 'logtime', 'remarks')
                    ->where('user_id', $request->user()->id)
                    ->where('id', $id)
                    ->first();
        
        if (!$bill_log) {
            return response()->json(['error' => 'Bill log not found'], 404);
        }
        
        return response()->json($bill_log);
    }

    public function store(BillLogRequest $request)
    {
        $response = array();
        try {
            $bill_log = new BillLog();
            $bill_log->user_id = $request->user()->id;
            $bill_log->type = $request->type;
            $bill_log->amount = $request->amount;
            $bill_log->logdate = (!empty($request->logdate))? Carbon::parse($request->logdate)->format('Y-m-d'): date('Y-m-d');
            $bill_log->logtime = (!empty($request->logtime))? $request->logtime: '00:00:00';
            $bill_log->remarks = $request->remarks;
            $bill_log->save();

            $response = ['success' => 'success', 'message' => 'Bill log submitted'];
            return response()->json($response, 201);
        } catch (\Exception $e) {
            $response = response()->json(['error' => $e->getMessage()], 500);
            return response()->json($response, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $response = array();
        try {
            $bill_log = BillLog::where('user_id', $request->user()->id)
                    ->where('id', $id)
                    ->first();
            
            if (!$bill_log) {
                return response()->json(['error' => 'Bill log not found'], 404);
            }
            
            $bill_log->type = $request->type;
            $bill_log->amount = $request->amount;
            $bill_log->logdate = (!empty($request->logdate))? Carbon::parse($request->logdate)->format('Y-m-d'): date('Y-m-d');
            $bill_log->logtime = (!empty($request->logtime))? $request->logtime: '00:00:00';
            $bill_log->remarks = $request->remarks;
            $bill_log->save();
            
            $response = ['success' => 'success', 'message' => 'Bill log updated'];
            return response()->json($response, 201);
        } catch (\Exception $e) {
            $response = response()->json(['error' => $e->getMessage()], 500);
            return response()->json($response, 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        $bill_log = BillLog::where('user_id', $request->user()->id)
                    ->where('id', $id)
                    ->first();
        
        if (!$bill_log) {
            return response()->json(['error' => 'Bill log not found'], 404);
        }
        $bill_log->delete();
        return response()->json(['message' => 'Bill log deleted']);
    }

    public function getBillLogType()
    {
        return response()->json([
            1 => 'Electricity',
            2 => 'Gas',
            3 => 'Water',
            4 => 'Internet',
            5 => 'Phone',
            6 => 'Others',
        ]);
    }

    public function summary(Request $request)
    {
        $summary = BillLog::selectRaw('type, sum(amount) as total_amount')
                    ->where('user_id', $request->user()->id)
                    ->groupBy('type')
                    ->get();
        
        return response()->json($summary);
    }

    public function monthlySummary(Request $request)
    {
        $summary = BillLog::selectRaw('YEAR(logdate) as year, MONTH(logdate) as month, sum(amount) as total_amount')
                    ->where('user_id', $request->user()->id)
                    ->groupBy('year', 'month')
                    ->get();
        
        return response()->json($summary);
    }

    public function yearlySummary(Request $request)
    {
        $summary = BillLog::selectRaw('YEAR(logdate) as year, sum(amount) as total_amount')
                    ->where('user_id', $request->user()->id)
                    ->groupBy('year')
                    ->get();
        
        return response()->json($summary);
    }

}
