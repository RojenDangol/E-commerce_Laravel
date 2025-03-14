@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Contact Information</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Contact Info</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                </div>
                @if (!isset($contact_info) || $contact_info->count() == 0)
                <a class="tf-button style-1 w208" href="{{route('admin.contact.info.add')}}"><i
                    class="icon-plus"></i>Add new</a>  
                @endif
            </div>
            <div class="wg-table table-all-user">
                @if(Session::has('status'))
                    <p class="alert alert-success">{{Session::get('status')}}</p>
                @endif
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Logo</th>
                            <th>Fav Icon</th>
                            <th>Location</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Social Media</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @if (isset($contact_info) )
                        <tr>
                            <td>1</td>
                            <td>
                                <img src="{{asset('uploads/logo')}}/{{$contact_info->logo}}" alt="{{$contact_info->address}}" >
                            </td>
                            <td><img src="{{asset('uploads/logo')}}/{{$contact_info->favicon}}" alt="{{$contact_info->address}}" ></td>
                            <td>{{$contact_info->address}}</td>
                            <td>{{$contact_info->email}}</td>
                            <td>{{$contact_info->phone}}</td>
                            <td>
                                @foreach ($info_metas as $info_meta)
                                    {{$info_meta->key}},
                                @endforeach
                            </td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="{{route('admin.contact.info.edit',['id'=>$contact_info->id])}}">
                                        <div class="item edit">
                                            <id class="icon-edit-3"></>
                                        </div>
                                    </a>
                                    <form action="{{route('admin.contact.info.delete',['id'=>$contact_info->id])}}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="item text-danger delete">
                                            <i class="icon-trash-2"></i>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="7" class="text-center">No data found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
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