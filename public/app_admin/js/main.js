function orderBy(order, sort) {
    var link = window.location.href;
    link = link.replace('&sort=asc', '');
    link = link.replace('&sort=desc', '');
    link = link.replace('?sort=asc', '');
    link = link.replace('?sort=desc', '');
    var urlParams = new URLSearchParams(location.search);
    var order_old = urlParams.get('order');
    var order_page = urlParams.get('page'); // 1234
    link = link.replace('&order=' + order_old, '');
    link = link.replace('&page=' + order_page, '');
    var n = link.includes("?");
    link = n ? link + '&sort=' + sort : link + '?sort=' + sort
    link = link + '&order=' + order;
    window.location.href = link;
}

// ===========================================================================
function deleteSearchField(temp) {
    const inputField = document.querySelector(`#form_search #${temp}`);
    inputField.value = '';
    const form = document.getElementById('form_search')
    form.submit();
}

function deleteSearchInput(temp, query) {

    let params = new URLSearchParams(query);// Претвори `query` во `URLSearchParams`
    let newParams = new URLSearchParams(); // Нов објект за параметри

    params.forEach((value, key) => {
        if (!key.startsWith(temp)) {
            newParams.append(key, value);
        }
    });

    // Генерирај нов `query string`
    let newQueryString = newParams.toString();

    // Генерирај нов URL без избришаните параметри
    let newUrl = window.location.origin + window.location.pathname;
    if (newQueryString) {
        newUrl += "?" + newQueryString;
    }

    // Освежи ја страницата со новиот URL
    window.location.href = newUrl;

}

function formatContent(title, maxLength = 50, chunkSize = 50) {
    if (!title) return ''; // Ако `title` е `null`, `undefined` или празно, враќа празно
    if (title.length <= maxLength) return title; // Ако текстот е под `maxLength`, враќа оригиналниот текст

    // Форматирање ако текстот е подолг од `maxLength`
    const regex = new RegExp(`[^\s]{${chunkSize},}`, 'g');
    return title.replace(regex, (match) => {
        return match.replace(new RegExp(`(.{${chunkSize}})`, 'g'), '$1 ');
    }).trim();
}

function toggleContent(selector, content) {
    const element = $(selector);
    if (content && content.trim() !== '') {
        element.html(content).show(); // Додај содржина и прикажи го елементот
    } else {
        element.remove(); // Целосно отстрани го елементот ако податокот е празен
    }
}

// Send pareametars to modal_warning ======================================================================
$(document).on("click", ".modal_warning", function () {
    $("#title_war").html(' ' + $(this).data('title'));
    $("#url_war").attr("action", $(this).data('url'));
    $("#url_return_war").attr("value", $(this).data('url_return'));
    $("#query_war").attr("value", $(this).data('query'));
    $("#success_war").attr("value", $(this).data('success'));
    $("#error_war").attr("value", $(this).data('error'));

    // Обработка на содржината и целосно отстранување ако е празна
    toggleContent("#content_war_l", formatContent($(this).data('content_l')));
    toggleContent("#content_war_b", formatContent($(this).data('content_b')));
    toggleContent("#content_war_sub_l", formatContent($(this).data('content_sub_l')));
    toggleContent("#content_war_sub_b", formatContent($(this).data('content_sub_b')));

    // Додавање метод за DELETE ако е потребно
    let method = $(this).data('method');
    if (method === 'DELETE') {
        $('#url_war').find('input[name="_method"]').remove();
        $('#url_war').append('<input type="hidden" name="_method" value="DELETE">');
    }

    // Прикажи го ModalWarning
    let modal = $("#ModalWarning");
    modal.modal('show');

    // Постави правилен z-index за да биде над другите модали
    modal.on('shown.bs.modal', function () {
        let highestZindex = Math.max(...Array.from(document.querySelectorAll('*'))
            .map(el => parseFloat(window.getComputedStyle(el).zIndex))
            .filter(zIndex => !isNaN(zIndex))) || 1050;

        $(".modal-backdrop").last().css("z-index", highestZindex + 10);
        modal.css("z-index", highestZindex + 20);
    });
});


