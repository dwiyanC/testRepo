@extends('layout.app')

@section('title', 'Edit Item')


@section('content')

        <div class="row">
            <div class="col-sm"></div>
            <div class="col-sm">
                <h2 style="margin-top:10px"> Edit Item </h2>
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form method="POST" action="/updateItem/{{$item -> id}}">
                @csrf
                <div class="form-group" style="margin-top:10%">
                    <label for="item_name">Item Name</label>
                    <input type="text" class="form-control" name="unit_name" value="{{$item -> unit_name }}">
                    <small class="text-danger">{{ $errors->first('unit_name') }}</small>
                </div>
                <div class="form-group">
                    <label for="item_type">Item Type</label>
                    <select class="custom-select custom-select-sm" name="unit_type" required>
                    @foreach ($itemCategories as $category)
                            <option value="{{$category -> type_names}}"> {{$category -> description}} </option>
                    @endforeach 
                    </select>
                </div>
                <div class="form-group">
                    <label for="item_no">Item Number</label>
                    <input type="text" class="form-control" name="unit_no" value="{{$item -> unit_no }}">
                    <small class="text-danger">{{ $errors->first('unit_no') }}</small>
                </div>
                <button type="submit" class="btn btn-warning" name="item_update">Update</button>
            </form> 
            </div>
            <div class="col-sm"></div>
        </div>


@endsection