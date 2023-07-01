jQuery(document).ready(function () {
    jQuery(".todo-list-menu").on("click", function () {
        // Tıklama olayı gerçekleştiğinde yapılacak işlemler buraya gelecek
        jQuery('#todoModal').toggle()
        jQuery('.overlay_todo').toggle()
        jQuery('#url_todo').val(window.location);
    });

    jQuery(".close_modal").on("click", function () {
        // Tıklama olayı gerçekleştiğinde yapılacak işlemler buraya gelecek
        jQuery('#todoModal').toggle()
        jQuery('.overlay_todo').toggle()
        jQuery('#url_todo').val(window.location);
    });




    jQuery('#form_todo').on('submit', function (e) {
        e.preventDefault(); // Formun varsayılan gönderimini engelle

        // Form verilerini al
        var title_todo = jQuery('#title_todo').val();
        var url_todo = jQuery('#url_todo').val();
        var priority_todo = jQuery('#priority_todo').val();
        var content_todo = jQuery('#content_todo').val();

        // AJAX POST isteği gönder
        jQuery.ajax({
            url: ajaxurl, // WordPress AJAX URL'si
            type: 'POST',
            data: {
                action: 'submit_form', // AJAX işlemi için eylem adı
                title_todo: title_todo, // Form verisi: başlık
                url_todo: url_todo, // Form verisi: başlık
                priority_todo: priority_todo, // Form verisi: başlık
                content_todo: content_todo // Form verisi: içerik
            },
            success: function (response) {
                addNewRow(title_todo, content_todo, priority_todo, response)
                jQuery('#title_todo').val('');
                jQuery('#priority_todo').val('');
                jQuery('#content_todo').val('');
            }
        });
    });

    function addNewRow(title, content, priority, id) {
        var newRow = jQuery('<tr>'); // Yeni bir <tr> elementi oluştur

        var titleCell = jQuery('<td>').text(title); // Başlık hücresi oluştur ve içeriğini ayarla
        var contentCell = jQuery('<td>').text(content); // İçerik hücresi oluştur ve içeriğini ayarla

        newRow.attr('data-priority', priority); // data-id attribute'ünü ayarla
        newRow.append(titleCell); // Yeni satıra başlık hücresini ekle
        newRow.append(contentCell); // Yeni satıra içerik hücresini ekle

        var deleteForm = jQuery('<form>').attr('id', 'deleteTodo');
        var todoIdInput = jQuery('<input>').attr('type', 'hidden').attr('name', 'todo_id').val(id);
        var deleteButton = jQuery('<button>').attr('type', 'submit');
        var deleteIcon = jQuery('<span>').addClass('delete').text('×');

        deleteButton.append(deleteIcon);
        deleteForm.append(todoIdInput);
        deleteForm.append(deleteButton);

        var deleteCell = jQuery('<td>').append(deleteForm);

        newRow.append(deleteCell);


        jQuery('#todoTable tbody').append(newRow);
        sortByPriority();
    }

    function sortByPriority() {
        var rows = jQuery('#todoTable tbody tr').get();
        rows.sort(function (a, b) {
            var priorityA = jQuery(a).data('priority');
            console.log(priorityA);
            var priorityB = jQuery(b).data('priority');
            console.log(priorityB);
            return priorityB - priorityA;
        });

        jQuery.each(rows, function (index, row) {
            jQuery('#todoTable tbody').append(row);
        });
    }

    jQuery('form[id^="deleteTodo"]').on('submit', function (e) {
        e.preventDefault(); // Formun varsayılan gönderimini engelle


        var todo_id = jQuery(this).find('input').val();
        var tr = jQuery(this).parent().parent();
        // AJAX POST isteği gönder
        jQuery.ajax({
            url: ajaxurl, // WordPress AJAX URL'si
            type: 'POST',
            data: {
                action: 'submit_form_delete', // AJAX işlemi için eylem adı
                todo_id: todo_id, // Form verisi: başlık
            },
            success: function (response) {
                tr.remove();
                console.log(response);
            }
        });

    });
});



