
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" /> 
        <title>OkkiNews - Miniblog Sederhana</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
         
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

        
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
   
        <!-- Page content-->
        <div class="container">
          
        <div class="col-lg-12">
            <h3 style="text-align: center;"> Selamat Datang Administrator</h3>
            
            <button class="btn btn-primary" onclick="AddData();"> 
                <div class="nav-link-icon"><i data-feather="archive"></i></div> &nbsp;
                Tambah Data
             </button>
             <br>
             &nbsp;
             <table id="example">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Authors</th>
                        <th>Publish Date</th> 
                        <th>Actions</th>
                    </tr>
                </thead>
              
                <tbody>
                    
                </tbody>
            </table>
            
        </div>
          
        </div>


         <!-- Modal -->
    <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" id="my-form">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Title</label>
                            <input class="form-control onlytext" id="title" name="title" type="text">
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Content</label>
                            <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
                            {{-- <input class="form-control"  type="text"> --}}
                        </div>
                        
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputPhone">Headline</label>
                                <select class="form-control" name="is_headline" id="is_headline"> 
                                    <option value="1">Ya</option>
                                    <option value="2">Tidak</option> 
                                </select>
                            </div>

                            <div class="col-md-6"> 
                                <label class="small mb-1" for="inputLastName">Image Picture</label>
                                <input type="file" name="foto" id="foto" class="form-control">
                            </div> 
                            
                        </div>
                          
                    </form>
                </div>



            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                <div class="nav-link-icon"><i data-feather="x-square"></i></div> &nbsp;
                Close
            </button>
            <button type="button" class="btn btn-primary" onclick="SimpanData();">
                <div class="nav-link-icon"><i data-feather="database"></i></div> &nbsp;
                Simpan
            </button>
            </div> 
        </div>
        </div>
    </div>


        <!-- Footer-->
      
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script>
          
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });

            $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('post_list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'title', name: 'title'},
                {data: 'authors', name: 'authors'},
                {data: 'pubdate', name: 'pubdate'}, 
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ]
        });
            function clearinput(){
                $("input").val(""); 
                
            }
            function SimpanData(){
                var form = $('#my-form')[0]; 
                var post = new FormData(form);  
                $.ajax({ 
                    type: "POST", 
                    enctype: 'multipart/form-data', 
                    url:"{{ route('savepost') }}", 
                    data: post, 
                    processData: false, 
                    contentType: false,  
                    success: function (data) { 
                        console.log("SUCCESS : ", data); 
                        $('#myModal').modal('hide'); 
                        $('#example').DataTable().ajax.reload();  
                        clearinput();
                    },
        
                    error: function (e) { 
                        console.log("ERROR : ", e);  
                        $('#myModal').modal('hide'); 
                        $('#example').DataTable().ajax.reload() 
                    } 
            
                });  
            }
            function AddData(){ 
                $('#myModal').modal('show');   
                clearinput();
            
            } 

            function DeleteData(id){
        if(confirm('Anda yakin ingin menghapus data ini?')){
            $.ajax({
            url : "{{ route('post_destroy') }}",
            type: "POST",
            data: {id:id},
            success: function(data)
            { 
               $('#example').DataTable().ajax.reload();  
            
			    
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
        }
    }
    
    function UbahData(id){ 
        $('#myModal').modal('show');  
        $.ajax({
            url : "{{ route('post_get_data') }}",
            type: "POST",
            data: {id:id},
            success: function(data)
            {  
                // console.log(data);
                $("#id").val(data.id);
                $("#title").val(data.title);
                $("#authors").val(data.authors);
                $("#content").val(data.content); 
                $("#is_headline").val(data.is_headline);
                

                if(data.foto != null || data.foto != ''){
                    image = new Image();
                    image.src = '{{ asset('uploads/') }}/'+data.foto;
                    image.style.width = '50%';
                    image.style.height = '50%';  
                    $("#pict_view").empty().append(image);
                    $("#foto").css({"margin-top":"5%"})
                } 
            } 
        });
    }
        </script>
    </body>
</html>
