@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div
            class="flex items-center flex-wrap justify-between gap20 mb-27"
        >
            <h3>Users</h3>
            <ul
                class="breadcrumbs flex items-center flex-wrap justify-start gap10"
            >
                <li>
                    <a href="index.html">
                        <div class="text-tiny">
                            Dashboard
                        </div>
                    </a>
                </li>
                <li>
                    <i
                        class="icon-chevron-right"
                    ></i>
                </li>
                <li>
                    <div class="text-tiny">
                        All User
                    </div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div
                class="flex items-center justify-between gap10 flex-wrap"
            >
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input
                                type="text"
                                placeholder="Search here..."
                                class=""
                                name="name"
                                tabindex="2"
                                value=""
                                aria-required="true"
                                required=""
                            />
                        </fieldset>
                        <div class="button-submit">
                            <button
                                class=""
                                type="submit"
                            >
                                <i
                                    class="icon-search"
                                ></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    @if(Session::has('status'))
                        <p class="alert alert-success">{{Session::get('status')}}</p>
                    @endif
                    <table
                        class="table table-striped table-bordered"
                    >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th
                                class="text-center"
                                >
                                Total Orders
                                </th>
                                {{-- <th>Type</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)          
                            <tr>
                                <td>{{$user->id}}</td>
                                <td class="pname">
                                    <div
                                        class="name"
                                    >
                                        <a
                                            href="#"
                                            class="body-title-2"
                                            >{{$user->name}}</a
                                        >
                                        <div
                                            class="text-tiny mt-3"
                                        >
                                            {{$user->utype}}
                                        </div>
                                    </div>
                                </td>
                                <td>{{$user->mobile}}</td>
                                <td>
                                    {{$user->email}}
                                </td>
                                <td
                                    class="text-center"
                                >
                                    <a
                                        href="#"
                                        target="_blank"
                                        >{{$user->order->count()}}</a
                                    >
                                </td>

                                {{-- <td>
                                    <div class="select">
                                            <select class="" name="utype">
                                                <option value="ADM" {{$user->utype == "ADM"?"selected":""}}>Admin</option>
                                                <option value="USR" {{$user->utype == "USR"?"selected":""}}>User</option>
                                            </select>
                                    </div>
                                </td> --}}

                                <td>
                                    
                                    <div class="list-icon-function">
                                        <form action="{{route('admin.user.delete',['id'=>$user->id])}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="item text-danger delete">
                                                <i class="icon-trash-2"></i>
                                            </div>
                                        </form>
                                        
                                    </div>
                                    
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
            <div
                class="flex items-center justify-between flex-wrap gap10 wgp-pagination"
            ></div>
        </div>
    </div>
</div>  
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div
            class="flex items-center flex-wrap justify-between gap20 mb-27"
        >
            <h3>Admins</h3>
        </div>

        <div class="wg-box">
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    @if(Session::has('status_admin'))
                        <p class="alert alert-success">{{Session::get('status_admin')}}</p>
                    @endif
                    <table
                        class="table table-striped table-bordered"
                    >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th
                                    class="text-center"
                                >
                                    Total Orders
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)          
                            <tr>
                                <td>{{$admin->id}}</td>
                                <td class="pname">
                                    <div
                                        class="name"
                                    >
                                        <a
                                            href="#"
                                            class="body-title-2"
                                            >{{$admin->name}}</a
                                        >
                                        <div
                                            class="text-tiny mt-3"
                                        >
                                            {{$admin->utype}}
                                        </div>
                                    </div>
                                </td>
                                <td>{{$admin->mobile}}</td>
                                <td>
                                    {{$admin->email}}
                                </td>
                                <td
                                    class="text-center"
                                >
                                    <a
                                        href="#"
                                        target="_blank"
                                        >{{$admin->order->count()}}</a
                                    >
                                </td>
                                @if ($admin->utype === 'ADM' and $admin->super_admin === 0)
                                <td>
                                    <div class="list-icon-function">
                                        <form action="{{route('admin.user.delete',['id'=>$admin->id])}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="item text-danger delete">
                                                <i class="icon-trash-2"></i>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                                @else
                                <td></td>
                                @endif
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
            <div
                class="flex items-center justify-between flex-wrap gap10 wgp-pagination"
            ></div>
        </div>
    </div>
</div>  
@endsection

@push('scripts')
    <script>
        $(function(){
            $('.delete').on('click',function(e){
                e.preventDefault();
                var form =$(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data",
                    type: "warning",
                    buttons: ["No","Yes"],
                    confirmButtonCOlor: "#dc3545"
                }).then(function(result){
                    if(result){
                        form.submit();
                    }
                });
            })
        });
    </script>    
@endpush