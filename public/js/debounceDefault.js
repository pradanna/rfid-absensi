function keyPressCallback(e) {
    // let text = $(".dataTables_wrapper .dataTables_filter input").val()
    $('#tabel').DataTable().search(this.value).draw();
    // if (text.length >= 2) {
    //     table.search(this.value).draw();
    // }
    // if (text == ''){
    //     table.search(this.value).draw();
    // }
}

$(".dataTables_wrapper .dataTables_filter input")
    .unbind() // Unbind previous default bindings
    .bind("input", debounce(keyPressCallback, 1000));
