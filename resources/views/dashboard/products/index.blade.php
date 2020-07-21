@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">

            <h1>@lang('site.products')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.dashboardIndex') }}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li class="active"> @lang('site.products')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 style="margin-bottom: 17px" class="box-title">@lang('site.products') <small>{{ $products ->total() }}</small></h3>

                    <form action="{{route('dashboard.products.index')}}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}" >

                            </div>
                            <div class="col-md-4">
                                <select name="category_id" class="form-control">
                                    <option value="">@lang('site.all_categories')</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category -> id}}" {{request()->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @if(auth()->user()->hasPermission('create_products'))
                                <a class="btn btn-primary" href="{{route('dashboard.products.create')}}"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <a class="btn btn-primary disabled" href="#"><i class="fa fa-plus "></i> @lang('site.add')</a>
                                @endif
                            </div>

                        </div> {{-- end  row--}}
                    </form> {{-- end form --}}

                </div> {{--end of box header--}}
                <div class="box-body">
                    @if($products -> count()>0)
                    <table class="table table-hover table-bordered text-center ">
                        <thead >
                        <tr>
                            <th>#</th>
                            <th>@lang('site.name')</th>
                            <th style="width: 350px">@lang('site.description')</th>
                            <th>@lang('site.category')</th>
                            <th>@lang('site.image')</th>
                            <th>@lang('site.purchase_price')</th>
                            <th>@lang('site.sale_price')</th>
                            <th>@lang('site.profit_percent') %</th>
                            <th>@lang('site.stock')</th>
                            <th>@lang('site.action')</th>

                        </tr>
                        </thead>

                        <tbody>
                        @foreach($products as $index=> $product)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{!!$product->description!!}</td>
                                    <td>{{$product->category->name}}</td>
                                    <td><img class="img-thumbnail" style="width: 90px; height: 90px;" src="{{asset('image/products/'.$product->image)}}"></td>
                                    <td>{{$product->purchase_price}}</td>
                                    <td>{{$product->sale_price}}</td>
                                    <td>{{$product->profit_percent}} %</td>
                                    <td>{{$product->stock}}</td>
                                    <td>
                                        @if(auth()->user()->hasPermission('update_products'))
                                            <a href="{{route('dashboard.products.edit',$product->id)}}" class="btn btn-success">@lang('site.edit')</a>
                                        @else
                                            <a href="#" class="btn btn-success disabled">@lang('site.edit')</a>
                                        @endif

                                           @if(auth()->user()->hasPermission('delete_products'))
                                                <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post" style="display: inline-block" >
                                                    {{csrf_field()}}
                                                    {{method_field('delete')}}

                                                    <button type="submit" class="btn btn-danger delete">@lang('site.delete')</button>
                                                </form>
                                            @else
                                                <a href="#" class="btn btn-danger disabled">@lang('site.delete')</a>
                                            @endif

                                    </td>
                                </tr>
                        </tbody>
                        @endforeach

                    </table>
                    {{-- عملت هيلب فنكشن  وعملت اضافه للاكشن الي معايا ف اللينك عشان ميعملش ايرور --}}
                        {{$products -> appends(request()->query())->links()}}
                        @else
                          <h2>@lang('site.no data found')</h2>
                    @endif
                </div> {{-- end of body --}}
            </div> {{--end of box--}}
        </section>

    </div>
@endsection
