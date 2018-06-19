/**
 * Text field HTML
 * @param name
 */
function textFieldHtml(name)
{
    html = '<div class="input-group mb-3">';
    html += addRequiredCheckbox(name);
    html += '<input type="text" class="form-control" aria-label="Text input with checkbox" name="'+name+'_text" placeholder="'+name+'" readonly>\n'
    html += addHandle();
    html += '</div>';

    setField(html);
}

/**
 * Text Area HTML
 * @param name
 */
function textAreaFieldHtml(name)
{
    html = '<div class="input-group mb-3">';

    // html += '<label class="control-label ignore">'+name+'</label>';

    html += addRequiredCheckbox(name);

    html += '<textarea class="form-control inserted-textarea" name="'+name+'_textarea" rows="2" readonly placeholder="'+name+'"></textarea>';

    html += addHandle();
    html += '</div>';

    setField(html);
}

/**
 * Select list HTML
 * @param name
 */
function selectListHtml(name)
{
    html = '<div class="input-group mb-3">';

    html += addRequiredCheckbox(name);

    html += '<input class="form-control" name="'+name+'_select" value="'+name+'">';

    html += addHandle();

    html += '<div class="input-group col-md-offset-1">';
    html += '<input type="text" name="'+name+'_select_option[]" value="" class="form-control" placeholder="Option value">\n' +
        '                            <span class="input-group-btn">\n' +
    '                                    <button class="btn btn-primary" type="button" onclick="addOption(this)"><i class="fa fa-plus" aria-hidden="true"></i></button>\n' +
    '                                </span>';
    html += '</div>';

    html += '<div class="select-anchor" data-name="'+name+'"></div>';

    html += '</div>';


    setField(html);

    $('#selector').data('name', name);
}

/**
 * Add an option to a select list
 * @param t
 */
function addOption(t)
{
    let name =  $(t).parent().parent().next().data('name');
    html = '<div class="input-group col-md-offset-1">';
    html += '<input type="text" name="'+name+'_select_option[]" value="" class="form-control" placeholder="Option value">' +
        '     <span class="input-group-btn">' +
        '       <button class="btn btn-primary" type="button" onclick="addOption(this)"><i class="fa fa-plus" aria-hidden="true"></i></button>' +
        '         </span>';
    html += '</div>';
    html += '<div class="clearfix"></div>';
    $(t).parent().parent().after(html);

    console.log($(t).find('input'));
    $(t).find('input').focus()
}

/**
 * Checkbox HTML
 * @param name
 */
function checkbox(name)
{
    html = '<label class="control-label">'+name+'</label>';

    html += '<input class="form-control" type="checkbox" name="'+name+'_checkbox">';

    return setField(html);
}

/**
 * Add the required checkbox to the text,
 * textarea, and select list fields
 * @param name
 * @returns {string|*}
 */
function addRequiredCheckbox(name)
{
    html = '  <div class="input-group-prepend">\n' +
        '    <div class="input-group-text">\n' +
        '      <input type="checkbox" name="'+name+'_required" aria-label="Checkbox for requiring this input">\n' +
        '    </div>\n' +
        '  </div>';

    return html;
}

/**
 * Add the required checkbox to the text,
 * textarea, and select list fields
 * @param name
 * @returns {string|*}
 */
function addHandle()
{
    html = '  <div class="input-group-append handle" title="Move the input in the form">\n' +
        '    <div class="input-group-text">\n' +
        '      <span class=""><i class="fas fa-ellipsis-v"></i></span>\n' +
        '    </div>\n' +
        '  </div>';

    return html;
}

/**
 * Resolves the type of field added
 * and returns the necessary HTML
 * @returns {boolean}
 */
function selected()
{
    let type = $('#adder').val();
    let name = $('#adder-name').val();
    let value = 'on';

    switch(type) {
        case 'text':
            textFieldHtml(name);
            break;
        case 'textarea':
            textAreaFieldHtml(name);
            break;
        case 'select':
            selectListHtml(name);
            break;
        case 'checkbox':
            checkbox(name);
            break;
        default:
            swal("Error", "Please select a field type!", {
                buttons: false,
                closeOnClickOutside: true,
                icon: "error"
            });
    }
}

/**
 * Sets the field into the anchor div
 * @param html
 */
function setField(html)
{
    let div = $('#anchor');
    $('#anchor-msg').remove();
    $('#require-msg').show();
    div.append(html);
    reset();
}

/**
 * Sorts the fields and denies sort by pulling
 * on the input's label
 */
$(".all-fields").sortable({
    axis: "y",
    revert: true,
    scroll: false,
    placeholder: "sortable-placeholder",
    cursor: "move",
    cancel: "label",
    handle: ".handle"
});

/**
 * Resets the add field and the name field
 */
function reset()
{
    $('#adder').val('default');
    $('#adder-name').val('');
}

/**
 * Checks the value of the redirect_to select list
 * and changes the visibility of the redirect path
 * depending on the value.
 */
$('#after-submit').on('change', function(){
    console.log($(this).val());
    if($(this).val() === 'redirect'){
        $('input[name=redirect_to]').parent().toggleClass('d-none');
    } else {
        $('input[name=redirect_to]').parent().addClass('d-none');
    }
});
