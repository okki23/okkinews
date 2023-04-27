
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>OkkiNews - {{ $data->title }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" /> 
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
       <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">Okki News</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @if(Auth::user())
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">{{ Auth::user()->name }}</a></li>
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="{{ url('mypost') }}">My Post</a></li>
                        
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="{{ url('keluar') }}"> Logout </a></li>
                        @else  

                        <li class="nav-item"><a class="nav-link " aria-current="page" href="{{ url('signin') }}">Sign In</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Post content-->
                    <article>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post title-->
                            <h1 class="fw-bolder mb-1">{{ $data->title }}</h1>
                            <!-- Post meta content-->
                            <div class="text-muted fst-italic mb-2">Posted on {{ $data->pubdate }} by {{ $data->authors }}</div>
                            <!-- Post categories-->
                            {{-- <a class="badge bg-secondary text-decoration-none link-light" href="#!">Web Design</a>
                            <a class="badge bg-secondary text-decoration-none link-light" href="#!">Freebies</a> --}}
                        </header>
                        <!-- Preview image figure-->
                        <figure class="mb-4"><img class="img-fluid rounded" style="width: 900px; height:400px;" src="{{ asset('uploads/'.$data->foto) }}" alt="..." /></figure>
                        <!-- Post content-->
                        <section class="mb-5">
                            <p class="fs-5 mb-4" style="text-align: justify;"> {{ $data->content }}</p>
                        </section>
                    </article>
                    <!-- Comments section-->
                    @if(Auth::user())

                    
                    <section class="mb-5">
                        <div class="card bg-light">
                            <div class="card-body">
                                <!-- Comment form-->
                                <form class="mb-4" action="{{ url('comment')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="id_post" name="id_post" value="{{ Request::segment(2) }}">
                                    <input type="hidden" id="id_user" name="id_user" value="{{ Auth::user()->id }}">
                                    <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="Tulis komen anda disini"></textarea>
                                    <br>
                                    &nbsp;
                                    <button type="submit" class="btn btn-primary btn-block"> Comment</button>
                                </form>
                                <!-- Comment with nested comments-->
                                <h3>Komentar</h3>
                                <hr>

                                {{-- {{ dd($komen)}} --}}
                                @foreach($komen as $ky => $vy)
                                <div class="d-flex mb-4">
                                    <!-- Parent comment-->
                                    <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                    <div class="ms-3">
                                        <div class="fw-bold">{{ $vy->name }}</div>
                                        {{ $vy->comment }}
                                        &nbsp;
                                        @if($vy->idkomenuser == Auth::user()->id)
                                            <a href="javascript:void(0);" onclick="EditForm({{$vy->idkomen}});" class="btn btn-warning btn-sm">  Edit </a> &nbsp; 
                                            <a href="{{ url('delete_comment/'.$vy->idkomen )}}" class="btn btn-danger btn-sm">  Delete </a>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                               
                            
                            </div>
                        </div>
                    </section>
                    @else 
                    <section class="mb-5">
                        <div class="card bg-light">
                            <div class="card-body">
                                <!-- Comment form-->
                                
                                <!-- Comment with nested comments-->
                                <h3>Komentar</h3>
                                <hr>

                                {{-- {{ dd($komen)}} --}}
                                @foreach($komen as $ky => $vy)
                                <div class="d-flex mb-4">
                                    <!-- Parent comment-->
                                    <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                    <div class="ms-3">
                                        <div class="fw-bold">{{ $vy->name }}</div>
                                        {{ $vy->comment }}
                                         
                                    </div>
                                </div>
                                @endforeach
                               
                            
                            </div>
                        </div>
                    </section>
                    @endif
                    
                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    <!-- Search widget-->
                    <div class="card mb-4">
                        <div class="card-header">Search</div>
                        <div class="card-body">
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                                <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                            </div>
                        </div>
                    </div>
                    <!-- Categories widget-->
                    <div class="card mb-4">
                        <div class="card-header">Categories</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="#!">Web Design</a></li>
                                        <li><a href="#!">HTML</a></li>
                                        <li><a href="#!">Freebies</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="#!">JavaScript</a></li>
                                        <li><a href="#!">CSS</a></li>
                                        <li><a href="#!">Tutorials</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Side widget-->
                  
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
    
                    <div class="card-body">
                        <form method="POST" action ="{{ url('update_comment') }}" enctype="multipart/form-data" action id="my-form">
                            @csrf
                            <input type="text" name="idcommentdata" id="idcommentdata">
                            <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Comment</label>
                                <input class="form-control" id="commentdata" name="commentdata" type="text">
                            </div>
      
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                <div class="nav-link-icon"><i data-feather="x-square"></i></div> &nbsp;
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <div class="nav-link-icon"><i data-feather="database"></i></div> &nbsp;
                                Simpan
                            </button>
                        </form>
                    </div>
    
    
    
                </div>
                <div class="modal-footer">
                
                </div> 
            </div>
            </div>
        </div>

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; OkkiNews 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>

        <script>

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
                        
            function EditForm(id){
                $('#myModal').modal('show');   
                $.ajax({
                    url : "{{ route('get_comment') }}",
                    type: "POST",
                    data: {id:id},
                    success: function(data)
                    {  
                        
                        console.log(data.comment);
                        $("#commentdata").val(data.comment);
                        $("#idcommentdata").val(data.id);
                       
                    } 
                });
               
            }
        </script>
    </body>
</html>
