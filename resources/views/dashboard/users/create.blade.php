@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">

            <h1>@lang('site.users')
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.dashboardIndex') }}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-user-circle"></i>@lang('site.users')</a></li>
                <li class="active"><i class="fa fa-plus-circle"></i> @lang('site.add')</li>
            </ol>
        </section>
        <section class="content">
           <div class="box box-primary">
               <div class="box-header">
                   <h3 style="margin-bottom: 17px" class="box-title">@lang('site.add')</h3>
               </div> {{-- end box header--}}
               <div class="box-body">
                   @include('partials._errors')
                   <form action="{{route('dashboard.store')}}" method="POST" enctype="multipart/form-data">
                       {{csrf_field()}}
                       {{method_field('post')}}
                        <div class="form-group">
                            <label>@lang('site.first_name')</label>
                            <input class="form-control" type="text" name="first_name" value="{{old('first_name')}}">
                        </div>
                       <div class="form-group">
                           <label>@lang('site.last_name')</label>
                           <input class="form-control" type="text" name="last_name" value="{{old('last_name')}}">
                       </div>
                       <div class="form-group">
                           <label>@lang('site.email')</label>
                           <input type="email" class="form-control" name="email" value="{{old('email')}}">
                       </div>
                       <div class="form-group">
                           <label>@lang('site.password')</label>
                           <input type="password" name="password" class="form-control">
                       </div>
                       <div class="form-group">
                           <label>@lang('site.password_confirm')</label>
                           <input type="password" name="password_confirmation" class="form-control">
                       </div>
                       <div class="form-group">
                           <label>@lang('site.image')</label>
                           <input type="file" class="form-control image" name="photo" >
                       </div>
                       <div class="form-group">

                           <img class="img-thumbnail image-preview" style="width: 100px"  src="{{asset('image/users/default.png')}}">

                       </div>
                       <div class="form-group">
                          <label>@lang('site.permission')</label>
                           <div class="nav-tabs-custom">
                               <ul class="nav nav-tabs">
                                   @php
                                   $models=['users','categories','products','clients','orders'];
                                   $maps=['create','read','update','delete']
                                   @endphp
                                   @foreach($models as $index=>$model)

                                   <li class="{{$index==0?'active':''}}"><a href="#{{$model}}" data-toggle="tab"> @lang('site.'. $model) </a></li>
                                   @endforeach
                               </ul>
                               <div class="tab-content">
                                   @foreach($models as $index=>$model)
                                       <div class="tab-pane {{$index==0?'active':''}}" id="{{$model}}">
                                             @foreach($maps as $index=>$map)
                                               <lable> <input type="checkbox" name="permission[]" value="{{ $map.'_'.$model }}"> @lang('site.'. $map) </lable>
                                           @endforeach
                                       </div>

                                   @endforeach
                               </div>
                           </div>
                       </div>
                       <div class="form-group">
                           <button class="btn btn-primary" type="submit" ><i class="fa fa-plus"></i>@lang('site.add')</button>
                       </div>
                   </form>
               </div>{{--end box body--}}

           </div>
        </section>

    </div>
@endsection
