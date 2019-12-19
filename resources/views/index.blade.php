@php //$base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/'; @endphp
@php //$base_url = 'http://localhost:8000/'; @endphp

@extends('layout.app')

@section('title', 'Inventory List')

@section('content')



<div class="container">
        <div class="row"></div>
        <div class="col-12" style="margin:25px"></div>
</div>
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <!-- <button type="button" data-toggle="modal" data-target="#modalTest" class="btn btn-primary btn-success float-right" styles="margin-top:10%">test modal</button> -->
            <table class="table table-striped thead-dark" style="margin-top:50px">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Item no</th>
                    <th>Date Added</th>
                    <th>Last Edit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td> {{ $item-> id }} </td>
                    <td> {{ $item-> unit_type }} </td>
                    <td> {{ $item-> unit_name }} </td>
                    <td> {{ $item-> unit_no }} </td>
                    <td> {{ $item-> created_at }} </td>
                    <td> {{ $item-> updated_at }} </td>
                    <td><a class='btn btn-info btn-sm' href='{{ url("/details", [$item->id]) }}'>Details</a>
                    @can ('isAdmin')
                        <a class='btn btn-warning btn-sm' href='{{ url("/edit", [$item->id]) }}'>Edit</a>
                        <a class='btn btn-danger btn-sm' href='{{ url("/delete", [$item->id]) }}'>Delete</a>
                    @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>


            </table>
 
            {{ $items->links() }}
            
 
        </div>
            <div class="col-1"></div>
    </div>

@endsection