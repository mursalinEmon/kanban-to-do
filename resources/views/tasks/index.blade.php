@extends('layouts.app')

@section('content')
<div class="container">
    <Task-List :statuses = "{{ $statuses }}" :allTasks = "{{ $all_tasks }}"></Task-List>
</div>
@endsection
