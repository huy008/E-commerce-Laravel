(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr("content");

    HT.createMenuCatalogue = () => {
        $(document).on("click", ".create_menu_catalogue", function (e) {
            e.preventDefault();
            console.log("Form submission prevented");
            let _this = $(this);
            let name = _this.find("input[name=name]").val();
            let keyword = _this.find("input[name=keyword]").val();
            let option = {
                name: name,
                keyword: keyword,
                _token: token,
            };
            $.ajax({
                url: "http://127.0.0.1:8000/ajax/menu/createCatalogue",
                type: "POST",
                data: option,
                dataType: "json",
                success: function (res) {
                    console.log(res);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                },
            });
        });
    };

    HT.createMenuRow = () => {
        $(document).on("click", ".add-menu", function (e) {
            e.preventDefault();
            let _this = $(this);
            console.log(123);
            $(".menu-wrapper")
                .append(HT.menuRowHtml())
                .find(".notification")
                .hide();
        });
    };
    HT.menuRowHtml = (option) => {
        console.log(option);
        let html = "";
        let $row = $("<div>").addClass(
            "row mb10 menu-item " +
                (typeof option !== "undefined" ? option.canonical : "") +
                ""
        );
        const colums = [
            {
                class: "col-lg-4",
                name: "menu[name][]",
                value: typeof option !== "undefined" ? option.name : "",
            },
            {
                class: "col-lg-4",
                name: "menu[canonical][]",
                value: typeof option !== "undefined" ? option.canonical : "",
            },
            { class: "col-lg-2", name: "menu[order][]", value: 0 },
        ];
        colums.forEach((col) => {
            let $col = $("<div>").addClass(col.class);
            let $input = $("<input>")
                .attr("type", "text")
                .attr("value", col.value)
                .addClass("form-control")
                .attr("name", col.name);
            $col.append($input);
            $row.append($col);
        });
        let $removeCol = $("<div>").addClass("col-lg-2");
        let $removeRow = $("<div>").addClass("form-row text-center");
        let $a = $("<a>").addClass("delete-menu");
        let $i = $("<i>").addClass("fa fa-trash");
        let $input = $("<input>")
            .addClass("hidden")
            .attr("name", "menu[id][]")
            .val(0);
        $a.append($i);
        $removeRow.append($a);
        $removeCol.append($removeRow);
        $removeCol.append($input);
        $row.append($removeCol);
        return $row;
    };

    HT.deleteMenuRow = () => {
        $(document).on("click", ".delete-menu", function () {
            let _this = $(this);
            console.log(123);
            _this.parents(".menu-item").remove();
            HT.checkMenuItemLength();
        });
    };
    HT.checkMenuItemLength = () => {
        if ($(".menu-item").length === 0) {
            $(".notification").show();
        }
    };
    HT.getMenu = () => {
        $(document).on("click", ".menu-module", function (e) {
            let _this = $(this);
            let option = {
                model: _this.attr("data-model"),
            };
            $.ajax({
                url: "http://127.0.0.1:8000/ajax/dashboard/getMenu",
                type: "GET",
                data: option,
                dataType: "json",
                success: function (res) {
                    console.log(res);
                    let html = "";
                    for (let i = 0; i < res.data.length; i++) {
                        html += HT.renderModelMenu(res.data[i]);
                    }
                    $(".menu-list").html(html);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                },
            });
        });
    };
    HT.renderModelMenu = (object) => {
        let html = "";
        html += '<div class="m-item">';
        html += ' <div class="uk-flex uk-flex-middle">';
        html +=
            ' <input type="checkbox" class="m0 choose-menu" value="' +
            object.canonical +
            '" name="" id="' +
            object.id +
            '">';
        html += ' <label for="' + object.id + '">' + object.name + "</label>";
        html += " </div>";
        html += " </div>";
        return html;
    };

    HT.chooseMenu = () => {
        $(document).on("click", ".choose-menu", function () {
            let _this = $(this);
            let canonical = _this.val();
            let name = _this.siblings("label").text();
            let $row = HT.menuRowHtml({
                name: name,
                canonical: canonical,
            });
            let isChecked = _this.prop("checked");
            if (isChecked === true) {
                $(".menu-wrapper").append($row).find(".notification").hide();
            } else {
                $(".menu-wrapper")
                    .find("." + canonical)
                    .remove();
                HT.checkMenuItemLength();
            }
        });
    };
    HT.setupNestable = () => {
        if ($("#nestable2").length > 0) {
            $("#nestable2")
                .nestable({
                    group: 1,
                })
                .on("change", HT.updateNestableOutput);
        }
    };
    HT.updateNestableOutput = (e) => {
        var list = $(e.currentTarget);
        let output = $(list.data("output"));
        let json = window.JSON.stringify(list.nestable("serialize"));

        let option = {
            json: json,
            menu_catalogue_id: $("#dataCatalogue").attr("data-catalogueId"),
            _token: token,
        };
        $.ajax({
            url: "http://127.0.0.1:8000/ajax/menu/drag",
            type: "POST",
            data: option,
            dataType: "json",
            success: function (res) {
                console.log(res);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            },
        });
    };
    $(document).ready(function () {
        HT.createMenuCatalogue();
        HT.createMenuRow();
        HT.deleteMenuRow();
        HT.getMenu();
        HT.chooseMenu();
        HT.setupNestable();
    });
})(jQuery);
