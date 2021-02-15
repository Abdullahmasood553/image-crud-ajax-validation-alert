@extends('layouts.master')


@section('content')


<h1 class="text-center p-3 bg-dark text-white">IMAGE PREVIEW | AJAX CRUD | VALIDATION</h1>


<div class="container">
    <form id="addPostForm" enctype="multipart/form-data">
        @csrf
        <div class="upload-imgs">
            <div class="img-upload-row">
                <div class="upload-column">
                    <input onchange="doAfterSelectImage(this)" type="file" name="image" id="image" style="display: none;">
                    <label for="image" class="img-uploaders">
                        <img src="{{ asset('assets/images/placeholder.png') }}" alt="" id="post_user_image">
                    </label>
                    <p>Post Screenshot</p>
                    <span style="display:none;" id="error_image">
                    <div class ="alert alert-danger" role="start">Post is required</div>
                  </span>
                </div>
            </div>
        </div>
        <button type="button" class="save_post_btn custom_btn mt-4">Save Post</button>
    </form>


    <h3 class="text-center p-3 bg-dark text-white mt-4">Posts Listing</h3>

    <div class="postRecord">
        
    </div>
</div>

@endsection




@push('scripts')

<script>
    function doAfterSelectImage(input) {
        console.log(input);
        readURL(input);
    } 

    function readURL(input) {
      if(input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#post_user_image').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
</script>



@endpush