// Send pareametars to modal_show ======================================================================
$(document).on("click", ".modal_image", function () {
    $("#ModalShow .modal-header i")
        .removeClass("fa-exclamation-triangle")
        .addClass("fa-file-image");
    // Добиј го насловот и скрати го ако е предолг
    let title = $(this).data("title");
    if (title.length > 30) {
        const extension = title.split('.').pop(); // Екстензијата (последниот дел по точката)
        const shortTitle = title.substring(0, 20) + "....." + extension;
        title = shortTitle;
    }
    // Додавање на насловот во модалот
    $("#title_image").html(" " + title);
    // Креирање на нов img елемент
    const img = $("<img>")
        .attr("src", $(this).data("url"))       // Поставување на src атрибут
        .attr("alt", $(this).data("title"))     // Поставување на alt атрибут
        .attr("class", "my-image-class")        // Поставување на класа (опционално)
        .css({"max-width": "100%", "height": "auto"}); // Додавање на стилови
    // Чистење на содржината на div и додавање на новиот img елемент
    $("#body_image").empty().append(img);
    $("#ModalImage .modal-content").css({
        "max-width": "100%",
        "width": "auto",
        "display": "inline-block"
    });
});

// ================================================================================================
function delPhoto(message, picture) {

    document.getElementById('file_name_').innerHTML = '';
    document.getElementById('file_name_hidden').value = '';
    document.getElementById('picture_content').setAttribute("style", 'display:none');
    document.getElementById('picture').value = '';
    document.getElementById('custom-file-label').innerHTML = '';
    if (picture) {
        document.getElementById('warning_message').innerHTML = message;
    } else {
        document.getElementById('warning_message').innerHTML = '';
    }
}

function checkImage(object, message_title, message_type, message_size, size, warning_message, picture) {
    // var  FileSize = document.form_doc.file.files[0].size / 1024 / 1024; // in MB
    let fileSize = object.files[0].size / 1024 / 1024;
    let roundedFileSize = fileSize.toFixed(3);
    let filename = object.files[0].name;

    // var filename = a.value.substring(a.value.lastIndexOf('\u005C')+1, a.value.length);
    let fileext = filename.substring(filename.lastIndexOf('.') + 1, filename.length, filename.length);
    if (fileext !== 'jpg' && fileext !== 'JPG' && fileext !== 'jpeg' && fileext !== 'JPEG' && fileext !== 'gif' && fileext !== 'GIF' && fileext !== 'png' && fileext !== 'PNG') {
        document.getElementById('title_res').innerHTML = message_title;
        document.getElementById('content_res_l').innerHTML = message_type;
        $('#ModalRestriction').modal('show');
        object.value = '';
        return false;
    }
    if (fileSize > size) {
        document.getElementById('title_res').innerHTML = message_title;
        document.getElementById('content_res_l').innerHTML = message_size + ' <br> Actual size: <strong>' + roundedFileSize + '</strong> MB';
        $('#ModalRestriction').modal('show');
        object.value = '';
        return false;
    }
    let obj = new FileReader();
    obj.onload = function (data) {
        var image = document.getElementById('upload_image');
        image.src = data.target.result;
        $("#upload_image")
            .data("url", data.target.result)
            .data("data-title", filename)
            .data("title", filename);
        let title = filename;
        if (title.length > 30) {
            const extension = title.split('.').pop(); // Екстензијата (последниот дел по точката)
            const shortTitle = title.substring(0, 20) + "....." + extension;
            title = shortTitle;
        }
        $("#file_name_")
            .html(title)
            .css("display", "block")
            .attr("title", filename);
        $("#warning_message")
            .html(warning_message)
        $("#file_name_hidden")
            .val(filename)
            .css("display", "block");
        $("#picture_content")
            .css("display", "block");
        $("#delPhoto")
            .css("display", "block");
        $("#img_source")
            .attr("src", "");
        $("#saso").val(filename).css("display", "block").trigger('change');
    }
    obj.readAsDataURL(object.files[0]);
}

