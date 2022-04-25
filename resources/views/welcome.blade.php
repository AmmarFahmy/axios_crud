<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Axios CRUD</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Axios CRUD</h1>
        <hr>
        <div class="row">
            <div class="col-8">
                <h4>Manage Category</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
            <div class="col-4">
                <h4>Add New Category</h4>
                <form action="" id="addNewDataForm">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" placeholder="Name">
                        <span id="error" class="text-danger"></span>
                    </div>
                    <br>
                    <div class="d-grid gap-2">
                        <button class="btn btn-success btn-lg">Add New Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- edit --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editDataForm">
                        <div class="form-group">
                            <input type="text" class="form-control" id="e_name">
                            <input type="hidden" id="e_id">
                            <span id="error" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-block btn-success mt-2" type="submit">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- view --}}
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="">
                        <div class="form-group">
                            <input type="text" class="form-control" id="e_name">
                            <input type="hidden" id="e_id">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>

    <script>
        let url = window.location.origin

        function table_data_row(data) {
            var rows = '';

            $.each(data, function(key, value) {
                value.id
                rows += '<tr>';
                rows += '<td>' + (key + 1) + '</td>';
                rows += '<td>' + value.name + '</td>';
                rows += '<td data-id="' + value.id + '" class="text-center">';

                rows += '<a class="btn btn-primary btn-sm" id="editRow" data-id="' + value.id +
                    '" data-toggle="model" data-target="#editModal">Edit</a>';
                rows += '<a class="btn btn-sm btn-danger text-light m-1" id="deleteRow" data-id="' + value.id +
                    '">Delete</a>';
                rows +=
                    '<a class="btn btn-sm btn-success text-light mx-1" data-toggle="model" data-target="#viewModal" id="viewRow" data-id="' +
                    value.id + '">View</a>';

                rows += '</td>';
                rows += '</tr>';
            });
            $("#tbody").html(rows);
        }

        $('body').on('click', '#editRow', function(e) {
            // alert('1');
            $('#editModal').modal('show');
        })

        $('body').on('click', '#viewRow', function(e) {
            // alert('1');
            $('#viewModal').modal('show');
        })


        function getAllData() {
            axios.get("{{ route('get-all-cat') }}")
                .then(function(res) {
                    table_data_row(res.data);
                    // console.log(res.data);
                })
        }
        getAllData();

        function formReset() {
            $('#addNewDataForm').trigger('reset');
        }

        //store 
        $('#addNewDataForm').on('submit', function(e) {
            e.preventDefault();

            axios.post("{{ route('category.store') }}", {
                    name: $('#name').val(),
                })
                .then(function(response) {
                    // getAllData();
                    getAllData();
                    $('name').val('');
                    $('#error').text('');
                    // Swal.fire('Saved!', '', 'success');
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'success',
                        title: 'Saved successfully'
                    })
                    formReset();
                })

                .catch(function(error) {
                    // console.log(error);
                    Swal.fire('Name already exist!', '', 'error');

                    if (error.response.data.errors.name) {
                        $('#error').text(error.response.data.errors.name[0]);
                    }
                });
        });


        //delete
        $('body').on('click', '#deleteRow', function(e) {
            e.preventDefault();
            let id = $(this).data('id')

            axios.delete(`${url}/category/${id}`)
                .then(function(r) {
                    getAllData();
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'warning',
                        title: 'Deleted Successfully'
                    })

                });

        });


        //edit
        $('body').on('click', '#editRow', function() {
            let id = $(this).data('id');
            let edit = url + '/category' + '/' + id + '/edit'
            // console.log(url);
            axios.get(edit)
                .then(function(res) {
                    console.log(res);
                    $('#e_name').val(res.data.name)
                    $('#e_id').val(res.data.id)
                })
        })

        //update
        $('body').on('submit', '#editDataForm', function(e) {
            e.preventDefault()
            let id = $('#e_id').val()
            let data = {
                id: id,
                name: $('#e_name').val(),
            }
            let path = url + '/category' + '/' + id
            axios.put(path, data)
                .then(function(res) {
                    getAllData();
                    $('#editModal').modal('toggle')
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated Successfully'
                    })
                })
        })

        //view
        $('body').on('click', '#viewRow', function() {
            let id = $(this).data('id');
            let view = url + '/category' + '/' + id + '/edit'
            console.log(view);
            // console.log(url);
            axios.get(view)
                .then(function(res) {
                    console.log(res);
                    $('#e_name').val(res.data.name)
                    $('#e_id').val(res.data.id)
                })
        })
    </script>


</body>

</html>
