@extends('layouts.master')
@section('title', 'Requisition List')
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
    <div class="content container-fluid">
        <div class="row">
            <div class="col-sm-8 col-6">
                <h4 class="page-title">Requisition List</h4>
            </div>
            <div class="col-sm-4 col-6 text-right m-b-30">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 form-group">
               <a class="btn btn-primary" role="button" href="{{route('requisition-create')}}">Add Requisition</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if (isset($requisitions) && count($requisitions) > 0)
                <div class="table-responsive" >
                    <table class="table table-striped custom-table mb-0 stockList" id="stockList" >
                        <thead>
                        <tr>
                            <th class="text-center">SL</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Item-Quantity</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody >
                        @foreach($requisitions as $requisition)
                            <tr class="text-center">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $requisition->name }}</td>
                                <td class="text-center">
                                    @if ($requisition->item_qty)
                                        @foreach($requisition->item_qty as $val)
                                            <ul>
                                                @if(isset($val['item_id']))
                                                    <li>
                                                        Name - {{$val['item_name']}} </br>
                                                        Quantity - {{$val['qty']}} </br>
                                                    </li>
                                                @endif
                                            </ul>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                @if($requisition->status == 1)
                                        <span class="badge badge-success">Approved</span>
                                    @elseif($requisition->status == 2)
                                        <span class="badge badge-danger" >Rejected</span>
                                    @elseif($requisition->status == 0)
                                        <form style="display: none" method="POST" id="verifyFormStatus-{{ $requisition->id }}"
                                              action="{{ route('requisition-status', $requisition->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status_id" id="status_id" value="">
                                        </form>
                                        <a href="#0"   class="btn btn-success btn-sm" onclick="verifyStatus({{$requisition->id}},1)" role="button">Approve</a>
                                        <a href="#0" class="btn btn-danger btn-sm"  onclick="verifyStatus({{$requisition->id}},2)"  role="button">Reject</a>
                                @endif

                                </td>
                                <td>
                                    @if($requisition->status == 0)
                                    <a href="{{ route('requisition-edit', $requisition->id) }}" class="btn btn-primary btn-sm" role="button">Edit</a>
                                    <a href="#0" class="btn btn-danger btn-sm" onclick="verify({{$requisition->id}})"  role="button">Delete</a>
                                    <form style="display: none" method="POST" id="verifyForm-{{ $requisition->id }}"
                                          action="{{ route('requisition-delete', $requisition->id) }}">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                    @else
                                    N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                    {{-- Pagination --}}
{{--                    <div class="d-flex justify-content-center">--}}
{{--                        {!! $requisitions->links() !!}--}}
{{--                    </div>--}}
                </div>
                @else
                    <div class="alert alert-custom alert-outline-2x alert-outline-warning fade show mb-5">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text h4 mb-0">No data found</div>
                    </div>
                @endif
            </div>
        </div>
    </div>



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
                    toastr.success('Requisition deleted success.');
                }
            })
        }

        function verifyStatus(id,status_id){
            $('#status_id').val(status_id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('verifyFormStatus-' + id).submit();
                    toastr.success('Requisition Status Updated.');
                }
            })
        }
    </script>
@endpush
