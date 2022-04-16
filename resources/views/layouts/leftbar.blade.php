{{--@extends('layouts.header')--}}
<body>
<script type="text/javascript">

</script>
<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
{{--            <li class="sidebar-brand">--}}
{{--                <a href="/">--}}
{{--                    MBM Group--}}
{{--                </a>--}}

{{--            </li>--}}
                @guest
                    Welcome
                @else
                       <span style="color: #f0f9ff; margin: 10px;">MBM Group -  Welcome {{ Auth::user()->name }}</span>
            @endguest
            <hr/>
            @if(auth()->user()->type == 'admin')
                <li>
                    <a href="{{ route('supplier-show') }}">Supplier List</a>
                </li>
                <li>
                    <a href="{{ route('item-show') }}">Item List</a>
                </li>
                <li>
                    <a href="{{ route('stock-show') }}">Stock List</a>
                </li>
                <li>
                    <a href="{{ route('requisition-show') }}">Requisition List</a>
                </li>

            @endif
            <li>
                <a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                    Sign Out
                </a>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
            @yield('sidebar')

        </ul>

    </div>
    <!-- /#sidebar-wrapper -->
