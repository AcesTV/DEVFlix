function deleteDetailConfirm(id) {
    if (confirm("Confirmez la suppression ?")) {
        window.location.href = "/?controller=InfoMovie&action=DeleteInfoMovie&param=" + id;
    }
}