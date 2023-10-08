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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="_token" content="{{ csrf_token() }}" >

</head>
<body>

<div class="bg-primary">
    <div class="container py-3">
        <h3 class="text-light">List</h1>
    </div>
</div>
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
<div class="card-tools">
    <form action="" method="get">
        <div class="row mt-5">
            <div class="col-md-8">
            </div>
            <div class="col-md-2">
                <div class="input-group  mr-0" >
                    <input type="text" value="{{ Request::get('keyword') }}" name="keyword" class="form-control " placeholder="Search">
                    <div class="input-group-append">
                        <button class="btn btn-default" type="submit"> <i class="fa fa-search"></i> </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="container">
    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="5" > ID</th>
                    <th width="20" >Name</th>
                    <th width="20" >Image</th>
                    <th width="40" >description</th>
                    <th width="10" >Date</th>
                    <th width="5" >Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($services))
                @foreach( $services as $service)
                <tr>
                    <td>{{$service->id}}</td>
                    <td>{{$service->name}}</td>
                    <td><img src="{{ asset('uploads/services/thumb/small/'.$service->image) }}" width="100" alt=""> </td>
                    <td>{!! Str::of(strip_tags((string) $service->description))->words(58) !!}</td>
                    <td> {{ date('d-M-Y', strtotime($service->created_at)) }}</td>
                    <td> 
                        <div class="row">
                            <div class="col-md-6">
                            <a href="{{ route('service.edit',$service->id) }}" class="btn btn-success">edit<span><i class="fa fa-edit"></i></span></a>

                            </div>
                            <div class="col-md-6">
                            <a href="{{ route('service.delete',$service->id) }}" onclick='return confirm("Are you sure You Want to Delete it");' class="btn btn-danger">delete<span><i class="fa fa-trash"></i></span></a>

                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr><td style="text-align:center" colspan="6">Records Not Found</td></tr>
                @endif

            </tbody>
        </table>
    </div>
    <div class="row">
        {{ $services->links('pagination::bootstrap-4') }}
    </div>
</div>


<!-- dropzone -->


        <!-- editor -->


</body>
</html>