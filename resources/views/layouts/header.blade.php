<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @yield('meta')

    <title>
        @section('title')
            MBM Group
        @show
        {{--@yield('title', 'Laravel')--}}

    </title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
{{--    <link href="{{asset('assets/css/bootstrap-grid.min.css')}}" rel="stylesheet" type="text/css">--}}
{{--    <link href="{{asset('assets/css/bootstrap-reboot.min.css')}}" rel="stylesheet" type="text/css">--}}
    <link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
{{--    <link href="{{asset('assets/css/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css">--}}
    <link href="{{asset('assets/css/jquery.validate.css')}}" rel="stylesheet" type="text/css">



<!-- Custom CSS -->
    <link href="{{asset('assets/css/simple-sidebar.css')}}" rel="stylesheet" type="text/css">
{{--    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css">--}}




<!-- Custom Notifications -->
    <link href="{{asset('assets/css/jquery.noty.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/noty_theme_default.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/noty_theme_twitter.css')}}" rel="stylesheet" type="text/css">






    <!-- Ui Dialog CSS -->

    <link href="{{asset('assets/css/jquery-confirm.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/jquery-ui.min.css')}}" rel="stylesheet" type="text/css">

<!-- End of Ui Dialog CSS -->
    <link href="{{asset('assets/css/forms/select/select2.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/pickers/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/extensions/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/extensions/toastr.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/extensions/ext-component-toastr.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/extensions/form-validation.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/extensions/form-flat-pickr.css')}}" rel="stylesheet" type="text/css">
    @stack('styles')
<!-- Html5 Shim and Respond.js IE8 support of Html5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->

    {{--<![endif]-->--}}
    <script src="{{asset('assets/js/respond.min.js')}}" type="text/javascript" ></script>
    <script src="{{asset('assets/js/html5shiv.js')}}" type="text/javascript" ></script>



<!-- jQuery -->

    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}" type="text/javascript" ></script>
    <script src="{{asset('assets/js/jquery.validate.js')}}" type="text/javascript" ></script>
    <script src="{{asset('assets/js/jquery.validation.functions.js')}}" type="text/javascript" ></script>



<!-- Bootstrap Core JavaScript -->

    <script src="{{asset('assets/js/bootstrap.min.js')}}" type="text/javascript" ></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="text/javascript" ></script>
    <script src="{{asset('assets/js/app.js')}}" type="text/javascript" ></script>





<!-- Menu Toggle Script -->

    <!-- Custom Notifications -->
    <script src="{{asset('assets/js/jquery.noty.js')}}" type="text/javascript" ></script>


    <!-- Ui Dialog JS -->
    <script src="{{asset('assets/js/jquery-confirm.min.js')}}" type="text/javascript" ></script>
    <script src="{{asset('assets/js/jquery-ui.min.js')}}" type="text/javascript" ></script>


<!-- End of Ui Dialog JS -->


    <!-- Ajax File upload -->
    <script src="{{asset('assets/js/rajax.js')}}" type="text/javascript" ></script>

<!-- End of Ajax File upload -->
    <script src="{{asset('assets/js/extensions/select2.full.min.js')}}" type="text/javascript" ></script>
    <script src="{{asset('assets/js/extensions/jquery.validate.min.js')}}" type="text/javascript" ></script>
    <script src="{{asset('assets/js/extensions/flatpickr.min.js')}}" type="text/javascript" ></script>
    <script src="{{asset('assets/js/extensions/sweetalert2.all.min.js')}}" type="text/javascript" ></script>
    <script src="{{asset('assets/js/extensions/toastr.min.js')}}" type="text/javascript" ></script>
    <script src="{{asset('assets/js/extensions/ext-component-toastr.js')}}" type="text/javascript" ></script>

    @stack('script')

    <script>
		$("#menu-toggle").click(function (e) {
			e.preventDefault();
			$("#wrapper").toggleClass("toggled");
		});

		// To Display Multiple Modal

		$(document).on('show.bs.modal', '.modal', function (event) {
			var zIndex = 1040 + (10 * $('.modal:visible').length);
			$(this).css('z-index', zIndex);
			setTimeout(function () {
				$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
			}, 0);
		});


		// End of Display Multiple Modal
    </script>


</head>




