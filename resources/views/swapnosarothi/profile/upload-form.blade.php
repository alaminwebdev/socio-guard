@extends('backend.layouts.app')
@section('content')
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header">
                <h5>Upload Profile Data</h5>
            </div>
            <!-- Form Start-->
            <form action="{{ route('profile.data.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row p-5">
                    <div class="col-md-6">
                        <input type="file" class="form-control" name="profile_upload">
                    </div>
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-sm btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
