jQuery(document).ready(function ($) {
    $(".todo-list-menu").on("click", function () {
        $("#todoModal").toggle();
        $(".overlay_todo").toggle();
        $("#url_todo").val(window.location.href);
    });

    $(".close_modal").on("click", function () {
        $("#todoModal").toggle();
        $(".overlay_todo").toggle();
        $("#url_todo").val(window.location.href);
    });

    $("#form_todo").on("submit", function (e) {
        e.preventDefault();

        var title_todo = $("#title_todo").val();
        var form_todo_nonce_field = $("#form_todo_nonce_field").val();
        var url_todo = $("#url_todo").val();
        var priority_todo = $("#priority_todo").val();
        var content_todo = $("#content_todo").val();

        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                action: "submit_form",
                form_todo_nonce_field: form_todo_nonce_field,
                title_todo: title_todo,
                url_todo: url_todo,
                priority_todo: priority_todo,
                content_todo: content_todo,
            },
            success: function (response) {
                addNewRow(title_todo, content_todo, priority_todo, response);
                $("#title_todo").val("");
                $("#priority_todo").val("");
                $("#content_todo").val("");
            },
        });
    });

    function addNewRow(title, content, priority, response) {
        var newRow = $("<tr>");
        var titleCell = $("<td>").text(title);
        var contentCell = $("<td>").text(content);

        newRow.attr("data-priority", priority);
        newRow.append(titleCell);
        newRow.append(contentCell);

        var deleteForm = $("<form>").attr("id", "deleteTodo" + response.split("//")[0]);
        var todoIdInput = $("<input>")
            .attr("type", "hidden")
            .attr("name", "todo_id")
            .val(response.split("//")[0]);
        var deleteButton = $("<button>").attr("type", "submit");
        var deleteIcon = $("<span>").addClass("delete").text("×");

        deleteButton.append(deleteIcon);
        deleteForm.append(todoIdInput);
        deleteForm.append(deleteButton);

        var deleteCell = $("<td>").append(deleteForm);

        newRow.append(deleteCell);

        $("#todoTable tbody").append(newRow);
        sortByPriority();
    }

    function sortByPriority() {
        var rows = $("#todoTable tbody tr").get();
        rows.sort(function (a, b) {
            var priorityA = $(a).data("priority");
            var priorityB = $(b).data("priority");
            return priorityB - priorityA;
        });

        $.each(rows, function (index, row) {
            $("#todoTable tbody").append(row);
        });
    }

    $('form[id^="deleteTodo"]').on("submit", function (e) {
        e.preventDefault();

        var todo_id = $(this).find("#todo_id").val();
        var tr = $(this).parent().parent();
        var delete_form_todo_nonce_field = tr.find("#delete_form_todo_nonce_field").val();

        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                action: "submit_form_delete",
                todo_id: todo_id,
                delete_form_todo_nonce_field: delete_form_todo_nonce_field,
            },
            success: function (response) {
                tr.remove();
            },
        });
    });
});
