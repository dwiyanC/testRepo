@extends('layout.app')

@section('title', 'User Registration')

@section('content')


        <div class="row">
            <div class="col-sm-2">
        </div>
        <div class="col-sm-8">
            <!-- <h2 style="margin-top:10px"> Add Item </h2> -->
            <div class="card" style="margin-top:20px">
                <div class="card-header">
                    <h2 style="margin-top:10px"> User Registration </h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="/storeRegistration">
                    @csrf
                    <div class="form-group" style="margin-top:10%">
                        <label for="unit_name">Item Name</label>
                        <input type="text" class="form-control" name="unit_name">
                        <small class="text-danger">{{ $errors->first('unit_name') }}</small>
                    </div>


                    <div class="form-group">
                        <label for="unit_number">Item Number</label>
                        <input type="text" class="form-control" name="UNIT_NUMBER">
                        <small class="text-danger">{{ $errors->first('UNIT_NUMBER') }}</small>
                    </div>


                    <button type="submit" class="btn btn-primary" name="SUBMIT">Submit</button> <!-- route this to /itemAdd indexController@itemStore -->
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
        </div>

@endsection