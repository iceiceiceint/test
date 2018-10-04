@extends('master')
@section('title','Trang Chủ')
@section('csrf-token')
     name="csrf-token" content="{{ csrf_token() }}"
@endsection
@section('dashboard-css')
    rel="stylesheet" type="text/css" href="{{ asset('/css/frontend/dashboard.css') }}"
@endsection
@section('content')
    @if (Auth::check())
        <div class="col-md-6">
            <p>Chào, <span style="font-size: 3rem!important;font-weight: bold;">{{ Auth::user()->username }}</span></p>
        </div>
        <div class="col-md-6 pull-right" style="margin-top: 3px;width:auto;"><a class="btn btn-primary" href="{{route('auth.getLogOut')}}">Đăng xuất</a></div>

    @endif
@endsection
@section('todolist-content')
    <?php //Hiển thị thông báo thành công?>
    @if ( Session::has('success') )
        <div class="alert alert-success alert-dismissible" role="alert">
            <strong>{{ Session::get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
        </div>
    @endif
    <?php //Hiển thị thông báo lỗi?>
    @if ( Session::has('error') )
        <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>{{ Session::get('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button style="top: -55px!important;right: -28px!important;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
        </div>
    @endif
    <div id="myDIV" class="header">
        <h2 style="margin:5px">Danh sách công việc cần làm</h2>
        <form style="display:inline;" id="add-task-form" action="{{ route('task.postAddTask') }}" method="post" role="form">
            {{csrf_field()}}
        <input type="text" name="name" id="myInput" placeholder="Công việc cần làm...">
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            <input type="submit" tabindex="4" class="addBtn" value="Thêm">
        </form>
    </div>

    <ul id="myUL">
        {{--{{ $task }}--}}
        @foreach($task as $item)
            <li class="task-ddd-{{$item->id}}">
                <input id="task-content-{{$item->id}}" class="task-ddd-{{$item->id}} task-{{$item->id}}" disabled type="text" value="{{$item->name}}">
            <span class="glyphicon glyphicon-remove addTask" ></span>
            <span class="editTask-{{$item->id}} glyphicon glyphicon-edit" onclick="editTask({{$item->id}})" ></span>
                <a href="/dashboard"> <span style="display: none" class="cancelEditTask-{{$item->id}} glyphicon glyphicon-repeat"></span></a>
                <span style="display: none" class="confirmEditTask-{{$item->id}} glyphicon glyphicon-ok" onclick="confirmEditTask({{$item->id}})"></span>
            </li>
            @endforeach
        <div class="content-msg"></div>

    </ul>
    <div class="paginate" style="text-align: center;">{{ $task->render() }}</div>
@endsection

