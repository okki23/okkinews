
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>OkkiNews - Miniblog Sederhana</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">OkkiNews</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                         
                        {{-- <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Blog</a></li> --}}
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
        <!-- Page header with logo and tagline-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">Welcome to OkkiNews!</h1> 
                    <p class="lead mb-0">MiniBlog simpel sederhana</p>
                </div>
            </div>
        </header>
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    <!-- Featured blog post-->
                    <div class="card mb-4">
                        @foreach ($datalist as $key=>$val)  
                            @if($val->is_headline == 1)
                            <a href="{{ url('details/'.$val->id)}}"><img class="card-img-top" src="{{ asset('uploads/'.$val->image) }}" alt="..." /></a>
                            <div class="card-body">
                                <div class="small text-muted">Posted on {{ $val->pubdate }} by {{ $val->authors }}</div>
                                <h2 class="card-title">{{ $val->title }}</h2>
                                <p class="card-text">{{ substr($val->content,0,200) }} ... </p>
                                <a class="btn btn-primary" href="{{ url('details/'.$val->id)}}">Read more →</a>
                            </div>
                            @endif
                        @endforeach
                        
                    </div>
                    <!-- Nested row for non-featured blog posts-->
                    <div class="row">
                        <div class="col-lg-6"> 
                            @foreach ($datalist as $kex=>$vax) 
                            @if($vax->id % 2 != 0)
                                <div class="card mb-4">
                                    <a href="{{ url('details/'.$vax->id)}}"><img class="card-img-top" src="{{ asset('uploads/'.$vax->image) }}" alt="..." /></a>
                                    <div class="card-body">
                                        <div class="small text-muted"> {{ $vax->pubdate }}</div>
                                        <h2 class="card-title h4">{{ $vax->title }}</h2>
                                        <p class="card-text">{{ substr($vax->content,0,80) }} ....</p>
                                        <a class="btn btn-primary" href="{{ url('details/'.$vax->id)}}">Read more →</a>
                                    </div>
                                </div>
                            @endif
                            @endforeach
                            {{-- ganjil --}} 
                        </div>

                        <div class="col-lg-6">
                            @foreach ($datalist as $kex=>$vax) 
                            @if($vax->id % 2 == 0)
                                <div class="card mb-4">
                                    <a href="{{ url('details/'.$vax->id)}}"><img class="card-img-top" src="{{ asset('uploads/'.$vax->image) }}" alt="..." /></a>
                                    <div class="card-body">
                                        <div class="small text-muted"> {{ $vax->pubdate }}</div>
                                        <h2 class="card-title h4">{{ $vax->title }}</h2>
                                        <p class="card-text">{{ substr($vax->content,0,80) }} ....</p>
                                        <a class="btn btn-primary" href="{{ url('details/'.$vax->id)}}">Read more →</a>
                                    </div>
                                </div>
                            @endif
                            @endforeach
                            {{-- genap --}} 
                        </div>
                        
                    </div>
                    <!-- Pagination-->
                    sdsd
                    {!! $datalist->withQueryString()->links('pagination::bootstrap-5') !!}
                    {!! $datalist->withQueryString()->links() !!}     
                    <br>
                    {{-- <nav aria-label="Pagination">
                        <hr class="my-0" />
                        <ul class="pagination justify-content-center my-4">
                            <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Newer</a></li>
                            <li class="page-item active" aria-current="page"><a class="page-link" href="#!">1</a></li>
                            <li class="page-item"><a class="page-link" href="#!">2</a></li>
                            <li class="page-item"><a class="page-link" href="#!">3</a></li>
                            <li class="page-item disabled"><a class="page-link" href="#!">...</a></li>
                            <li class="page-item"><a class="page-link" href="#!">15</a></li>
                            <li class="page-item"><a class="page-link" href="#!">Older</a></li>
                        </ul>
                    </nav> --}}
                    <br>
                    <hr>
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
    </body>
</html>
