<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>


    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="#">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled">Disabled</a>
                </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>



    <!-- Modal -->
    <div class="modal fade" id="Add_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" id="upload_form">
                    @csrf
                    <div class="modal-body">
                        <ul id="form_errlist"></ul>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter email" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter name" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Date of joining</label>
                            <input type="date" class="form-control" name="dateofjoin" id="dateofjoin"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Date of leaving</label>
                            <input type="date" class="form-control" name="dateofleaving" id="dateofleaving"
                                aria-describedby="emailHelp">
                        </div>
                        <div>
                            <input type="checkbox" name="still_work" id="still" value="Still working" style="margin-bottom: 20px">
                            <label for="checkbox" class="form-label">Still Working</label>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" name="file" id="file"
                                aria-describedby="emailHelp">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary add_user ">Submit</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="text" id="del_id">
                    <h4>Are you sure ? want to delete this data ?</h4>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary delete">Delete</button>
                </div>
            </div>
        </div>
    </div>




    <div id="success_message"></div>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <button class="btn btn-primary" id="add_btn"> Add new</button>
                <hr>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Avatar</th>
                        <th scope="col">Name</th>
                        <th scope="col">email</th>
                        <th scope="col">Experience</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody id="user_tbl">

                </tbody>
            </table>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            FetchUsers();

            function FetchUsers() {
                $.ajax({
                    type: "Get",
                    url: "{{ route('user.fetch') }}",
                    dataType: "json",
                    success: function(response) {
                        //console.log(response.diff);
                        $('#user_tbl').html('');
                        var li = '';
                        $.each(response.users, function(key, item) {
                            li += '<tr>';
                            li += '<td><img  src="{{ asset('image') }}/' + item.image +
                                '"  height="70px" width="70px" style="border-radius: 70px"  /></td>';
                            li += '<td>' + item.name + '</td>';
                            li += '<td>' + item.email + '</td>';
                            li += ' <td id="ex">' + item.experience + '</td>';
                            li += ' <td><button class=" btn btn-danger delete_btn" value="' +
                                item.id + '">Delete</button></td>';
                            li += '</tr>';
                        });
                        $('#user_tbl').append(li);


                    }
                });
            }



            $(document).on('click', '#add_btn', function(e) {
                e.preventDefault();
                $('#Add_modal').modal('show')
            });



            $('#upload_form').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                // console.log(formData);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "{{ url('add') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        //console.log(response)
                        if (response.status == 400) {
                            $('#form_errlist').html('')
                            $('#form_errlist').addClass('alert alert-danger')
                            $.each(response.errors, function(key, err_values) {
                                $('#form_errlist').append('<li>' + err_values +
                                    '</li>')
                            });

                        } else {
                            $('#form_errlist').removeClass('alert alert-dander');
                            $('#form_errlist').html('');
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#Add_modal').modal('hide');
                            $('#Add_modal').find('input').val('');

                            FetchUsers();
                        }
                    }
                });
            });


            $(document).on('click', '.delete_btn', function(e) {
                e.preventDefault();
                var delete_id = $(this).val();
                //alert(delete_id)
                $('#del_id').val(delete_id);

                $('#deleteModal').modal('show')
            });

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();

                var user_id = $('#del_id').val()
                //console.log(id);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "get",
                    url: "{{ url('delete') }}" + '/' + user_id,
                    success: function(response) {
                        //console.log(response)
                        $('#success_message').text(response.message);
                        $('#success_message').addClass('alert alert-success');
                        $("#deleteModal").modal('hide');
                        FetchUsers();
                    }
                });
            });



                $("#still").click(function() {
                    $("#dateofleaving").attr('disabled', !$("#dateofleaving").attr('disabled'));
                    // $("#dateofleaving").removeClass("grey");


                });

                $("#dateofleaving").click(function() {
                    $("#still").attr('disabled', !$("#still").attr('disabled'));
                    // $("#dateofleaving").removeClass("grey");


                });


        });
    </script>


</body>

</html>
