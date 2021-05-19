function deleteConfirm(id) {
    if (confirm("Confirmez la suppression ?")) {
        window.location.href = "?controller=Movie&action=DeleteMovie&param="+id;
    }
}
