function deleteDetailConfirm(id) {
    if (confirm("Confirmez la suppression ?")) {
        window.location.href = "/infomovie/deletecomment/" + id;
    }
}

function ToSee(id) {
    window.location.href = "/infomovie/tosee/" + id;
}

function ToShare(id) {
    window.location.href = "/infomovie/toshare/" + id;
}