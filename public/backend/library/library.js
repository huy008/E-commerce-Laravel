(function ($) {
    "use strict";
    var HT = {};
    var token = $('meta[name="csrf-token"]').attr("content");

    HT.switchery = () => {
        $(".js-switch").each(function () {
            var switchery = new Switchery(this, {
                color: "#1AB394",
            });
        });
    };
    HT.select2 = () => {
        if ($(".setupSelect2").length) $(".setupSelect2").select2();
    };

    HT.changeStatus = () => {
        $(document).on("change", ".status", function (e) {
            let _this = $(this);
            let value = _this.val();
            let modelId = _this.attr("data-modelId");
            let option = {
                value: value,
                modelId: modelId,
                model: _this.attr("data-model"),
                field: _this.attr("data-field"),
                _token: token,
            };
            $.ajax({
                url: "http://127.0.0.1:8000/ajax/dashboard/changeStatus",
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
            e.preventDefault();
        });
    };

    HT.checkAll = () => {
        if ($("#checkAll").length) {
            $(document).on("click", "#checkAll", function () {
                let isChecked = $(this).prop("checked");
                $(".checkItem").prop("checked", isChecked);
                $(".checkItem").each(function () {
                    let _this = $(this);
                    HT.changeBackground(_this);
                });
            });
        }
    };

    HT.checkBoxItem = () => {
        if ($(".checkItem").length) {
            $(document).on("click", ".checkItem", function () {
                let _this = $(this);
                HT.changeBackground(_this);
                HT.allChecked();
            });
        }
    };

    HT.changeBackground = (obj) => {
        let isChecked = obj.prop("checked");
        if (isChecked) obj.closest("tr").addClass("active_bg");
        else obj.closest("tr").removeClass("active_bg");
    };

    HT.allChecked = () => {
        let allChecked =
            $(".checkItem:checked").length === $(".checkItem").length;
        $("#checkAll").prop("checked", allChecked);
    };

    HT.changeStatusAll = () => {
        if ($(".changeStatusAll").length) {
            $(document).on("click", ".changeStatusAll", function (e) {
                let _this = $(this);
                let id = [];
                $(".checkItem").each(function () {
                    let checkBox = $(this);
                    if (checkBox.prop("checked")) {
                        id.push(checkBox.val());
                    }
                });

                let option = {
                    value: _this.attr("data-value"),
                    model: _this.attr("data-model"),
                    field: _this.attr("data-field"),
                    id: id,
                    _token: token,
                };
                console.log(option);
                $.ajax({
                    url: "http://127.0.0.1:8000/ajax/dashboard/changeStatusAll",
                    type: "POST",
                    data: option,
                    dataType: "json",
                    success: function (res) {
                        if (res.flag == true) {
                            location.reload();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);
                    },
                });
                e.preventDefault();
            });
        }
    };

    $(document).ready(function () {
        HT.switchery();
        HT.select2();
        HT.changeStatus();
        HT.checkAll();
        HT.checkBoxItem();
        HT.allChecked();
        HT.changeStatusAll();
    });
})(jQuery);
