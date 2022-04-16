
@extends('layouts.master')
@section('title', 'Add Stock')


@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-12">
                <h4 class="">Add Stock </h4>
            </div>
            <hr/>
        </div>
        <div class="row">
            <div class="col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">

                        <!-- Form -->
                        <form action="{{ route('stock-store') }}" class="mt-2 form-validate" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row">

                                <div class="col-md-12 col-12">
                                    <div class="form-group mb-2">
                                        <label for="item_id">Item Name<span class="required">*</span></label>
                                        <select class="form-control select2" id="item_id" name="item_id">
                                            <option value="">Please Select</option>
                                            @foreach($items as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('item_id')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group mb-2">
                                        <label for="price">Price<span class="required">*</span></label>
                                        <input type="number"
                                               class="form-control @error('price') is-invalid @enderror"
                                               id="price" name="price" placeholder=""
                                               aria-describedby="price" tabindex="1"
                                               autofocus value="{{ old('price') }}" />
                                        @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group mb-2">
                                        <label for="qty">Quantity<span class="required">*</span></label>
                                        <input type="number"
                                               class="form-control @error('qty') is-invalid @enderror"
                                               id="qty" name="qty" placeholder=""
                                               aria-describedby="qty" tabindex="1"
                                               autofocus value="{{ old('qty') }}" />
                                        @error('qty')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
                    'item_id': {
                        required: true
                    },
                    'price': {
                        required: true
                    },
                    'qty': {
                        required: true
                    }
                }
            });
        }
    </script>
@endpush
