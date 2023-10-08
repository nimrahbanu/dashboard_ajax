<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
     <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/summernote-bs4.min.css')}}">
<meta name="_token" content="{{ csrf_token() }}" >
</head>
<body>

<div class="bg-primary">
    <div class="container py-3">
        <h3 class="text-light">Image Upload</h1>
    </div>
</div>
<div class="py-3">
    @if(Session::has('success'))
          <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
          @endif
          @if(Session::has('error'))
          <div class="alert alert-danger">
            {{Session::get('error')}}
          </div>
          @endif  
    <div class="container">
        <div class="card">
<div class="col-md-3 mt-3"><a href="{{route('service.list')}}" class="btn btn-primary">List</a>
</div>  <div class="card-body card-shadow-lg">
                <form action="" id="serviceEditform" name="serviceEditform" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="name" value="{{$services->name}}" class="name form-control">
                            <p class="error name-error text-danger"></p>
                        </div> 
                        <div class="col-md-12">
                            <textarea class="summernote" name="description">{!! $services->description !!}</textarea>
                        </div> 
                    </div> 
                    <div class="col-md-12 mt-5">
                    <input type="hidden" name="image_id" id="image_id">
                    <div class="dropzone dz-clickable" id="image">
                        <div class="dz-message needsclick">
                          <br>Drop files here or click to upload
                          <br><br>  
                        </div>
                    </div>
                    <div class="">
                    <span class="text-light deleteimage" style=" cursor: pointer; position: absolute; margin-right: -99px; z-index: 1; padding: 2px; border-radius: 0px 0px 15px 0px; background: red; ">Delete Image</span>    
                    <img class="img-thumbnail imgnone" width="200" src="{{ asset('uploads/services/thumb/small/'.$services->image) }}" alt="">
                    </div>    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary" type="submit" id="submit">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- dropzone -->


        <!-- editor -->

             <script src="{{ asset('js/bootstrap.bundle.min.js')}}" ></script>
             <script src="{{ asset('js/jquery.min.js')}}" ></script>
             <script src="{{ asset('js/summernote-bs4.min.js')}}" ></script>

<script type="text/javascript">
        $(document).ready(function() {
          $('.summernote').summernote();
        });
    </script>
             <script src="{{ asset('js/dropzone.min.js')}}" ></script>
<link  rel="stylesheet"  href="{{ asset('css/dropzone.min.css') }}"  type="text/css"/>
<script>
    Dropzone.autoDiscover = false;
    const dropzone = $('#image').dropzone({
        init: function(){
            this.on('addedfile', function(file){
                if(this.files.length > 1){
                    this.removeFile(this.files[0]);
                }
            });
        },
        url: " {{route('upload')}} ",
        maxFiles: 10,
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(file, response){
            $('#image_id').val(response.id);
        }
    });
</script>
<script>
  $.ajaxSetup({
    headers:{
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
  });

$("#serviceEditform").submit(function(event){
    event.preventDefault();
    $('#submit').prop('disabled',true);
    $.ajax({
        url : '{{ route("service.update",$services->id) }}',
        type : 'post',
        dataType : 'json',
        data : $('#serviceEditform').serializeArray(),
        success: function(response){
            console.log(response);
            if(response.status == 200){
                $('#submit').prop('disabled',false);
                 window.location.href = "{{ route('service.list')}}";

                // no error
            }else{
                console.log(response);
                //here is errors
                $('.name-error').html(response.error.name);
                $("input").keypress(function(){
                    $('.name-error').html('');
                });
            }
        
        }
    });
    });
    $(document).ready(function(){
    $('.deleteimage').click(function(){
        $('.imgnone').css('display', 'none');
        $('.deleteimage').css('display', 'none');
    });
    });
</script>
</body>
</html>