function getContentID(url, modal, title) {
    console.log("Generated URL:", url);


//alert(url);
    // Отвори го modal-от
    $('#' + modal).modal({
        backdrop: 'static',
        keyboard: false
    });

    // Постави наслов за modal-от
    $('#' + modal + ' .modal-title').html('<i class="fa fa-exclamation-circle text-red"></i> ' + title);

    // Проверка за `refresh-on-close` класа
    if ($('button[onclick*="' + url + '"]').hasClass('modal90')) {
        // Постави динамичка ширина
        $('#' + modal + ' .modal-dialog').css({
            'max-width': '90%',   // Пример: 80% од прозорецот
            'width': 'auto'       // Автоматски прилагодување според содржината
        });
    } else {
        // Врати ја дефолтната ширина
        $('#' + modal + ' .modal-dialog').css({
            'max-width': '',   // Отстрани ја поставената максимална ширина
            'width': ''        // Отстрани поставената ширина
        });
    }

    // Вчитај содржина во modal-от
    getJSP(url, 'content_show', null, function() {
        console.log("Content successfully loaded into modal.");
    }, 0);
}

// Listener за затворање на модал
$('#ModalShow').on('hidden.bs.modal', function () {
    if ($(this).attr('data-refresh') === 'true') {
        location.reload();
    }
});

function toggleSwap() {
//alert(document.getElementById("toggle").src);
    img = document.getElementById("toggle");
    if (img.src.endsWith("eye-open.png"))
        img.src = "/app_admin/images/eye-close.png";
    else if (img.src.endsWith("eye-close.png"))
        img.src = "/app_admin/images/eye-open.png";
}

// Close flash messages ===========================================================================
$('div.toast-top-full-width').not('.alert-important').delay(3000).fadeOut(350);
$('div.alert').not('.alert-important').delay(3000).fadeOut(350);

// ================================================================================================
function closeErrorWindow(a) {
    "use strict";
    a.setAttribute("style", 'display:none');
}

// Send pareametars to modal_document =====================================================================
$(document).on("click", ".open_document", function () {

    $("#url_doc").attr("class", $(this).data('css'));
    $("#title_doc").html($(this).data('title'));

    $("#id_doc").val($(this).data('id'));
    $("#id_user_doc").val($(this).data('id_user'));
    $("#id_module_doc").val($(this).data('id_module'));
    $("#id_record_doc").val($(this).data('id_record'));

    if ($(this).data('active').toString() === '1') {
        $('#active_doc').prop('checked', true);

    } else if ($(this).data('active').toString() === '0') {
        $('#active_doc').prop('checked', false);
    }

    $("#name_doc").val($(this).data('name'));
    $("#name_des_doc").html($(this).data('name_des'));
    $("#file_doc").val($(this).data('file'));
    $("#file_name_doc").html($(this).data('file_name'));
    $("#file_name_desc_doc").html($(this).data('file_name_desc'));
    $("#comment_doc").html($(this).data('comment'));

    $("#url_doc").attr("action", $(this).data('url'));
    $("#url_return_doc").val($(this).data('url_return'));
    $("#query").val($(this).data('query'));
    $("#success_doc").val($(this).data('success'));
    $("#error_doc").val($(this).data('error'));

});

