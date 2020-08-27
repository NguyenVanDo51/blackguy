@extends('templade.app')

@section('title', 'Danh mục ' . $category->name)

@section('content')
    <div class="container mt-5">
        <div class="row">
            <h3>Hiển thị ({{$courses->total()}}) khoa hoc trong danh mục: '{{$category->name}}'.</h3>
            <x-ListItem :courses="$courses" height="10"/>
        </div>
        <div class="mx-auto mt-4">
            {{$courses->links()}}
        </div>
    </div>
@endsection

