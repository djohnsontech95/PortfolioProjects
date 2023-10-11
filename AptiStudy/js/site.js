function default_profile_image() {
    document.getElementById('img').src = '../images/profile-upload.png';
}

function validateImageFile() {
    var fileName = document.getElementById("singleFileInput").value;
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();

    if (extFile != "jpg" && extFile != "jpeg" && extFile != "png" && extFile != "webp") {
        alert("Only jpg, jpeg, png, and webp files are allowed.");
        
        fileName.value = null;
        return fileName;
    }

    // var fileSize = fileName.files.item(i).size;
    // const fileSizeUpdated = Math.round((fileSize / 1024));

    // if (extention != "jpg" || extention != "jpeg" || extention != "png" || extention != "webp" && extention != "") {
    //     alert("Only jpg, jpeg, png, and webp files are allowed.");
        
    //     return false;
    // }
    // else {
    //     if (fileName[0].size > 10) {
    //         alert("You must upload an image less than 2MB.");
            
    //         return false;
    //     };
    // }
}

function warningDeleteProfile() {
    var confirmDelete = confirm("Are you sure you want to delete your profile? Your account will be permanently removed from AptiStudy.");
    
    if (confirmDelete == true) {
        window.location.href='delete-profile.php';
    }
}

function warningDeleteTicket() {
    var confirmDelete = confirm("Are you sure you want to delete this ticket? This action can't be undone.");
    
    if (confirmDelete == true) {
        window.location.href='delete-ticket.php';
    }
}

// create-profile.php - remove invalid selections in datalist
function resetIfArbitrary(user_choice) {
    if (user_choice.value == "")
        return;
    var options = user_choice.list.options;
    for (var i = 0; i < options.length; i++) {
        if (user_choice.value == options[i].value)
            //option matches
            return;
    }
    //no match was found: reset the value
    user_choice.value = "";
}

// multiselect without needing CTRL
$('option').mousedown(function (e) {
    e.preventDefault();
    var originalScrollTop = $(this).parent().scrollTop();
    console.log(originalScrollTop);
    $(this).prop('selected', $(this).prop('selected') ? false : true);
    var self = this;
    $(this).parent().focus();
    setTimeout(function () {
        $(self).parent().scrollTop(originalScrollTop);
    }, 0);

    return false;
});