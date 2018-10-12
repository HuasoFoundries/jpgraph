<?php

function GetFiles()
{
    $d = dir(__DIR__);
    $a = [];
    while ($entry = $d->Read()) {
        if (is_dir($entry) && ($entry != 'assets') && $entry !== '.' && $entry !== '..') {
            $examplefolder = dir($entry);
            while ($file = $examplefolder->Read()) {
                if (is_dir($file) || !strstr($file, '.php')) {
                    continue;
                }
                if (!strstr($entry, 'csim') && strstr($file, 'x') && !strstr($file, 'show') && !strstr($file, 'csim')) {
                    $a[] = $entry . '/' . $file;
                } elseif (strstr($entry, 'csim') && !strstr($entry, 'graph')) {
                    $a[] = $entry . '/' . $file;
                }
            }
        }
    }
    $d->Close();
    if (count($a) == 0) {
        die("PANIC: Apache/PHP does not have enough permission to read the scripts in directory: {$this->iDir}");
    }
    sort($a);

    return $a;
}

$files = GetFiles();
echo "files='" . json_encode($files) . "';";
?>
files_arr=JSON.parse(files);

var filesmenu = _.reduce(files_arr, function(accum, file) {
    var foldername = file.split('/')[0].split('_').join(' '),
        folder = file.split('/')[0],
        testName = folder.split('_')[1],
        testName = 'tests/' + testName[0].toUpperCase() + testName.substring(1) + 'Test.php';
    accum[folder] = accum[folder] || {
        foldername: foldername,
        examples: []
    };
    accum[folder].examples.push(file);
    return accum;
}, {});



jQuery(document).ready(function() {

    var createCard = function(index, title) {
        var card = jQuery('<div class="card"/>');
        var card_header = jQuery('<div class="card-header" role="tab" id="heading' + index + '">');
        var h5 = jQuery('<h5 class="mb-0"/>');
        var data_toggle = jQuery('<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href=""  aria-controls="collapse' + index + '">');
        data_toggle.text(title);
        data_toggle.attr('href', '#collapse' + index);
        data_toggle.appendTo(h5);
        h5.appendTo(card_header);
        card_header.appendTo(card);
        var collapse = jQuery('<div id="collapse' + index + '" class="collapse" role="tabpanel" aria-labelledby="heading' + index + '"/>');
        var card_block = jQuery('<div class="card-block"/>');
        var ul = jQuery('<ul/>');
        ul.appendTo(card_block);
        card_block.appendTo(collapse);
        collapse.appendTo(card);
        return card;
    };


    var sidenav = jQuery('#accordion');
    _.each(filesmenu, function(item, index) {
        var card = createCard(index, item.foldername);

        item.examples = _.sortBy(item.examples);
        var ul = card.find('ul');
        card.appendTo(sidenav);
        //card.find('.collapse').collapse();
        _.each(item.examples, function(filepath) {
            if (filepath.indexOf('_omit') === -1) {
                var li = jQuery('<li/>').appendTo(ul),
                    a = jQuery('<a/>').appendTo(li);
                a.attr('href', filepath);
                a.addClass('example');
                a.attr('target', 'graph_iframe');
                a.text(filepath.split('/')[1].replace('.php', ''));
            }
        });
    });
    jQuery('#accordion').on('click', 'a.example', function(e) {
        e.preventDefault();
        var href=$(this).attr('href');
        if(href.indexOf('examples_csim')!==-1) {
            jQuery('#graph_image').addClass('invisible');
            jQuery('#graph_iframe').removeClass('invisible');
            jQuery('#graph_iframe').attr('src',href);
        } else {
            jQuery('#graph_iframe').addClass('invisible');
            jQuery('#graph_image').removeClass('invisible');
            jQuery('#graph_image').attr('src',href);
        }
        jQuery('#filepath').text(href);
        return false;
    });

});
