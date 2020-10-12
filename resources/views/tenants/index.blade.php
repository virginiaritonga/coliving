@extends('layouts.layout')

@section('content')
<div class="col-xl-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">TENANTS LIST</h6>
        </div>
        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {!! session('success') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <a href="{{route('tenant.create')}}" class="btn btn-primary btn-icon-split" style="margin-bottom: 5px;">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add Tenant</span>
            </a>
            <br>
            <div class="row no-gutters align-items-center table-responsive">
                <div class="col mr-2">
                    <table class="table table-bordered dt-responsive" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">ID Number</th>
                                <th scope="col">Type</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=0; @endphp
                            @foreach($tenants as $tenant)
                            @php $no++; @endphp
                            <tr>
                                <th scope="row">{{$no}}</th>
                                <td>{{$tenant->tenant_name}}</td>
                                <td>{{$tenant->email}}</td>
                                <td>{{$tenant->IDcard_number}}</td>
                                <td>{{$tenant->type_IDcard}}</td>
                                <td>{{$tenant->no_HP}}</td>
                                @if ($tenant->status == 'active')
                                <td class="text-success">{{$tenant->status}}</td>
                                @else
                                <td class="text-danger">{{$tenant->status}}</td>
                                @endif
                                <td>
                                    <a class="btn btn-success btn-circle btn-sm" href="{{route('tenant.show',$tenant->id)}}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a class="btn btn-warning btn-circle btn-sm" href="{{route('tenant.edit',$tenant->id)}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#deleteModal" data-id="{{$tenant->id}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Delete Tenant</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure delete this tenant ?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <form action="#" method="POST" id="deleteForm">
            @csrf
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-danger" id="delete-btn">Delete</button>
            </form>
        </div>
        </div>
    </div>
</div>

@endsection

@section('script')
{{-- datatable --}}
<script src="{{asset('datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('datatables/buttons.flash.min.js')}}"></script>
<script src="{{asset('datatables/jszip.min.js')}}"></script>
<script src="{{asset('datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('datatables/vfs_fonts.js')}}"></script>
<script src="{{asset('datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
<script>
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        var form = document.getElementById("deleteForm");
        var url = '{{ action("TenantController@destroy", ":id") }}';
        url = url.replace(':id', id);
        form.action = url;
    })
</script>
@endsection
