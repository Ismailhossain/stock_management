
@extends('layouts.master')
@section('title', 'Add Supplier')


@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-12">
                <h4 class="">Add Item </h4>
            </div>
            <hr/>
        </div>
        <div class="row">
            <div class="col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">

                        <!-- Form -->
                        <form action="{{ route('item-store') }}" class="mt-2 form-validate" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-2">
                                        <label for="name">Name<span class="required">*</span></label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" placeholder=""
                                               aria-describedby="name" tabindex="1"
                                               autofocus value="{{ old('name') }}" />
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-2">
                                        <label for="supplier_id">Supplier Name<span class="required">*</span></label>
                                        <select class="form-control select2" id="supplier_id" name="supplier_id">
                                            <option value="">Please Select</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea
                                            class="form-control"
                                            name="description"
                                            rows="3"
                                            placeholder="Description"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="col-12 mt-50">
                                    <button type="submit" class="btn btn-primary mr-1">Save Changes</button>
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                            </div>

                        </form>
                        <!--/ Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')
    {{-- Page js files --}}
    <script>


        var formValidate = $('.form-validate');
        // Form Validation
        if (formValidate.length) {
            formValidate.validate({
                errorClass: 'error',
                rules: {
                    'name': {
                        required: true
                    },
                    'supplier_id': {
                        required: true
                    }
                }
            });
        }
    </script>
@endpush
