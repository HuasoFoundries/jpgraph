$(document).ready(() => {
  //console.log(graph, image, plot, text, themes);
  function process(group) {
    return _.reduce(
      group,
      (accum, constant) => {
        let parts = constant.split("_"),
          prefix = parts.length === 1 ? "NO_PREFIX" : parts.shift();
        accum[prefix] = accum[prefix] || [];
        accum[prefix].push(parts.join("_"));
        return accum;
      },
      {}
    );
  }
  // regex
  // [\s\(:][A-Z]{3,20}[A-Z0-9_]+\b
  let prior = [
      "ARROW",
      "ARROWT",
      "AXSTYLE",
      "BGRAD",
      "CONSTRAIN",
      "DAYSTYLE",
      "DEFAULT",
      "DEPTH",
      "GANTT",
      "GRAD",
      "IMG",
      "JPGRAPH",
      "LBLALIGN",
      "LEGEND",
      "LINESTYLE",
      "MARK",
      "MAX",
      "POLAR",
      "SIDE",
      "SUPERSAMPLING"
    ],
    groups = {
      plot,
      image,
      graph,
      text,
      themes
    },
    processed = _.map(groups, (value, key) => {
      return {
        key,
        value,
        prefixes: process(value),
        unique: _.difference(
          value,
          _.reduce(
            _.omit(groups, [key]),
            (accum, group) => {
              accum = accum.concat(group);
              return accum;
            },
            []
          )
        ),
        unique_prefixes: _.difference(
          Object.keys(process(value)),
          Object.keys(
            process(
              _.reduce(
                _.omit(groups, [key]),
                (accum, group) => {
                  accum = accum.concat(group);
                  return accum;
                },
                []
              )
            )
          )
        )
      };
    });
  /*
    {
      key: "intersection",
      value: _.intersection(graph, plot, image),
      prefixes: process(_.intersection(graph, plot, image 
      //, text, themes))
    },*/
  let common_accum = [];
  processed.forEach(obj => {
    let common = _.intersection(
        Object.keys(
          obj.prefixes
          //_.omit(obj.prefixes, prior)
        ),
        prior
      ),
      col = $('<div class="col-md-12  "></div>').append(
        "<br><span>" +
          obj.key +
          "(" +
          obj.value.length +
          ", " +
          Object.keys(obj.prefixes).length +
          ")</span>"
      ),
      textarea = $(
        '<br><textarea cols="40" rows="8" style="font-size:11px">' +
          []
            .concat(`\n---------- unique: \n`)
            .concat(_.sortBy(obj.unique_prefixes))
            .join(",\n") +
          "</textarea><hr>"
      )
        .attr("id", obj.key)
        .appendTo(col),
      textarea2 = $(
        '<br><textarea cols="210" rows="8" style="font-size:11px">' +
          Object.keys(
            obj.prefixes
            //_.omit(obj.prefixes, prior)
          )
            //obj.value
            .concat(`\n---------- Graph\Configs::getConfig('COMMON'): \n`)
            .concat(common)
            .join(", ") +
          "</textarea><hr>"
      )
        .attr("id", obj.key)
        .appendTo(col),
      row = $('<div class="row">')
        .append(col)
        .appendTo($("#container"));
    common_accum = common_accum.concat(common);
    prior = prior.concat(Object.keys(obj.prefixes));
  });
  console.log(_.uniq(common_accum));
});
//    prior = prior.concat(_.omit(Object.keys(obj.prefixes), ["NO_PREFIX"]));
