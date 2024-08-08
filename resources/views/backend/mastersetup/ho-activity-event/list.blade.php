@extends('backend.layouts.app')
@section('content')
    {{-- <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Manage Head Office Activity Event</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Home </li>
                <li class="breadcrumb-item active">Head Office Activity Event</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div> --}}
    <div class="container-fluid pt-5">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header border-bottom-0 brac-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-white">Head Office Activity Event List</h6>
                    <a class="btn btn-sm btn-success" href="{{ route('ho-activity-events.create') }}"><i class="fa fa-plus-circle"></i> Add Event</a>
                </div>
                <div class="card-body">
                    <table class="table-sm table-bordered table-striped" style="width: 100%" id="datatable">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Event Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ho_activity_events as $key => $item)
                                <tr class="{{ $item->id }} tr-row">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @php
                                            $statusBg = $item->status == '1' ? 'success' : 'danger';
                                        @endphp
                                        
                                        <span class="badge badge-{{$statusBg}}">{{ $item->status == '1' ? 'Active' : 'Inactive'}}</span>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-success" title="Edit" href="{{ route('ho-activity-events.edit', $item->id) }}"><i class="fa fa-edit"></i></a>
                                        {{-- <a class="btn btn-sm btn-danger" title="Edit" href="#" onclick="remove({{ $item->id }}, event, $(this))"><i class="fa fa-trash"></i></a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function remove(id, e, item) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
				type: "warning",
                text: "You will not be able to recover this item!",
                denyButtonText: `No, cancel!`,
                confirmButtonText: 'Yes, delete it!',
                focusConfirm: false,
                showLoaderOnConfirm: true,
                showDenyButton: true,
                preConfirm: () => {

                    // Prepare data to be sent
					var formData = {
						_token: '{{ csrf_token() }}', // Include CSRF token
					};

                    // Send the form data to the controller via AJAX using POST method
                    return $.ajax({
                        url: "{{ route('ho-activity-events.show', ':id') }}".replace(':id', id),
                        type: 'GET',
                        // data: formData
                    }).then(response => {
                        if (response.status == 'error') {
                            Swal.showValidationMessage(response.message);
                        } else {
                            return response;
                        }
                    });

                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Done!',
                        'Status Changed Successfully!.',
                        'success'
                    );
					item.closest('.tr-row').remove();
                    //location.reload();
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });
        }
    </script>
@endsection
