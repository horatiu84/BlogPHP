$("a.delete").on("click", function (e) {
    e.preventDefault();

    if (confirm("Are you sure?")) {
        alert("Delete the article!");

        var frm = $("<form>");
        frm.attr('method','post');
        frm.attr('action',$(this).attr('href'));
        frm.appendTo("body");
        frm.submit();
    }
})