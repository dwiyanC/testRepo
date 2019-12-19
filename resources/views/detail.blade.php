@php //$base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/'; @endphp

@extends('layout.app')

@section('title', 'Item Details')

@section('content')
<div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card" style="margin-top:20px">
                <div class="card-header">
                    <h2 style="margin-top:10px">Item Details</h2>
                </div>
                <div class="card-mb-3" style="max-width:540px">
                    <div class="d-flex flex-row bd-highlight mb-3">
                        <div class="col-md-4">
                        @if (!$mainImage)
                        <img src='{{ url("img/images.png") }}' class="card-img" style="max-width:240px; margin:25px">
                        @else
                        <img src = '{{ Storage::url("itemImages/{$mainImage->image_name}") }}' class="card-img" style="max-width:240px; margin:25px" onerror="this.onerror=null;this.src='/img/images.png';">  
                        @endif   
                           @can ('isAdmin')
                            @if (!$mainImage)
                            <form method="POST" action="/addImage/{{$item->id}}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" class="float-center" name="unit_image" id="unit_image">
                            <button type="submit" class="btn btn-info btn-success">Add Image</button>
                            </form>
                            @else
                            <form method="POST" action="/updateMainImage/{{$item->id}}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" class="float-center" name="unit_image" id="unit_image">
                            <button type="submit" class="btn btn-info btn-warning">Change Image</button>
                            </form>
                            @endif
                           @endcan
                        </div>
                        <div class="col-md-8">
                            <div class="card-body" style="margin-left:20px">
                                <h4 class="card-title"> {{ $item-> unit_name }} </h4>
                                <p class="card-text text-muted"> {{ $item-> unit_type }} </p>
                                <p class="card-text text-muted"> Number: {{ $item-> unit_no }} </p>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                <form method="POST" action="/addCarouselImages/{{$item->id}}" enctype="multipart/form-data">
                @csrf
                    <li class="list-group-item"> <h5>Add Images </h5><input type="file" class="float-center btn-small btn-info" name="carousel_images[]" id="carousel_image" multiple>
                    <button type="submit" class="btn btn-info btn-warning">Add</button>
                    {{-- <a href="/addCarouselImages/{{$item->id}}" class="btn btn-success btn-small" style="margin:5px">+</a> --}}
                    </li>
                </form> 
                <li class="list-group-item">
                <div class="row">

                    {{--CAROUSEL--}}
                    @if (count($image) < 1)
                        <h4>No image </h4>
                    @else

                    <div id="imageCarousel" class="carousel slide" data-ride="carousel" style="width:80% height:80%">
                        <div class="carousel-inner">
                                @foreach($image as $idx => $img)
                                    @if (!$img->main_image)
                                        <div class="carousel-item {{ $idx == 0 ? 'active' : '' }}" style="width:400px; height:400px">
                                            <img class="d-block w-20" src='{{ Storage::url("itemImages/{$img->image_name}") }}'  alt="">
                                        </div>
                                    @endif
                                @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    @endif
                </div>
                </li>
                </ul>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"> <h5>Add Comment</h5> </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-10">
                                <form method="POST" action="/addComment/{{$item -> id}}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control" name="comment">
                                    <input type="hidden" class="form-control" name="itemID" value="{{ $item -> id }}">
                                </div>
                            </div>
                            <div class="col-2">
                                
                                <button type="submit" class="btn btn-primary btn-small float-right" name="SUBMIT">Submit</button>
                            </div>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="d-flex p-2 bd-highlight"><h4 style="margin-top:10px"> Comments </h4></div>
           {{-- <div class="container" name="commentContainer">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    @foreach ($comments as $comment)
                        <div class="d-flex justify-content-sm-left">
                            <div class="p-2 bd-highlight">{{$comment->comment}}</div>
                        <div>
                        <div class="d-flex justify-content-sm-end">
                            <div class="p-2 bd-highlight float-right text-muted" style="font-size:8pt">{{$comment->date_added}}</div>
                        </div>
                    @endforeach
                    </div>
                <div class="col-md-2"></div> --}}
            

            <table class="table table-striped thead-dark" style="margin-top:20px">
                <tr>
                    <th>  </th>
                    <th class="float-right"> Date Added </th>
                </tr>
                <tr>
                @foreach ($comments as $comment)
                    <td > {{$comment -> comment}} </td>
                    <td class="float-right"> {{$comment -> created_at}} </td>
                </tr>
                @endforeach
            </table>

        </div>
        <div class="col-md-2"></div>

</div>


@endsection



{{-- <img src = '{{ Storage::url("itemImages/item-image{$item->id}.png") }}' class="card-img" style="max-width:240px; margin:25px" onerror="this.onerror=null;this.src='/img/images.png';"> --}}
                           {{--  <img src='{{ $base_url . "img/images.png" }}' class="card-img" style="max-width:240px; margin:25px"> --}}
