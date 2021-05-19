function deleteConfirm(id) {
    if (confirm("Confirmez la suppression ?")) {
        window.location.href = "/admin/movie/delete/"+id;
    }
}