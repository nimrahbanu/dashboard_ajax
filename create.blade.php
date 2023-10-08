<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
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
<div class="col-md-3"><a href="{{route('service.list')}}" class="btn btn-primary">List</a>
</div>  <div class="card-body card-shadow-lg">
                <form action="" id="serviceCreateform" name="serviceCreateform" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="name" placeholder="name" class="name form-control">
                            <p class="error name-error text-danger"></p>
                        </div> 
                        <div class="col-md-12">
                            <textarea class="summernote" name="description"></textarea>
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
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary" id="submit" type="submit">create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- dropzone -->


        <!-- editor -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
          $('.summernote').summernote();
        });
    </script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link
  rel="stylesheet"
  href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"
  type="text/css"
/>
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

$("#serviceCreateform").submit(function(event){
    event.preventDefault();
    $('#submit').prop('disabled',true);

    $.ajax({
        url : '{{ route("service.create") }}',
        type : 'post',
        dataType : 'json',
        data : $('#serviceCreateform').serializeArray(),
        success: function(response){
            if(response.status == 200){
                $('#submit').prop('disabled', false);
          window.location.href = "{{ route('service.create')}}";
                // no error
            }else{
                //here is errors
                $('.name-error').html(response.error.name);
                $("input").keypress(function(){
                    $('.name-error').html('');
                });
            }
        
        }
    });
    });
</script>
</body>
</html>