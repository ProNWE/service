<script type="text/javascript" src="<?=$assets; ?>vendor/bootstrap/dist/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="<?=$assets; ?>vendor/bootstrap/dist/js/bootstrap-transition.js"></script>

<script type="text/javascript" src="<?=$assets; ?>vendor/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?=$assets; ?>vendor/select2/dist/js/i18n/ru.js"></script>

<link href="<?=$assets; ?>vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?=$assets; ?>vendor/sweetalert2/sweetalert2.min.js"></script>

<script type="text/javascript" src="<?=$assets; ?>js/event/groups.js"></script>

<h3 class="page-header">Список групп</h3>

<!-- NewGroup Form-->
<form method="POST" action="" class="form form_collapse" id="newgroup" enctype="multipart/form-data">
    <div class="form_body">
        <div class="col-xs-12 col-md-6">
            <div class="row">
                <div class="input-field">
                    <input id="newgroup_name" type="text" name="name" autocomplete="off">
                    <label for="newgroup_name">Введите название группы</label>
                </div>
            </div>
            <div class="row hidden">
                <div class="input-field">
                    <textarea id="newgroup_description" name="description"></textarea>
                    <label for="newgroup_description">Расскажите о группе</label>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="row hidden">
                <div class="radio-field clear_fix">
                    <label class="radio-label" >Группа состоит из</label>
                    <div class="radio-block">
                        <input type="radio" id="part" name="partORteam" checked="">
                        <label for="part">участников</label>
                    </div>
                    <div class="radio-block">
                        <input type="radio" id="team" name="partORteam">
                        <label for="team">команд</label>
                    </div>
                </div>
            </div>
            <div class="row hidden">
                <div id="show_participants" class="input-field">
                    <select name="participants[]" id="newgroup_participants" multiple="" class="elements_in_group">

                            <option value="0" data-logo="">Участник 5</option>
                            <option value="1" data-logo="">Участник 6</option>

                    </select>
                    <label for="newgroup_participants">Состав группы</label>
                </div>
                <div id="show_teams" class="input-field displaynone">
                    <select name="teams[]" id="newgroup_teams" multiple="" class="elements_in_group">

                            <option value="0">Команда 5</option>
                            <option value="1">Команда 6</option>

                    </select>
                    <label for="newgroup_teams">Состав группы</label>
                </div>
            </div>
        </div>
    </div>
    <div class="form_submit hidden clear_fix">
        <button id="create_group" type="button" class="btn btn_primary col-xs-12 col-sm-auto pull-right">
        	Создать группу
        </button>
    </div>
</form>

<!-- List of Groups -->
<div class="row row-col">
    <div class="col-xs-12">

        <div class="card clear_fix" action="" id="group_1">
            <div class="card_title">
                <div class="card_title-text" id="name_group_1">
                    Название Группы 1
                </div>
                <div class="card_title-dropdown">
                    <div role="button" class="card_title-dropdown-icon">
                        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </div>
                    <div class="card_title-dropdown-menu">
                        <a class="card_title-dropdown-item edit">
                            Изменить информацию
                        </a>
                        <a class="card_title-dropdown-item delete" data-pk="">
                            Удалить группу
                        </a>
                    </div>
                </div>
            </div>
            <div class="card_content">
                <p class="card_content-text">
                    <i><u>О группе:</u></i>
                    <span id="description_group_1">описание группы №1</span>
                </p>
                <p class="card_content-text">
                    <i><u>Состав группы:</u></i>
                    <!-- Participants in Groups, if they existed -->
                    <span id="participants_group_1">
                        <option value="0" data-logo="" selected="">Участник 1</option>
                        <option value="1" data-logo="" selected="">Участник 2</option>
                    </span>

                    <!-- Teams in Groups, if they existed -->
                    <span id="teams_group_1">
                    </span>
                </p>
            </div>
        </div>

        <div class="card clear_fix" action="" id="group_2">
            <div class="card_title">
                <div class="card_title-text" id="name_group_2">
                    Название Группы 2
                </div>
                <div class="card_title-dropdown">
                    <div role="button" class="card_title-dropdown-icon">
                        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </div>
                    <div class="card_title-dropdown-menu">
                        <a class="card_title-dropdown-item edit">
                            Изменить информацию
                        </a>
                        <a class="card_title-dropdown-item delete" data-pk="">
                            Удалить группу
                        </a>
                    </div>
                </div>
            </div>
            <div class="card_content">
                <p class="card_content-text">
                    <i><u>О группе:</u></i>
                    <span id="description_group_2">описание группы №2</span>
                </p>
                <p class="card_content-text">
                    <i><u>Состав группы:</u></i>

                    <!-- Participants in Groups, if they existed -->
                    <span id="participants_group_2">

                    </span>

                    <!-- Teams in Groups, if they existed -->
                    <span id="teams_group_2">
                        <option value="0" data-logo="" selected="">Команда 1</option>
                        <option value="1" data-logo="" selected="">Команда 2</option>
                    </span>
                </p>
            </div>
        </div>

    </div>
</div>

<input type="hidden" id="event_id" value="">

<!-- Modal - Update Group Info -->
<form class="modal fade" id="editgroup_modal" tabindex="-1" role="dialog" aria-labelledby="" method="post" action="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
                <h4 class="modal-title">Редактирование информации о группе</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="input-field">
                        <input type="text" id="editgroup_name" name="name" value="">
                        <label for="editgroup_name" class="active">Название группы</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <textarea id="editgroup_description" name="description"></textarea>
                        <label for="editgroup_description" class="active">Описание группы</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <select name="members[]" multiple id="editgroup_members">
                            <!-- [part || team] in group + [part || team] not_distributed -->
                        </select>
                        <label for="editgroup_members">Состав группы</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn_default" data-dismiss="modal">Отмена</button>
                <button id="update-info" type="button" class="btn btn_primary">Сохранить изменения</button>
            </div>
        </div>
    </div>
</form>
