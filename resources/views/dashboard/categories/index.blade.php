@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">

            <h1>@lang('site.categories')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.dashboardIndex') }}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li class="active"> @lang('site.categories')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 style="margin-bottom: 17px" class="box-title">@lang('site.categories') <small>{{ $categories ->total() }}</small></h3>

                    <form action="{{route('dashboard.categories.index')}}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}" >

                            </div>
                            <div class="col-md-4">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @if(auth()->user()->hasPermission('create_categories'))
                                <a class="btn btn-primary" href="{{route('dashboard.categories.create')}}"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <a class="btn btn-primary disabled" href="#"><i class="fa fa-plus "></i> @lang('site.add')</a>
                                @endif
                            </div>

                        </div> {{-- end  row--}}
                    </form> {{-- end form --}}

                </div> {{--end of box header--}}
                <div class="box-body">
                    @if($categories -> count()>0)
                    <table class="table table-hover table-bordered text-center">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.products_count')</th>
                            <th>@lang('site.products_related')</th>
                            <th>@lang('site.action')</th>

                        </tr>
                        </thead>

                        <tbody>
                        @foreach($categories as $index=> $category)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->products->count()}}</td>
                                    <td><a href="{{route('dashboard.products.index',['category_id'=>$category->id])}}" class="btn btn-primary btn-sm">@lang('site.products_related')</a></td>
                                    <td>
                                        @if(auth()->user()->hasPermission('update_categories'))
                                            <a href="{{route('dashboard.categories.edit',$category->id)}}" class="btn btn-success btn-sm">@lang('site.edit')</a>
                                        @else
                                            <a href="#" class="btn btn-success btn-sm disabled">@lang('site.edit')</a>
                                        @endif

                                           @if(auth()->user()->hasPermission('delete_categories'))
                                                <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="post" style="display: inline-block" >
                                                    {{csrf_field()}}
                                                    {{method_field('delete')}}

                                                    <button type="submit" class="btn btn-danger btn-sm delete">@lang('site.delete')</button>
                                                </form>
                                            @else
                                                <a href="#" class="btn btn-danger btn-sm disabled">@lang('site.delete')</a>
                                            @endif

                                    </td>
                                </tr>
                        </tbody>
                        @endforeach

                    </table>
                    {{-- عملت هيلب فنكشن  وعملت اضافه للاكشن الي معايا ف اللينك عشان ميعملش ايرور --}}
                        {{$categories -> appends(request()->query())->links()}}



                        @else
                          <h2>@lang('site.no data found')</h2>
                    @endif
                </div> {{-- end of body --}}
            </div> {{--end of box--}}
        </section>

    </div>
@endsection
