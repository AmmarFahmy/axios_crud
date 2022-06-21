<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>POS</title>
</head>

<body>
    <div class="container mt-5">
        <hr>
        <div class="row">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add New Data
            </button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Data Form</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="addNewDataForm">
                                <div class="form-group">
                                    <div>
                                        @component('components.forms.inputbox', ['id' => 'name', 'col_size' => 'col-lg-12', 'name' => 'name', 'text' => 'Full Name', 'class' => '', 'placeholder' => 'Full Name', 'required_icon' => true, 'value' => '', 'onkeyup' => '', 'verticle' => false])
                                        @endcomponent
                                    </div>
                                    <div>
                                        @component('components.forms.inputbox', ['id' => 'email', 'col_size' => 'col-lg-12', 'name' => 'email', 'text' => 'Email', 'class' => '', 'placeholder' => 'Email', 'required_icon' => true, 'value' => '', 'onkeyup' => '', 'verticle' => false])
                                        @endcomponent
                                    </div>
                                    <span id="error" class="text-danger"></span>
                                </div>
                                <br>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-success">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="">
                <h4>Manage</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    <tbody id="tbody">

                    </tbody>
                </table>
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
                            <input type="text" class="form-control" id="e_email">
                            <input type="hidden" id="e_id">
                            <span id="error" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-block btn-success mt-2" type="submit">Update Data</button>
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
                            <input type="text" class="form-control" id="v_name" readonly>
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
                rows += '<td>' + value.email + '</td>';
                rows += '<td data-id="' + value.id + '" class="text-center">';

                rows += '<a class="btn btn-primary btn-sm" id="editRow" data-id="' + value.id +
                    '" data-toggle="model" data-target="#editModal">Edit</a>';
                rows += '<a class="btn btn-sm btn-danger text-light m-1" id="deleteRow" data-id="' + value.id +
                    '">Delete</a>';
                rows +=
                    '<a class="btn btn-sm btn-success text-light" data-toggle="model" data-target="#viewModal" id="viewRow" data-id="' +
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
                    email: $('#email').val(),
                })
                .then(function(response) {
                    // getAllData();
                    getAllData();
                    $('name').val('');
                    $('email').val('');
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
                    // Swal.fire('Empty Field!', '', 'error');
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
                        icon: 'error',
                        title: 'Duplicated Category'
                    })

                    if (error.response.data.errors.name) {
                        $('#error').text(error.response.data.errors.name[0]);

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
                            icon: 'error',
                            title: 'The name field is required'
                        })
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
                    $('#v_name').val(res.data.name)
                    $('#e_id').val(res.data.id)
                })
        })
    </script>


</body>

</html>
