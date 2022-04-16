
@extends('layouts.master')
@section('title', 'Add Requisition')


@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-12">
                <h4 class="">Add Requisition </h4>
            </div>
            <hr/>
        </div>
        <div class="row">
            <div class="col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">

                        <!-- Form -->
                        <form action="{{ route('requisition-store') }}" class="mt-2 form-validate" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
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
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-highlight">
                                            <thead>
                                            <tr>
                                                <th width="100">Item</th>
                                                <th width="50">Quantity</th>
                                                <th width="50"></th>
                                            </tr>
                                            </thead>
                                            <tbody id="appendNewStockSection">
                                            <tr>
                                                <td class="item_section">
                                                    <div class="form-group">
                                                        <div class="input-group">
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
                                                </td>
                                                <td class="qty_section">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="number"
                                                                   class="form-control @error('qty') is-invalid @enderror"
                                                                   id="qty" name="qty" placeholder=""
                                                                   aria-describedby="qty" tabindex="1"
                                                                   autofocus value="{{ old('qty') }}" />
                                                            @error('qty')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" id="addNewStockBtn" class="btn btn-success font-weight-bold"><i
                                                            class="fa fa-plus-circle"></i>Add Into List</button>
                                                </td>

                                            </tr>
                                            </tbody>
                                        </table>
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

        // start===> finaly add new item in our collection
        $(document).off('click', '#addNewStockBtn').on('click', '#addNewStockBtn', function (e) {
            e.preventDefault();
            var item_id = $('#item_id').val();
            var elms = document.querySelectorAll("[id=item-"+item_id+"]");
                for(var i = 0; i < elms.length; i++){
                    alert('This Item already added') // <-- whatever you need to do here.
                    return;
                }
            var item_name = $("#item_id :selected").html();
            var qty = $('#qty').val();
            if (item_id && qty ) {
                var tbl = '\n' +
                    '<tr id="removeThisItem" class="everyNewSingleStockSection">\n' +
                    '     <td>\n' +
                    '         <span for="">' + item_name + '</span>\n' +
                    '         <input type="hidden" class="" id="item-'+item_id+'" data-addedStock_id="' + item_id + '" name="store_item_id[]" value="' + item_id + '">\n' +
                    '         <input type="hidden" class="" name="store_item_name[]" value="' + item_name + '">\n' +
                    '     </td>\n' +
                    '     <td>\n' +
                    '         <span for="">' + qty + '</span>\n' +
                    '          <input type="hidden" name="store_qty[]" value="' + qty + '">\n' +
                    '     </td>\n' +
                    '     <td style="padding-top: 9px;">\n' +
                    '         <a href="#0" id="removeThis" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a>\n' +
                    '     </td>\n' +
                    '</tr>';
                $("#appendNewStockSection").append(tbl);
                $('.item_section').find('.remove_this_appended').remove();
                $('.qty_section').find('.remove_this_appended').remove();
                $("#item_id").val('');
                $("#qty").val('');

            } else {
                toastr.error('Please Fill Up all field with valid value')
            }

        });

        // remove item with calculation
        $(document).on("click", "#removeThis", function () {
            $(this).parents('#removeThisItem').remove();
        });

        var formValidate = $('.form-validate');
        // Form Validation
        if (formValidate.length) {
            formValidate.validate({
                errorClass: 'error',
                rules: {
                    'name': {
                        required: true
                    }
                }
            });
        }
    </script>
@endpush