function checkDocuments(object, massage_warning, massage_to_large, massage_wrong_ext) {
    // var  FileSize = document.form_doc.file.files[0].size / 1024 / 1024; // in MB
    let fileSize = object.files[0].size / 1024 / 1024;
    let roundedFileSize = fileSize.toFixed(3);
    let filename = object.files[0].name;
    let fileext = filename.substring(filename.lastIndexOf('.') + 1, filename.length).toLowerCase();
    if (!['pdf', 'docx', 'doc', 'xlsx', 'xls', 'txt', 'ppt', 'pptx'].includes(fileext)) {
        document.getElementById('title_res').innerHTML = massage_warning;
        document.getElementById('content_res_l').innerHTML = massage_wrong_ext;
        $('#ModalRestriction').on('show.bs.modal', function () {
            $('.modal').not(this).css('z-index', 1049); // Намали z-index на сите други модали
            $(this).css('z-index', 1050); // Зголеми z-index за ModalRestriction
        });
        $('#ModalRestriction').modal('show');
        object.value = '';
        document.getElementById('file_name_doc').value = '';
        return false;

    }

    if (fileSize > 20) {
        document.getElementById('title_res').innerHTML = massage_warning;
        document.getElementById('content_res_l').innerHTML = massage_to_large;
        $('#ModalRestriction').on('show.bs.modal', function () {
            $('.modal').not(this).css('z-index', 1049); // Намали z-index на сите други модали
            $(this).css('z-index', 1050); // Зголеми z-index за ModalRestriction
        });
        $('#ModalRestriction').modal('show');
        object.value = '';
        document.getElementById('file_name_doc').value = '';
        return false;
    }

    document.getElementById('file_name_doc').innerHTML = filename;
}

function saveDocument() {

    const idDoc = document.getElementById('id_doc').value.trim();
    const nameDoc = document.getElementById('name_doc').value.trim();
    const fileDoc = document.getElementById('file_doc');
    const urlDocForm = document.getElementById('url_doc');

    // Reset validation
    fileDoc.required = false;
    // Validate file and name
    if (idDoc === '' && (fileDoc.files.length === 0 || nameDoc === '')) {
        fileDoc.required = true; // Set required for file
        urlDocForm.classList.add('was-validated'); // Add validation class
        return false;
    }
    if (idDoc !== '' && nameDoc === '') {
        fileDoc.required = true; // Set required for file
        urlDocForm.classList.add('was-validated'); // Add validation class
        return false;
    }
    // Submit the form
    urlDocForm.submit();
}

function fillDropdown(url, container) {
    //alert(url);
    // return false;
    console.log("Generated  URL:", url);
    getJSP(url, container, null, null, 0);
}
function fillDropdownActivity(url, container, id_group) {
    console.log("Generated URL:", url);

    // Повик на getJSP со обработка на `container`
    getJSP(url, container, null, function () {
        const containerElement = document.getElementById(container);
        if (containerElement) {
            console.log(`Container content updated. Content: ${containerElement.innerHTML}`);

            // Најди го селектот во ново-вметнатата содржина
            const dropdown = containerElement.querySelector('select#id_activity');
            if (dropdown) {
                // Ажурирај го ID и име
                dropdown.id = `id_activity${id_group}`;
                dropdown.name = `id_activity${id_group}`;
                console.log(`Updated dropdown ID and name to id_activity${id_group}`);
            } else {
                console.error("No <select> element with ID 'id_activity' found.");
            }
        } else {
            console.error(`Container with ID ${container} not found.`);
        }
    }, 0);
}

function fillDropdownAssignment(url, container, id_group) {
    console.log("Generated URL:", url);

    // Повик на getJSP со обработка на `container`
    getJSP(url, container, null, function () {
        const containerElement = document.getElementById(container);
        if (containerElement) {
            console.log(`Container content updated. Content: ${containerElement.innerHTML}`);

            // Најди го селектот во ново-вметнатата содржина
            const dropdown = containerElement.querySelector('select#id_assignment');
            if (dropdown) {
                // Ажурирај го ID и име
                dropdown.id = `id_assignment${id_group}`;
                dropdown.name = `id_assignment${id_group}`;
                console.log(`Updated dropdown ID and name to id_assignment${id_group}`);
            } else {
                console.error("No <select> element with ID 'id_assignment' found.");
            }
        } else {
            console.error(`Container with ID ${container} not found.`);
        }
    }, 0);
}
function validateForm() {
    let isValid = true;

    // Get form elements
    const nameDoc = document.getElementById('name_doc');
    const fileDoc = document.getElementById('file_doc');

    // Reset validation classes
    nameDoc.classList.remove('is-invalid');
    fileDoc.classList.remove('is-invalid');

    // Validate name_doc
    if (nameDoc.value.trim() === '') {
        nameDoc.classList.add('is-invalid');
        isValid = false;
    }

    // Validate file_doc
    if (fileDoc.files.length === 0) {
        fileDoc.classList.add('is-invalid');
        isValid = false;
    }

    return isValid; // Return false to prevent form submission if invalid
}

