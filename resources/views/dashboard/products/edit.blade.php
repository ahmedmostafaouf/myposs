@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">

            <h1>@lang('site.products')
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.dashboardIndex') }}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li><a href="{{route('dashboard.products.index')}}"><i class="fa fa-user-circle"></i>@lang('site.products')</a></li>
                <li class="active"><i class="fa fa-plus-circle"></i> @lang('site.add')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 style="margin-bottom: 17px" class="box-title">@lang('site.edit')</h3>
                </div> {{-- end box header--}}
                <div class="box-body">
                    @include('partials._errors')
                    <form action="{{route('dashboard.products.update',$product->id)}}" method="post" enctype="multipart/form-data" >
                        {{csrf_field()}}
                        {{method_field('put')}}
                        <div class="form-group">
                            <select class="form-control " name="category_id">
                                <option value="" >@lang('site.all_categories')</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"{{$product->category_id == $category->id ? 'selected' : ''}}> {{$category -> name}}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- way as ar --}}
                        @foreach(config('translatable.locales') as $locale)
                            <div class="form-group">
                                {{-- site . arname--}}
                                <label>@lang('site.'.$locale.'.name')</label>
                                {{-- ar[name]--}}
                                <input class="form-control" type="text" name="{{$locale}}[name]"  value="{{$product ->translate($locale)->name}}">
                            </div>
                            <div class="form-group">
                                {{-- site . arname--}}
                                <label>@lang('site.'.$locale.'.description')</label>
                                {{-- ar[name]--}}
                                <textarea  class="form-control"  name="{{$locale}}[description]">{{$product->translate($locale)->description}}</textarea>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input type="file" class="form-control image" name="image" >
                        </div>
                        <div class="form-group">

                            <img class="img-thumbnail image-preview" style="width: 100px" src="{{asset('image/products/'.$product->image)}}">

                        </div>
                        <div class="form-group">
                            <label>@lang('site.purchase_price')</label>
                            <input type="number" class="form-control" step="0.01" name="purchase_price" value="{{$product->purchase_price}}" >
                        </div>
                        <div class="form-group">
                            <label>@lang('site.sale_price')</label>
                            <input type="number" class="form-control" name="sale_price" step="0.01" value="{{$product->sale_price}}" >
                        </div>
                        <div class="form-group">
                            <label>@lang('site.stock')</label>
                            <input type="number" class="form-control" name="stock" value="{{$product->stock}}" >
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" ><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>
                    </form>
                </div>{{--end box body--}}

            </div>
        </section>

    </div>
@endsection
