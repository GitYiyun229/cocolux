import autoComplete from "@tarekraafat/autocomplete.js";
$(document).ready(function() {
    $('.item-parent, .item-child').on('click', function() {
        var selectedItem = $(this).data('value');
        $('#cat_product').val(selectedItem);
    });
    $('#search_product').submit(function () {
        $(this).find('input').each(function () {
            if ($(this).val() === '') {
                $(this).remove();
            }
        });
    });

    const autoCompleteJS = new autoComplete({
        selector: "#keyword",
        placeHolder: "Tìm sản phẩm bạn mong muốn...",
        data: {
            src: async (query) => {
                try {
                    // Fetch Data from external Source
                    const product_ids = $('#products_add').val();
                    const response = await fetch(window.searchAjaxRoute,{
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            keyword: query,
                            product_ids: product_ids,
                            _token: $('meta[name="csrf-token"]').attr("content")
                        })
                    });
                    // Data should be an array of `Objects` or `Strings`
                    const data = await response.json();
                    return data.data;
                } catch (error) {
                    return error;
                }
            },
            keys: ["title","sku",'slug']
        },
        resultsList: {
            element: (list, data) => {
                const info = document.createElement("p");
                if (data.results.length > 0) {
                    // info.innerHTML = `Displaying <strong>${data.results.length}</strong> out of <strong>${data.matches.length}</strong> results`;
                } else {
                    info.innerHTML = `Found <strong>${data.matches.length}</strong> matching results for <strong>"${data.query}"</strong>`;
                }
                list.prepend(info);
            },
            noResults: true,
            maxResults: 30,
            tabSelect: true
        },
        resultItem: {
            element: (item, data) => {
                // Modify Results Item Style
                item.style = "display: flex; justify-content: space-between;";
                // Modify Results Item Content
                item.innerHTML = `
                      <a style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;" href="${data.value.link_product}">
                        ${data.value.title}
                      </a>`;
            },
            highlight: true,
        },
        diacritics: true,
        events: {
            input: {
                click: () => {

                },
            }
        }
    });
    autoCompleteJS.init();

    $('#keyword').keydown(function(event) {
        if (event.keyCode == 13 && !event.shiftKey) {
            event.preventDefault();
            $('#search_product').submit();
        }
    });
});