// Send pareametars to modal3 =====================================================================
$(document).on("click", ".open_modal3", function () {
    $("#ModalPic_title").html($(this).data('edit_title'));


    $("#id_galleries").val($(this).data('id_galleries'));
    $("#id_menu").val($(this).data('id_menu'));
    $("#query").val($(this).data('query'));

    $("#description").val($(this).data('description'));

    $("#file").val('');
    if ($(this).data('publish') == '1') {
        $('#publish_pic').attr('checked', 'checked');
        //alert($(this).data('publish'));
    }
    if ($(this).data('publish') == '0') {
        //alert($(this).data('publish'));
        document.getElementById('publish_pic').checked = false
        //$('#publish_doc').attr('checked', '');
    }

    $("#file_desc").html('');

    $("#form_pic").attr("action", $(this).data('url'));
    $("#form_pic").attr("class", $(this).data('css'));


});


$(document).on('click', '.btn-submit', function (e) {
    let form = $(this).closest('form');  // Најди ја формата што е поврзана со копчето
    let isValid = true;
    let hasAtLeastOneDuration = false;

    // Валидација на сите required полиња (освен duration[])
    form.find('[required]').each(function () {
        if (!$(this).val()) {
            $(this).addClass('is-invalid');  // Ако е празно, додај црвена граница
            isValid = false;
        } else {
            $(this).removeClass('is-invalid');  // Отстрани црвена граница ако е пополнето
        }
    });


    if ($(this).hasClass('check-duration')) {
        let hasAtLeastOneDuration = false; // Флаг за проверка на duration полиња

        // Проверка на сите `duration-input` полиња во оваа форма
        form.find('.duration-input').each(function () {
            let value = $(this).val();

            if (value) {
                if (value.match(/^[1-9]$|^1[0-6]$/)) {
                    hasAtLeastOneDuration = true; // Најдено е валидно duration поле
                    $(this).removeClass('is-invalid'); // Отстрани ја невалидната класа ако е валидно
                } else {
                    $(this).addClass('is-invalid'); // Додај класа за грешка ако вредноста не е валидна
                    isValid = false;
                }
            } else {
                $(this).removeClass('is-invalid'); // Отстрани ја невалидната класа ако е празно
            }
        });

        // Ако нема ниту едно пополнето duration поле, означи го како невалидно
        if (!hasAtLeastOneDuration) {
            toastr.error("At least one duration field must be filled with a valid value (1-16).");
            isValid = false;
        }
    }

    // Ако не е валидно, спречи submit
    if (!isValid) {
        e.preventDefault();  // Спречи submit
        return;
    }

    // Ако има ajax класа -> AJAX submit
    if ($(this).hasClass('ajax')) {
        e.preventDefault();  // Спречи класичен submit ако е AJAX

        let formData = new FormData(form[0]);  // Собери ги податоците од формата
        let url = form.attr('action');  // Прочитај URL од action на формата
        let targetContainer = form.find('input[name="container"]').val();

        // AJAX повик за внесување на записите
        getJSP(url, targetContainer, null, function () {
            toastr.success("Successfully updated!");

            // Додај повик за рефреш на контејнерот
            let refreshContainer = document.getElementById('refresh-container').value;
            let refreshRoute = document.getElementById('refresh-route').value;
            refreshIndexContainer(refreshContainer, refreshRoute);
        }, 0, formData);
    } else {
        // Ако нема ajax класа, дозволи класичен submit
        form.submit();
    }
});


// Функција за рефреш на контејнер
function refreshIndexContainer(refreshContainer, refreshRoute) {
    $.get(refreshRoute, function (data) {
        $('#' + refreshContainer).html(data); // Освежи го контејнерот
    }).fail(function () {
        toastr.error("Failed to refresh records list.");
    });
}


