var files_arr = JSON.parse(window.files);

var filesmenu = _.reduce(
    files_arr,
    function(accum, file) {
        var foldername = file
                .split("/")[0]
                .split("_")
                .join(" "),
            folder = file.split("/")[0],
            testName = folder.split("_")[1],
            testName =
                "tests/" +
                testName[0].toUpperCase() +
                testName.substring(1) +
                "Test.php";
        accum[folder] = accum[folder] || {
            foldername: foldername,
            examples: []
        };
        accum[folder].examples.push(file);
        return accum;
    },
    {}
);

jQuery(document).ready(function() {
    var createCard = function(index, title) {
        var card = jQuery('<div class="card"/>');
        var card_header = jQuery(
            '<div class="card-header" role="tab" id="heading' + index + '">'
        );
        var h5 = jQuery('<h5 class="mb-0"/>');
        var data_toggle = jQuery(
            '<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href=""  aria-controls="collapse' +
                index +
                '">'
        );
        data_toggle.text(title);
        data_toggle.attr("href", "#collapse" + index);
        data_toggle.appendTo(h5);
        h5.appendTo(card_header);
        card_header.appendTo(card);
        var collapse = jQuery(
            '<div id="collapse' +
                index +
                '" class="collapse" role="tabpanel" aria-labelledby="heading' +
                index +
                '"/>'
        );
        var card_block = jQuery('<div class="card-block"/>');
        var ul = jQuery("<ul/>");
        ul.appendTo(card_block);
        card_block.appendTo(collapse);
        collapse.appendTo(card);
        return card;
    };

    var sidenav = jQuery("#accordion");
    _.each(filesmenu, function(item, index) {
        var folder,
            target,
            card = createCard(index, item.foldername);

        item.examples = _.sortBy(item.examples);
        var ul = card.find("ul");
        card.appendTo(sidenav);
        //card.find('.collapse').collapse();
        _.each(item.examples, function(filepath) {
            if (filepath.indexOf("_omit") === -1) {
                var li = jQuery("<li/>").appendTo(ul),
                    a = jQuery("<a/>").appendTo(li),
                    fileparts = filepath.split("/");
                (folder = fileparts[0]), (target = fileparts[1]);

                a.addClass("example")
                    .attr("target", "graph_iframe")
                    .data("folder", folder)
                    .data("target", target)
                    .attr(
                        "href",
                        "show-example.php?folder=" +
                            folder +
                            "&target=" +
                            target
                    )
                    .text(target.replace(".php", ""));
            }
        });
    });
    jQuery("#accordion").on("click", "a.example", function(e) {
        e.preventDefault();
        jQuery("a.example").removeClass("active");

        var $this = $(this),
            href = $this.attr("href"),
            folder = $this.data("folder"),
            target = $this.data("target"),
            filename = [folder, target].join("/");
        $this.addClass("active");
        jQuery("#graph_iframe").attr("src", href);
        jQuery("#filepath").text(filename);
        return false;
    });
    var firstgroup = jQuery(".card").first();
    firstgroup.find(".collapsed").click();
    firstgroup
        .find("a.example")
        .first()
        .click();
});
