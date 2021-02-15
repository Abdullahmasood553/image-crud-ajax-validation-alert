
$(document).ready(function() {
    getPostImages();
    $('.save_post_btn').on('click', function(e) {
        e.preventDefault();
        let check = userHasUploadedImage();
        if(check) {
            let myForm = document.getElementById('addPostForm');
            let formData = new FormData(myForm);
            console.log(formData);
            uploadPost(formData);
        }
    });
});

// Save Post
function uploadPost(formData) {
    $.ajaxSetup({
        headers: {
            'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        type: "POST",
        data: formData,
        dataType: 'JSON',
        contentType: false,
        processData: false,
        url: 'save_post',
        success:function(data) {
            if(data.status) {
               showCustomSuccess(data.message);
               $('#post_user_image').attr('src', 'assets/images/placeholder.png');
               getPostImages();
            } else {
              showCustomError(data.error);
            }
        },
        error:function(err) {
            showCustomError('Something went Wrong!')
        }
    })
}

// Validations for Image
function userHasUploadedImage() {
    let check = true;
    let file = $('#image').get(0).files[0];
    if(file == undefined || file == null) {
        check = false;
        handleErrors();
        return check;
    }
    handleErrors();
    return check;
}


function handleErrors() {
    let file = $('#image').get(0).files[0];
    if(file == undefined || file == null) {
        $('#error_image').show();
    } else {
        $('#error_image').hide();
    }
}

$(document).on('click', '.update_post_btn', function(e) {
    e.preventDefault();
    let myForm = document.getElementById('updatePostForm');
    let formData = new FormData(myForm);
    updatePost(formData)
}); 


function updatePost(formData) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const id = $('#id').val();
    $.ajax({
        type: "POST",
        data:formData,
        dataType: "JSON",
        contentType: false,
        cache:false,
        processData: false,
        url: "update_post/"+id,
        success:function(data) {
            if(data.status) {
                showCustomSuccess(data.message);
            } else {
                showCustomError(data.error);
            }
        },
        error:function(err) {
            showCustomError('Something went Wrong!')
        }
    });
}



$(document).on('click', '.del_post', function() {
    var id = $(this).attr('id');
    $.ajax({
        type: 'GET',
        url: 'del_post/'+id,
        data: {
            id:id
        },
        success:function(data) {
            if(data.status) {
                showCustomSuccess(data.message);
                getPostImages();
            } else {
                showCustomError(data.error);
            }
        }, err:function(err) {
            showCustomError('Something went Wrong!');
        }
       
    });
});

function getPostImages() {
    $.ajax({
        type: 'GET',
        url: 'get_posts',
        success:function(response) {
            var response = JSON.parse(response);
            console.log(response);
            $('.postRecord').empty();
            $('.postRecord').append(
                `<table class="table table-hover dt-responsive nowrap postList" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Post Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>`
            );
            response.forEach(element => {
                $('.postList tbody').append(`<tr>
                    <td>
                        ${element.id}
                    </td>
                    <td>
                            <img src="storage/posts/${element.image}" class="showcase-image">
                    </td>

                    <td>
                        <button href = "#" class = "btn btn-danger btn-sm del_post" id="${element['id']}">Delete</button>
                        <a href ="edit/${element.id}" class = "btn btn-primary btn-sm">Edit</a>
                    </td>
                </tr>`)
            });
        }
    })
}
