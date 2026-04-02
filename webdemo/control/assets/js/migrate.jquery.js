(function ($) {
    // Polyfill for missing $.base64 plugin
    $.base64 = {
        utf8encode: false,
        utf8decode: false,
        encode: function (data) {
            if (this.utf8encode) data = unescape(encodeURIComponent(data));
            return btoa(data);
        },
        decode: function (data) {
            data = atob(data);
            if (this.utf8decode || this.utf8encode) { // Many old plugins use utf8encode for both directions
                try {
                    data = decodeURIComponent(escape(data));
                } catch (e) {
                    // Fallback if not valid UTF-8
                }
            }
            return data;
        },
        btoa: function (data) {
            return this.encode(data);
        },
        atob: function (data) {
            return this.decode(data);
        }
    };

    $.fn.tableAddCounter = function (options) {

        const settings = $.extend({
            title: '#',
            start: 1,
            id: '',
            cssClass: '',
            posAt: 'first-child'
        }, options);

        return this.each(function () {
            const $table = $(this);
            if (!$table.is('table')) return;
            const theadRows = $table.find('thead tr').length;
            $table.find('thead tr').each(function (rowIndex) {
                const $row = $(this);
                if (rowIndex === 0) {
                    const cellTag = $row.children().first().prop('tagName') || 'TH';
                    const newCell = $('<' + cellTag + '>', {
                        rowspan: theadRows,
                        class: settings.cssClass,
                        id: settings.id,
                        text: settings.title
                    });
                    if (settings.posAt === 'first-child')
                        $row.prepend(newCell);
                    else
                        $row.append(newCell);
                }
            });

            let counter = settings.start;
            $table.find('tbody tr').each(function () {
                const td = $('<td>', { text: counter++ });
                if (settings.posAt === 'first-child')
                    $(this).prepend(td);
                else
                    $(this).append(td);
            });
        });
    };


    $.fn.loadGrid = function (options) {
        const settings = $.extend({
            pageName: '',
            fillTo: this
        }, options);
        return $.ajax({
            type: "POST",
            dataType: "html",
            url: settings.pageName,
            beforeSend: function () {
                $.fn.ajaxLoading();
            },
            success: function (data) {
                $(settings.fillTo).html(data);
            },
            error: function () {
                $.fn.custom_alert({
                    msg: 'Something went wrong. Please try again!'
                });
            },
            complete: function () {
                $.fn.ajaxLoading({ show: false });
            }
        });
    };

    $.fn.CheckAll = function (options) {

        const settings = $.extend({
            chkName: '',
            ckFlage: true
        }, options);

        $("input[type='checkbox'][name='" + settings.chkName + "']")
            .prop('checked', settings.ckFlage);
    };


    $.fn.FillData = function (options) {

        const settings = $.extend({
            url: '',
            Arr: {},
            Fill_To: '',
            FillHtml: true,
            Async: true
        }, options);

        $.ajax({
            type: 'POST',
            url: settings.url,
            data: settings.Arr,
            async: settings.Async,
            beforeSend: function () {
                $.fn.ajaxLoading();
            },
            success: function (data) {

                const $el = $("#" + settings.Fill_To);

                if (!settings.FillHtml) {

                    const dropval = data.toString().split('|');
                    $el.empty();

                    dropval.forEach(function (item) {
                        const temp = item.split('#$#');
                        $el.append(
                            $('<option>', {
                                value: temp[0],
                                text: temp[1]
                            })
                        );
                    });

                } else {

                    if ($el.is('input[type="text"]')) {
                        $el.val(data);
                    } else {
                        $el.html(data);
                    }
                }
            },
            complete: function () {
                $.fn.ajaxLoading({ show: false });
            }
        });
    };


    $.fn.ShowError = function (errors) {
        let firstField = null;

        $.each(errors, function (i, eDom) {

            let selector = "#" + eDom[0] + "_" + eDom[1] + "_errorloc";
            let $errorEl = $(selector);

            if (!$errorEl.length) {
                const fixedName = eDom[1].replace(/\[/g, '\\[').replace(/\]/g, '\\]');
                $errorEl = $("#" + eDom[0] + "_" + fixedName + "_errorloc");
            }

            const alertHtml =
                `<div class="alert alert-danger alert-dismissible fade show">
                    ${eDom[3]}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                 </div>`;

            $errorEl.html(alertHtml).show();

            // Store the first field to focus on it
            if (i === 0) {
                firstField = eDom[1];
            }
        });

        // Focus on the first field with an error
        if (firstField) {
            const $field = $(`[name="${firstField}"], #${firstField.replace(/\[/g, '\\[').replace(/\]/g, '\\]')}`);
            if ($field.length) {
                $field.first().focus();
            }
        }
    };

    $.fn.ShowMsg = function (options) {

        const settings = $.extend({
            alertClass: 'alert-info',
            msg: '',
            dismiss: true
        }, options);

        const dismissBtn = settings.dismiss
            ? `<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`
            : '';

        const html =
            `<div class="alert ${settings.alertClass} alert-dismissible fade show">
                ${settings.msg}
                ${dismissBtn}
             </div>`;

        return this.each(function () {

            const $el = $(this);

            $el.html(html).fadeIn();

            setTimeout(function () {
                $el.fadeOut();
            }, 5000);
        });
    };







    $.fn.OpenPop = function (options) {
        const settings = $.extend({
            url: '',
            title: ''
        }, options);
        const modalEl = document.getElementById('PopWind');
        const modal = new bootstrap.Modal(modalEl);
        $('#PopWind .modal-body').html(`
        <div class="text-center py-4">
            <div class="spinner-border"></div>
        </div>
    `);
        if (settings.title) {
            $('#PopWindTitle').text(settings.title);
        }
        modal.show();
        $.get(settings.url, function (response) {
            $('#PopWind .modal-body').html(response);
        });
    };







    $.fn.ajaxLoading = function (options) {

        const settings = $.extend({
            show: true,
            appendTo: 'body'
        }, options);

        let $overlay = $('.ajax-overlay');

        if (!$overlay.length) {
            $overlay = $('<div class="ajax-overlay"></div>')
                .append('<div class="spinner-border text-primary"></div>')
                .appendTo(settings.appendTo);
        }

        if (settings.show)
            $overlay.fadeIn();
        else
            $overlay.fadeOut();
    };


    $.fn.highlight = function (text) {

        const pattern = new RegExp('(' + text + ')', 'gi');

        return this.each(function () {
            $(this).html(
                $(this).html().replace(pattern,
                    '<span class="highlight">$1</span>')
            );
        });
    };

    $.fn.removeHighlight = function () {
        return this.find('span.highlight').each(function () {
            $(this).replaceWith($(this).text());
        }).end();
    };

    $.fn.formChecks = function (options) {
        const settings = $.extend({
            nonASCII: false,
            ajaxSubFunc: null
        }, options);

        const $form = $(this);

        $form.on('submit', function (e) {
            // Re-implement the same validation logic as server-side requestcheck
            // If ajaxSubFunc is provided, use it for submission
            if (settings.ajaxSubFunc) {
                e.preventDefault();
                settings.ajaxSubFunc($form);
            }
        });

        return this;
    };

    $.fn.SetToFirstFocus = function () {
        this.find('input, select, textarea').not(':hidden').first().focus();
        return this;
    };

})(jQuery);

