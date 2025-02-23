@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Colors</h3>
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
                    <div class="text-tiny">Colors</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search" method="GET" action="{{route('admin.search.show')}}">
                        @csrf
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name"
                                tabindex="2" value="" aria-required="true" required="">
                                <input type="hidden" name="url" value="colors">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{route('admin.color.add')}}"><i
                        class="icon-plus"></i>Add new</a>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    @if(Session::has('status'))
                        <p class="alert alert-success">{{Session::get('status')}}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Hex Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            if($results){
                                $colors = $results;
                                // dd($categories->all());
                            }else{
                                $colors = $colors;
                            }
                            @endphp
                            @php
                                $count=1;
                            @endphp
                            @foreach ($colors as $color)                          
                            <tr>
                                <td>{{$count}}</td>
                                <td class="pname">
                                    <div class="name">
                                        <a href="#" class="body-title-2">{{$color->name}}</a>
                                    </div>
                                </td>
                                <td>{{$color->code}}</td>
                                <td>
                                    <div class="list-icon-function">
                                        <form action="{{route('admin.color.delete',['id'=>$color->id])}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="item text-danger delete">
                                                <i class="icon-trash-2"></i>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $count++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                @if (!$results)
                    {{ $colors->links('pagination::bootstrap-5') }}
                @endif
                </div>
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