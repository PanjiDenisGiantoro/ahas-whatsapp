<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;
class SwitchDeviceController extends Controller
{
	public function index()
	{
		$get =  DB::table('switch_devices as sd')
				->join('numbers as num','num.id','=','sd.number_id')
				->select('num.body as number','sd.kuota','sd.status as status_switch','num.status as status_number','sd.id'
					,'sd.number_id','sd.number_id_parent')
				->get();
		$arrGet = json_decode(json_encode($get), true);
		$data = $arrGet;
		$log = [];
		$numberTaken = [];
		foreach ($data as $key => $value) 
		{
		    $data[$key]['id_child'] = 0;
			$data[$key]['child_number'] = '';
			$data[$key]['child_status'] = '';
			//child
			$numItem = DB::table('numbers')->where('id',$value['number_id_parent'])->first();
			if($numItem)
			{
				$data[$key]['id_child'] = $numItem->id;
				$data[$key]['child_number'] = $numItem->body;
				$data[$key]['child_status'] = $numItem->status;
			}
			//log
			array_push($numberTaken, $value['number']);
			$item = DB::table('switch_device_log as sdl')
				    ->join('campaigns as camp','camp.id','=','sdl.campaign_id')
				    ->select(DB::raw('COUNT(sdl.id) as total'),'camp.name as campaign_name')
				    ->where('sdl.switch_device_id',$value['id'])
				    ->groupBy('sdl.campaign_id')
				    ->get();
			$arr = json_decode(json_encode($item), true);
			if(!$item->isEmpty())
			{
				$log[$value['id']]['data'] = $arr;
			}
		}
		//dd($data);
		$numbers = DB::table('numbers')->whereNotIn('body',$numberTaken)->get();
		$numbersEdit =  DB::table('numbers')->get();
		return view('pages.admin.switch_device',compact('data','log','numbers','numbersEdit'));
	}

	public function store(Request $request)
	{
		$check = DB::table('switch_devices')->where('number_id',$request->number_id)->first();
		if($check)
		{	
			return redirect()->back()->with('alert', ['type' => 'danger', 'msg' => 'Device '.$check->body.' Switch Schema Already Found!']);
		}
		DB::table('switch_devices')->insert([
			'number_id'=>$request->number_id,
			'kuota'=>$request->kuota,
			'status'=>$request->status,
			'created_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString()
		]);
		return redirect()->back()->with('alert', ['type' => 'success', 'msg' => 'Device Switch Schema Created Successfully']);
	}

	public function update(Request $request,$id)
	{
		$old = DB::table('switch_devices')->where('id',$id)->select('number_id')->first();
		if($old)
		{
			if($old->number_id != $request->number_id)
			{
				$check = DB::table('switch_devices')->where('number_id',$request->number_id)->first();
				if($check)
				{	
					return redirect()->back()->with('alert', ['type' => 'danger', 'msg' => 'Device '.$check->body.' Switch Schema Already Found!']);
				}
			}
		}
		DB::table('switch_devices')->where('id',$id)->update([
			'number_id'=>$request->number_id,
			'kuota'=>$request->kuota,
			'status'=>$request->status,
			'updated_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString()
		]);
		return redirect()->back()->with('alert', ['type' => 'success', 'msg' => 'Device Switch Schema Updated Successfully']);
	}

	public function delete($id)
	{
		DB::table('switch_devices')->where('id',$id)->delete();
		return redirect()->back()->with('alert', ['type' => 'success', 'msg' => 'Device Switch Schema Deleted Successfully']);
	}
}