// Отстрани грешка ако корисникот почне да пополнува поле
$(document).on('input', '[required]', function () {
    if ($(this).val()) {
        $(this).removeClass('is-invalid');
    }
});

// ===========================================================================
// Функција за селектирање на сите чекбоксови
function selectAllLock(className, masterCheckboxId) {
    const masterCheckbox = document.getElementById(masterCheckboxId);
    const checkboxes = document.querySelectorAll('.' + className);

    checkboxes.forEach(function (checkbox) {
        checkbox.checked = masterCheckbox.checked;
    });
}

// Автоматско ажурирање на главниот чекбокс кога ќе се кликне на индивидуален чекбокс
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[type="checkbox"][class]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const className = checkbox.classList[0];  // Земаме ја првата класа на чекбоксот
            const masterCheckboxId = checkbox.getAttribute('data-master');  // Читаме data атрибутот

            const totalCheckboxes = document.querySelectorAll('.' + className).length;
            const checkedCheckboxes = document.querySelectorAll('.' + className + ':checked').length;

            // Ако сите се чекирани, означи го master checkbox-от
            const masterCheckbox = document.getElementById(masterCheckboxId);
            if (masterCheckbox) {
                masterCheckbox.checked = (totalCheckboxes === checkedCheckboxes);
            }
        });
    });
});
// ===========================================================================

// Функција за преместување на содржината помеѓу колоните
function moveColumnBasedOnWidth() {
    const table = document.getElementById('example2'); // Пронајди ја табелата по ID

    // Проверете дали табелата постои
    if (!table) {
        console.warn('Table with id "example2" not found.');
        return; // Ако табелата не постои, излезете од функцијата
    }

    const rows = table.querySelectorAll('tr'); // Селектирај сите редови од табелата

    rows.forEach(row => {
        const sourceCell = row.querySelector('.source-cell'); // Селектирај ја source-cell
        const targetCell = row.querySelector('.target-cell'); // Селектирај ја target-cell

        if (!sourceCell || !targetCell) {
            return; // Ако некоја од клетките не постои, продолжете со следниот ред
        }

        if (window.innerWidth < 1400) {
            // Ако ширината на прозорецот е помала од 1400px
            if (sourceCell.innerHTML.trim() !== '') {
                targetCell.innerHTML = sourceCell.innerHTML; // Премести содржината во target-cell
                sourceCell.innerHTML = ''; // Испразни ја source-cell
            }
        } else {
            // Ако ширината на прозорецот е 1400px или поголема
            if (targetCell.innerHTML.trim() !== '') {
                sourceCell.innerHTML = targetCell.innerHTML; // Врати ја содржината во source-cell
                targetCell.innerHTML = ''; // Испразни ја target-cell
            }
        }
    });
}

// Додај слушачи за resize и load
window.addEventListener('resize', moveColumnBasedOnWidth); // Изврши ја функцијата при промена на прозорецот
window.addEventListener('DOMContentLoaded', moveColumnBasedOnWidth); // Изврши ја функцијата кога DOM е вчитан


// Слушачи за resize и load за да се изврши функцијата на соодветните настани
window.addEventListener('resize', moveColumnBasedOnWidth);
window.addEventListener('DOMContentLoaded', () => {
    moveColumnBasedOnWidth(); // Повикај ја функцијата откако HTML е целосно вчитан
});




// function toggleInputField(selectElement) {
//     // Пронајди го input полето што е поврзано со select полето
//     const inputField = document.getElementById(`custom_${selectElement.id}`);
//
//     if (selectElement.value === 'custom') {
//         // Ако е избрано "Other", покажи го input полето
//         inputField.style.display = 'block';
//         inputField.focus();
//     } else {
//         // Сокриј го input полето ако е избрана друга опција
//         inputField.style.display = 'none';
//         inputField.value = ''; // Исчисти го внесот
//     }
// }

// ===========================================================================
function savePicture() {
    alert('fsdfsd');
    if (document.getElementById('file').value === '') {
        document.getElementById('url_doc').className = 'needs-validation was-validated'
        return false;
    }
    url_doc.submit();
}

// ===========================================================================



