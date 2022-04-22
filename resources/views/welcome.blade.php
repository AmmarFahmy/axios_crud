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

    <button type="button" id="editRow" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
        Launch demo modal
    </button>
    <a class="btn btn-primary" id="editRow" data-toggle="model" data-target="#editModal">Edit</a>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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
                rows += '<button type="button" class="btn btn-primary" id="editRow" data-id="' + value.id +
                    '" data-toggle="model" data-target="#editModal">Edit</button>';
                rows += '<a class="btn btn-sm btn-danger text-light m-1" id="deleteRow" data-id="' + value.id +
                    '">Delete</a>';
                rows += '<a class="btn btn-sm btn-success text-light mx-1" id="viewRow" data-id="' + value.id +
                    '">View</a>';
                rows += '</td>';
                rows += '</tr>';
            });
            $("#tbody").html(rows);
        }


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
                    Swal.fire('Saved!', '', 'success');
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
            // let del = url + '/category/' + id
            // console.log(del)
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mx-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`${url}/category/${id}`).then(function(r) {
                        getAllData();
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Your data has been deleted.',
                            'success'
                        )
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your file is safe :)',
                        'error'
                    )
                }
            })
        });
    </script>


</body>

</html>
