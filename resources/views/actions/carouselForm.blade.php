@extends('layout.app')

@section('title', 'Add Item')

@section('content')

<h3 class="well">Laravel 6 Multiple File Upload</h3>

<form method="post" action="{{url('file')}}" enctype="multipart/form-data">

  {{csrf_field()}}


    <div class="input-group hdtuto control-group lst increment" >

      <input type="file" name="filenames[]" class="myfrm form-control">

      <div class="input-group-btn"> 

        <button class="btn btn-success" type="button"><i class="fldemo glyphicon glyphicon-plus"></i>Add</button>

      </div>

    </div>

    <div class="clone hide">

      <div class="hdtuto control-group lst input-group" style="margin-top:10px">

        <input type="file" name="filenames[]" class="myfrm form-control">

        <div class="input-group-btn"> 

          <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>

        </div>

      </div>

    </div>


    <button type="submit" class="btn btn-success" style="margin-top:10px">Submit</button>


</form>        

</div>


<script type="text/javascript">

    $(document).ready(function() {

      $(".btn-success").click(function(){ 

          var lsthmtl = $(".clone").html();

          $(".increment").after(lsthmtl);

      });

      $("body").on("click",".btn-danger",function(){ 

          $(this).parents(".hdtuto control-group lst").remove();

      });

    });

</script>



@endsection