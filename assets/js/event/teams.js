$(document).ready(function() {

    var url = "http://pronwe/assets/img/user";

    $('#new_team').click(function() {
        $(this).addClass('open');
    });

    $('body').click(function(event) {
        if ( ! $(event.target).closest("#new_team").is('#new_team') && $('#team_name-0').val() == "" && $('#team_description-0').val() == "" && $("#team_participants-0").closest('.input-field').find('.select2-selection__rendered .select2-selection__choice').length == 0) {
            $('#new_team').removeClass('open');
        }
    });

    $('.participants_in_team').select2({
        language: 'ru',
        templateResult: formatTeam
    });

    function formatTeam (team) {
        if (!team.id) {
            return team.text;
        }
        var $team = $(
            '<span class="select2-results__withlogo"><img src="' + url + '/' + team.element.value.toLowerCase() + '" class="select2-results__logo" /> <span class="select2-results__text">' + team.text + '</span></span>'
        );
        return $team;
    };


    /*
     * On load Add hidden class on long text
    */
    $('.card').each(function () {
        var first = $('.card_content-text:nth-child(1)', this),
            second = $('.card_content-text:nth-child(2)', this);

        if (first.height() > 64) {
            first.addClass('card_height-4em').append('<div class="card_content-text-hidden"  title="Показать полностью"></div>');
        }
        if (second.height() > 48) {
            second.addClass('card_height-3em').append('<div class="card_content-text-hidden" title="Показать полностью"></div>');
        }
    });



    /*
     *   Generate Modal Form for changing information about team
    */
    $('.team_edit').click(function(){
        var card = $(this).closest('.card'),
            id = card.attr('id'),
            modal_id = "modal_" + id,
            action = card.attr('action'),
            logo = $("#logo_" + id + " img").attr('src'),
            name = $.trim($("#name_" + id).text()),
            description = $.trim($("#description_" + id).text()),
            participants = $("#participants_" + id).html(),
            modal = template_modal[0] + modal_id + template_modal[1] + modal_id + "-Label" + template_modal[2] + action  // modal and form parametrs
                    + template_modal[3] + modal_id + "-Label"  + template_modal[4] // Label for modal
                    + id + "_name" + template_modal[5] + id + "_name" + template_modal[6] + name + template_modal[7] + id + "_name" + template_modal[8] // input name
                    + id + "_description" + template_modal[9] + id + "_description" + template_modal[10] + description + template_modal[11] + id + "_description" + template_modal[12] // textarea
                    + template_modal[13];

        $('body').append(modal);

        $($("#" + id + "_description")).on('init keyup focus', function(){
            textarea_resize($(this));
        });

        console.log($("#" + id + "_description"));
        $("#" + modal_id).modal({
            backdrop: 'static',
             keyboard: false
        });

    });

    template_modal = ['<form class="modal fade" id="',
    '" tabindex="-1" role="dialog" aria-labelledby="',
    '" method="post" action="',
    '"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close" aria-hidden="true"></i></button><h4 class="modal-title" id="',
    '">Редактирование информации о команде</h4></div><div class="modal-body"><div class="input-field"><input type="text" id="',
    '" name="','" value="','"><label for="','" class="active">Название команды</label></div><div class="input-field"><textarea id="',
    '" name="','">','</textarea><label for="','" class="active">Описание команды</label></div>',

    '</div><div class="modal-footer"><button type="button" class="btn btn_default" data-dismiss="modal">Отмена</button><button id="team_update-info" type="button" class="btn btn_primary">Сохранить изменения</button></div></div></div></form>']

    $('body').on('click', 'button[data-dismiss="modal"]', function(){
        $(this).wait(400).closest('.modal').remove();
    });
//#team_update-cancel
//#team_update-info




});

    /*
     *  Vars
    *
    var
        url = "http://pronwe/assets/img/user",
        edit = document.getElementById('edit'),
        save = document.getElementById('save'),
        table = document.getElementById('teams'),
        teams_settings,
        column_disabled,
        column_edited,
        hot,
        data_valid = true;


    /*
     *  Columns Settings
     *
     *  column_disabled - when users are not allowed to edit cells in table
     *  column_edited - when users can edit cells in table
    *

    column_disabled = [
        {
            data:'team_avatar',
            readOnly: true,
            className: 'htCenter',
            renderer: imageRenderer
        },
        {
            data:'team_name',
            readOnly: true,
        },
        {
            data:'team_description',
            readOnly: true,
        },
    ];


    column_edited = [
        {
            data:'team_avatar',
            editor: false,
            renderer:imageRenderer
        },
        {
            data:'team_name',
            readOnly: false,
            validator: function (value, callback) {
                if ( /[^A-Za-z0-9А-Яа-я ]/.test(value) || value == "") {
                    data_valid = false;
                    callback(false);
                } else {
                    data_valid = true;
                    callback(true);
                }
            }
        },
        {
            data:'team_description',
            readOnly: false,
            validator: function (value, callback) {
                if ( /[^A-Za-z0-9А-Яа-я#№!.,:;-_ ]/.test(value) ) {
                    callback(false);
                } else {
                    callback(true);
                }
            }
        },
    ];



    /*
     * Get array of teams from DB
    *
     var array_teams = [
         {
             "team_avatar": "",
             "team_name":"выв",
             "team_description": ""
         },
         {
             "team_avatar": "",
             "team_name":"выв",
             "team_description": ""
         },
     ];


     /*
      *  Handsontable settings
     *
     teams_settings = {
         data: array_teams,
		 rowHeaders: true,
		 fillHandle: false,
		 stretchH: 'all',
		 colHeaders: ['Логотип', 'Название команды', 'О команде'],
         columns: column_disabled,
         removeRowPlugin: true,
         colWidths: function(index){
             var width = parseInt(document.body.clientWidth);

             if (width > 992)
                 width = width * 0.7 - 110;

             else if (width < 992)
                width = width * 0.9 - 120;


             if (index == 0)
                 return 60;

             if (index == 1)
                 return width * 0.3;

             if (index == 2)
                 return width * 0.5;

         }
     };


    /*
     *  Create Handsontable
    *
    hot = new Handsontable(table, teams_settings);



    /*
	 *  Create title for column's headers
	*

    $('body').on('mouseenter', '.relative', function(){
        $(this).attr('title', $(this).children('.colHeader').text());
	});



    /*
     *  Edit teams
    *

    Handsontable.Dom.addEvent(edit, 'click', function() {

        save.className = "pull-right displayblock";
        edit.className = "displaynone";

        hot.updateSettings({
            minSpareRows: 1,
            removeRowPlugin: true,
            columns: column_edited
        });
    });



    /*
     *  Save teams
     *

    Handsontable.Dom.addEvent(save, 'click', function(el) {

        if ( data_valid == true ) {

            edit.className = "pull-right displayblock";
            save.className = "displaynone";


            hot.updateSettings({
                minSpareRows: 0,
                removeRowPlugin: false,
                columns: column_disabled
            });


            // delete last row if it's empty
            // if it's empty => show no user
            if (hot.isEmptyRow(hot.countRows() - 1) && hot.countRows() != 1) {
                hot.alter('remove_row', hot.countRows() - 1);
            }

            /*
             *  Data for Ajax updating
            *
            array_teams = [];

            $.each(hot.getData(), function(rowKey, object) {
                if (!hot.isEmptyRow(rowKey)) array_teams[rowKey] = object;
            });

            console.log(JSON.stringify(array_teams));

        } else {

            $.notify({
            	message: 'Пожалуйста, проверьте правильность введенных данных.'
            },{
            	type: 'danger'
            });

        }

    });


    /*
     *   Remove empty rows while editing
     *
     hot.addHook('afterChange', function() {

         for (var i = 0; i < hot.countRows(); i++) {
             if (hot.isEmptyRow(i)) {
                 hot.alter('remove_row', i);
             }
         }

     });



    /*
     *  Settings for image renderer
    *

    function imageRenderer (instance, td, row, col, prop, value, cellProperties) {

        var img = document.createElement('IMG');

        Handsontable.Dom.empty(td);

        img.className = "table-photo-logo";

        if (value != null && value != "")
            img.src = url + value;
        else
            img.src = url + "/no-team.png";

        td.appendChild(img);


       /*
        *   Change Image  -  update with ajax
        *
        Handsontable.Dom.addEvent(img, 'click', function (e){
            console.log(col+ " " +row +" change team image" );
        });

        return td;
    }

});*/
