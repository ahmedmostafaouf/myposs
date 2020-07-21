@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">

            <h1>@lang('site.clients')
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.dashboardIndex') }}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li><a href="{{route('dashboard.clients.index')}}"><i class="fa fa-user-circle"></i>@lang('site.clients')</a></li>
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
                   <form action="{{route('dashboard.clients.store')}}" method="POST" >
                       {{csrf_field()}}
                       {{method_field('post')}}
                        <div class="form-group">
                            <label>@lang('site.name')</label>
                            <input class="form-control" type="text" name="name" value="{{old('name')}}">
                        </div>
                       @for($i=0;$i<2;$i++)
                           <div class="form-group">
                               <label>@lang('site.phone')</label>
                               <input class="form-control" type="text" name="phone[]" >
                           </div>
                       @endfor
                       <div class="form-group">
                           <label>@lang('site.address')</label>
                           <textarea class="form-control" type="text" name="address" >{{old('address')}}</textarea>
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
