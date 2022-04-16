
@extends('layouts.master')
@section('title', 'Add Supplier')


@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-12">
                <h4 class="">Add Supplier </section>
            </div>
            <hr/>
        </div>
        <div class="row">
            <div class="col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">

                        <!-- Form -->
                        <form action="{{ route('supplier-store') }}" class="mt-2 form-validate" enctype="multipart/form-data" method="post">
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
                                        <label for="phone">Phone</label>
                                        <input type="text"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               id="phone" name="phone" placeholder=""
                                               aria-describedby="phone" tabindex="1"
                                               autofocus value="{{ old('phone') }}" />
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group mb-2">
                                        <label for="email">Email<span class="required">*</span></label>
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" placeholder=""
                                               aria-describedby="email" tabindex="1"
                                               autofocus value="{{ old('email') }}" />
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea
                                            class="form-control"
                                            name="address"
                                            rows="3"
                                            placeholder="Address"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class=" col-12 mt-50">
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



        $( "#phone" ).on( 'keyup', function(event) {

            if (!event.ctrlKey) {
                validateInp(this);
            }

        });

        // Start to Verify Phone Number
        function validateInp(elem) {
            var validChars = /[0-9]/;
            var strIn = elem.value;
            var strOut = '';
            for(var i=0; i < strIn.length; i++) {
                strOut += (validChars.test(strIn.charAt(i)))? strIn.charAt(i) : '';
            }
            elem.value = strOut;
        }
        // End of Verify Phone Number


        var formValidate = $('.form-validate');
        // Form Validation
        if (formValidate.length) {
            formValidate.validate({
                errorClass: 'error',
                rules: {
                    'name': {
                        required: true
                    },
                    'email': {
                        required: true
                    }
                }
            });
        }
    </script>
@endpush
