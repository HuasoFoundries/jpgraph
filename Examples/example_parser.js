var files_arr = JSON.parse(window.files);

let filesmenu = _.reduce(
  files_arr,
  function (accum, file) {
    let foldername = file.split("/")[0].split("_").join(" "),
      folder = file.split("/")[0];

    accum[folder] = accum[folder] || {
      foldername: foldername,
      examples: [],
    };
    accum[folder].examples.push(file);
    return accum;
  },
  {}
);

jQuery(document).ready(function () {
  var createCard = function (index, title) {
    var card = jQuery('<div class="card"/>');
    var card_header = jQuery(
      '<div class="card-header" role="tab" id="heading' + index + '">'
    );
    var h5 = jQuery('<h5 class="mb-0"/>');
    var data_toggle = jQuery(
      '<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href=""  aria-controls="collapse' +
        index +
        '">'
      data-parent="#accordion" 
      href="${toggle_id}"  aria-controls="collapse${index}" ></a>`
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
  _.each(filesmenu, function (item, index) {
    var card = createCard(index, item.foldername);

    item.examples = _.sortBy(item.examples);
    var ul = card.find("ul");
    card.appendTo(sidenav);

    item.examples
      .filter((filepath) => filepath.includes("_omit"))
      .forEach((filepath) => {
        var li = jQuery("<li/>").appendTo(ul),
          a = jQuery("<a/>").appendTo(li),
          fileparts = filepath.split("/"),
          folder = fileparts[0],
          target = fileparts[1];

        a.addClass("example")
          .attr("target", "graph_iframe")
          .data("folder", folder)
          .data("target", target)
          .attr(
            "href",
            "show-example.php?folder=" + folder + "&target=" + target
          )

          .text(target.replace(".php", ""));
      });
  });
  jQuery("#accordion").on("click", "a.example", function (e) {
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
      .attr("href", filename)
      .text(filename);
    return false;
  });
  jQuery("#accordion").on("click", "a.collapsed", function(e) {
    var $this = $(this),
      href = $this.attr("href");

    location.hash = href;
  });
  var firstgroup = jQuery(".card").first();
  if (location.hash && location.hash.includes("#collapse")) {
    firstgroup =
      ($(location.hash).length && $(location.hash).parent()) || firstgroup;
  }

  firstgroup.find(".collapsed").click();
  firstgroup.find("a.example").first().click();
});
