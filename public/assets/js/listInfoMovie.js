function deleteDetailConfirm(id) {
    if (confirm("Confirmez la suppression ?")) {
        window.location.href = "/infomovie/deletecomment/" + id;
    }
}