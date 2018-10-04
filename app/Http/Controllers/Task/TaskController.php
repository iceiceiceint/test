<?php

namespace App\Http\Controllers\Task;

use App\Http\Requests\Task\TaskRequest;
use App\Task;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    protected function create(array $data)
    {
//        dd($data);
        return Task::create([
            'name' => $data['name'],
            'user_id' => $data['user_id']
        ]);
    }

    public function getTask()
    {
        $task = Task::orderBy('created_at', 'DECS')->paginate(10);

        return view('frontend.dashboard')->with('task', $task);
    }

    public function postAddTask(TaskRequest $request)
    {
//        dd($request);
        $data = $request->all();
        $validator = Validator::make([$data], []);
//        dd($validator);
        if ($validator->fails()) {
            return redirect('/dashboard')->withErrors($validator)->withInput();
        } else {
            if ($this->create($data)) {
                Session::flash('success', 'Thêm công việc mới thành công');
                return redirect('/dashboard');
            } else {
                Session::flash('fail', 'Thêm công việc mới thất bại');
                return redirect('/dashboard');
            }
        }
    }

    protected function update(array $data, int $id)
    {
        $data_update = false;
        try {
            $task = Task::find($id);
            $data_update = $task->update([
                'name' => $data['name']
            ]);
            return $data_update;
        } catch (\Exception $e) {
            return $data_update;
        }
    }

    public function editTask(TaskRequest $request, int $id)
    {
        $data = $request->all();
        if ($this->update($data, $id)) {
            $response = [
                'status' => 'success',
                'msg' => 'Cập nhật công việc thành công',
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => 'errors',
                'msg' => 'Cập nhật công việc thất bại'
            ];
            return response()->json($response);
        }
    }

    protected function delete(int $id)
    {
        $data_delete = false;
        try{
            $task = Task::find($id);
            $task->delete();
            return $data_delete;
        }catch (\Exception $e){
            return $data_delete;
        }
    }
    public function deleteTask(int $id)
    {
        if($this->delete($id)){
            $response = [
                'status' => 'success',
                'msg' => 'Xóa công việc thành công',
            ];
            return response()->json($response);
        }else{
            $response = [
                'status' => 'errors',
                'msg' => 'Xóa công việc thất bại',
            ];
            return response()->json($response);
        }
    }
}
