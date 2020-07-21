@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">

            <h1>@lang('site.categories')
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.dashboardIndex') }}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li><a href="{{route('dashboard.categories.index')}}"><i class="fa fa-user-circle"></i>@lang('site.categories')</a></li>
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
                    <form action="{{route('dashboard.categories.update',$category->id)}}" method="post" >
                        {{csrf_field()}}
                        {{method_field('put')}}
                        {{-- way as ar --}}
                        @foreach(config('translatable.locales') as $locale)
                            <div class="form-group">
                                {{-- site . arname--}}
                                <label>@lang('site.'.$locale.'.name')</label>
                                {{-- ar[name]--}}
                                <input class="form-control" type="text" name="{{$locale}}[name]" value="{{$category ->translate($locale)->name}}">
                            </div>
                        @endforeach
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" ><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>
                    </form>
                </div>{{--end box body--}}

            </div>
        </section>

    </div>
@endsection
