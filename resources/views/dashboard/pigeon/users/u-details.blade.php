@extends('layouts.dashboard.app')

@section('extra-css')
    <script src="{{ asset('dashboard/js/bootstrap-notify.min.js') }}"></script>
    <link type="text/css" href="{{ asset('dashboard/css/animate.css') }}" rel="stylesheet">
    <style>
        .button-container form,
        .button-container form div {
            display: inline;
            margin-right: 5px;
        }
        .list-group-item:first-child {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
        .list-group-item:last-child {
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
    </style>
@endsection

@section('content')
    <div class="header pb-8 pt-5 pt-lg-8 d-flex">
        <!-- Mask -->
        <span class="mask bg-gradient-cyan opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
            <div class="row">
                <div class="col-md-12 {{ $class ?? '' }}">
                    <h1 class="display-2 text-white">{{$user->name}}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-8 mb-xl-0">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card bg-gradient-info border-0">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0 text-white">Account Created On</h5>
                                        <span class="h2 font-weight-bold mb-0 text-white">{{ $user->created_at }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                            <i class="fas fa-user-clock"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm">
                                    <span class="text-white mr-2">Last Updated:</span>
                                    <span class="text-nowrap text-light">{{ $user->updated_at }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card bg-gradient-blue border-0">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0 text-white">User</h5>
                                        <span class="h2 font-weight-bold mb-0 text-white">N/A</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                            <i class="ni ni-basket"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm">
                                    <span class="text-white mr-2"><i class="fa fa-arrow-up"></i> N/A %</span>
                                    <span class="text-nowrap text-light">Since last month</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-xl-12 mb-xl-0">
                        <div class="card shadow">
                            <div class="card-header">
                                <h2 class="mb-0"><i class="fa fa-info-circle"></i> Information</h2>
                            </div>
                            <div class="card-body">
                                <dl class="dl-horizontal pl-lg-4 w-50" style="float: left;display: inline-block">
                                    <dt>Email</dt>
                                    <dd>{{$user->email}}</dd>
                                    <dt>Phone</dt>
                                    <dd>{{$user->phone}}</dd>
                                    <dt>City</dt>
                                    <dd>{{App\Address::getCity($user->id)}}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-xl-12 mb-xl-0">
                        <div class="card shadow border-danger">
                            <div class="card-body button-container">
                                @can('delete-restaurant')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete">Delete</button>
                                    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
                                        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                            <div class="modal-content bg-gradient-danger">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="modal-title-delete">Your attention is required</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="py-3 text-center">
                                                        <i class="ni ni-bell-55 ni-3x"></i>
                                                        <h4 class="heading mt-4">{{__('Are you sure?')}}</h4>
                                                        <p>Deleting this user cannot be reversed!</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST" action="{{ route('pigeon.delUser', $user->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" value="{{__('Delete')}}" class="btn btn-white"/>
                                                    </form>
                                                    <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <input type="button" value="{{__('Delete')}}" class="btn btn-danger" disabled/>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 mb-xl-0">
                <div class="card shadow h-100">
                    <div class="card-header">
                        <h2 class="mb-0"><i class="fa fa-receipt"></i> Orders</h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group">
                            @forelse($orders as $order)
                                <a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="{{ '#orderModal'.$order->id }}">
                                    #{{ $order->id.' | '.$order->created_at }}<span class="badge {{ $order->getStatus() }} float-right">{{ $order->status }}</span>
                                </a>
                                <div class="modal fade" id="{{ 'orderModal'.$order->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'orderModal'.$order->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title d-inline-block" id="{{ '#orderModal'.$order->id.'Title' }}">#{{ $order->id.' | '.$order->created_at}}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Status: <span class="badge {{ $order->getStatus() }}">{{ $order->status }}</span>
                                                        @if($order->status === 'failed') <p class="mb-0 d-inline-block">"{{ $order->error }}"</p>@endif
                                                    </div>
                                                </div>
                                                <hr style="margin-top: 1rem;margin-bottom: 1rem">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div>
                                                            <div class="d-flex justify-content-between">
                                                                <h5>Restaurant: </h5><h5>{{ $order->restaurant->name }}</h5>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <h5>Subtotal: </h5><h5>${{ $order->billing_subtotal }}</h5>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <h5>Delivery Fee: </h5><h5>${{ $order->billing_delivery }}</h5>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <h5>GST/QST: </h5><h5>${{ $order->billing_tax }}</h5>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <h5>Tip: </h5><h5>${{ $order->driver_tip }}</h5>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <h5><b>Total: </b></h5><h5><b>${{ $order->billing_total }}</b></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        @foreach($order->menu_items as $item)
                                                            <ul class="list-unstyled">
                                                                <li><span class="badge badge-dark">{{ $item->pivot->quantity }}</span> {{$item->name}}</li>
                                                            </ul>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer mx-auto">
                                                <form method="POST" action="{{ route('pigeon.refundOrder', $order->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning" @if($order->isBlocked()) disabled @endif>{{__('Refund')}}</button>
                                                </form>
                                                <form method="POST" action="{{ route('pigeon.cancelOrder', $order->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-danger" @if($order->isBlocked()) disabled @endif>{{__('Cancel Order')}}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <a class="list-group-item text-center">{{ $user->name }} has not made any orders.</a>
                            @endforelse
                        </div>
                        @if($orders->hasPages())
                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-center">
                                    {{ $orders->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if(\Session::has('success'))
            <script>
                var notify = $.notify({
                    // options
                    icon: 'fas fa-check',
                    message: '{!! Session::get('success') !!}'
                },{
                    // settings
                    animate: {
                        enter: 'animated fadeIn',
                        exit: 'animated fadeOut'
                    },
                    type: 'success',
                    placement: {
                        from: "top",
                        align: "center"
                    },
                });
            </script>
        @endif
        @include('layouts.dashboard.footers.auth')
    </div>
@endsection

