@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">

            <h1>@lang('site.users')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.dashboardIndex') }}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li class="active"> @lang('site.users')</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 style="margin-bottom: 17px" class="box-title">@lang('site.users') <small>{{ $users ->total() }}</small></h3>

                    <form action="{{route('dashboard.index')}}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{request()->search}}" >

                            </div>
                            <div class="col-md-4">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @if(auth()->user()->hasPermission('create_users'))
                                <a class="btn btn-primary " href="{{route('dashboard.create')}}"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <a class="btn btn-primary disabled" href="#"><i class="fa fa-plus "></i> @lang('site.add')</a>
                                @endif
                            </div>

                        </div> {{-- end  row--}}
                    </form> {{-- end form --}}

                </div> {{--end of box header--}}
                <div class="box-body">
                    @if($users -> count()>0)
                    <table class="table table-hover table-bordered text-center ">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('site.first_name')</th>
                            <th>@lang('site.last_name')</th>
                            <th>@lang('site.email')</th>
                            <th>@lang('site.action')</th>
                            <th>@lang('site.image')</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($users as $index=> $user)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$user->first_name}}</td>
                                    <td>{{$user->last_name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td><img class="img-thumbnail" style="width: 90px; height: 90px;" src="{{asset('image/users/'.$user->photo)}}"></td>
                                    <td>
                                        @if(auth()->user()->hasPermission('update_users'))
                                            <a href="{{route('dashboard.edit',$user->id)}}" class="btn btn-success">@lang('site.edit')</a>
                                        @else
                                            <a href="#" class="btn btn-success disabled">@lang('site.edit')</a>
                                        @endif

                                           @if(auth()->user()->hasPermission('delete_users'))
                                                <form action="{{route('dashboard.delete',$user->id)}}" method="post" style="display: inline-block" >
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
                        {{$users -> appends(request()->query())->links()}}



                        @else
                          <h2>@lang('site.no data found')</h2>
                    @endif
                </div> {{-- end of body --}}
            </div> {{--end of box--}}
        </section>

    </div>
@endsection
