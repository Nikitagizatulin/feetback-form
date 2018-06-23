<?php

namespace App\Http\Controllers;

use App\Model\Bid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    private function checkLastBid()
    {
        $uid     = Auth::user()->id;
        $lastBid = Bid::where('user_id', $uid)->orderBy('id', 'desc')->first();
        if ( ! $lastBid) {
            return 0;
        }
        $time = $lastBid->created_at;
        $time = Carbon::parse($time);
        $now  = Carbon::now();
        $dif  = $now->diffInSeconds($time);
        if ($dif >= 86400) {
            return 0;
        } else {
            return 86400 - $dif;
        }
    }

    public function feedback()
    {
        $difTime = $this->checkLastBid();

        return view('feedback.feedback', compact('difTime'));
    }

    public function fb(StoreBid $request)
    {
        $timeToNewBid = $this->checkLastBid();
        if ( ! empty($timeToNewBid)) {
            $time = Carbon::now()->addSeconds($timeToNewBid)->diffForHumans();;
            return back()->with('error',
                'It is allowed to send one application per day. Before the opportunity to send an application ' . $time);
        }
        $path = $request->file('file')->store('user-files');
        Bid::create([
            'theme'   => $request->theme,
            'message' => $request->message,
            'file'    => $path,
            'user_id' => Auth::user()->id
        ]);
        return back()->with('success', 'Your application is registered');
    }

    public function download(Request $request)
    {
        $path = storage_path('app/' . urldecode($request->file));
        return response()->download($path);
    }

    public function feedbackAll()
    {
        $countPaginate = 10;
        $data          = DB::table('bids')->select(DB::raw('bids.*,users.name,users.email'))->join('users', 'users.id',
            '=', 'bids.user_id')->orderBy('id', 'desc')->paginate($countPaginate);
        $count         = ($data->currentPage() * $countPaginate + 1) - $countPaginate;
        return view('feedback.feedback_all', compact('data', 'count'));
    }

    public function readed(Request $request)
    {
        $bid         = Bid::findOrFail($request->id);
        $newData     = $bid->readed == '0' ? '1' : '0';
        $bid->readed = $newData;
        if ($bid->save()) {
            return response()->json(['success' => 'data changed']);
        } else {
            return abort(500, 'Something went wrong');
        }
    }
}
