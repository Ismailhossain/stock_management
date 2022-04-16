@extends('layouts.master')
@section('title', 'Item List')
@include('layouts.dataTable_resource')
@push('css')
    <style>
        .red {
            background-color: red !important;
        }
        .yellow {
            background-color: yellow !important;
        }
    </style>
@endpush


@section('content')
    <!-- Ajax Sourced Server-side -->
    <div class="content container-fluid">
        <div class="row">
            <div class="col-sm-8 col-6">
                <h4 class="page-title">Item List</h4>
            </div>
            <div class="col-sm-4 col-6 text-right m-b-30">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 form-group">
               <a class="btn btn-primary" role="button" href="{{route('item-create')}}">Add Item</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="" >
                    <table class="table table-striped custom-table mb-0 itemList" id="itemList" >
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Supplier</th>
                            <th class="notexport">Action</th>
                        </tr>
                        </thead>
                        <tbody >



                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <!--/ Ajax Sourced Server-side -->


@endsection



@push('script')
    {{-- Page js files --}}
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(".alert").delay(15000).slideUp(300);

            var itemList = $('#itemList').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('item-show-json') }}',
                    type: "POST",
                    data: function (d) {
                        d._token = $("input[name=_token]").val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'status', name: 'status'},
                    {data: 'supplier.name', name: 'supplier.name'},
                    {data: 'action', name: 'action'}
                ],
                dom:
                    '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons:[
                    {
                        extend: 'excel',
                        className: 'btn btn-light-primary btn-md btn-clean font-weight-bold font-size-base mr-1',
                        text: 'Excel',
                        charset: 'utf-8',
                        bom: 'true',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn btn-light-primary btn-md btn-clean font-weight-bold font-size-base mr-1',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    }
                ],
                responsive:true,
                lengthMenu:[[10,25,50,100,-1],[10,25,50,100,"All"]],
                columnDefs: [
                    {
                        targets: '_all',
                        defaultContent: 'N/A'
                    },
                    {
                        targets: 'no-sort',
                        orderable: false,
                    },
                ],
                order: [[0, 'asc']]
            });

        });
        function verify(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('verifyForm-' + id).submit();
                    toastr.success('Item deleted success.');
                }
            })
        }
        $(document).off("click", "#ActiveInactive").on("click", "#ActiveInactive", function () {
        // $("table").on('click', '#ActiveInactive', function () {
            var id = $(this).attr('data_id');
            var getStatus = $(this).attr('statusCode');
            var table = $(this).attr('tableName');
            var setStatus = (getStatus > 0) ? 0 : 1;
            $.ajax({
                url: "{{ route('home-statusCode') }}",
                type: "post",
                data: {setStatus: setStatus, id: id, table:table},
                success: function (res) {
                    if (res.warning) {
                        toastr.warning(res.warning, 'Error');
                    } else if (res.success) {
                        // $(".datatables-ajax").load(location.href + " .datatables-ajax");
                        var itemList = $('.itemList').dataTable();
                        itemList.fnDraw(false);
                        toastr.success(res.success, 'Success');
                    } else if (res.error) {
                        toastr.error(res.error, 'Error');
                    }
                },
                error: function (xhr, status, error) {
                    // console.log(xhr.responseJSON);
                    toastr.error('Something went wrong!', 'Falied');
                }
            })
        });
    </script>
@endpush
