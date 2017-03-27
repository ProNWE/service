<h3 class="page-header">
	Изменение основной информации о мероприятии
</h3>

<div class="row">
	<form class="form" action="<?=URL::site('event/' . $event->id . '/update'); ?>" method="POST" id="update_main_info">
		<div class="form_body">
            <div class="col-xs-12">
                <div class="row row-col">
                    <div class="input-field col-xs-12 col-md-6">
                        <input type="text" id="org_name" name="org_name" length="60" value="<?=$event->title; ?>" placeholder="Например: <?=$event->title; ?>">
                        <label for="org_name" class="input-label active">Название мероприятия</label>
                    </div>

                    <div class="input-field col-xs-12 col-md-6">
                        <input type="text" id="org_site" name="org_site" class="vp_site" length="38" value="<?=$event->uri; ?>" placeholder="Например: http://votepad.ru/<?=$event->uri; ?>">
                        <label for="org_site" class="input-label active">Ссылка на страницу мероприятия</label>
                    </div>
                </div>

                <div class="row row-col">
                    <div class="input-field col-xs-12">
                        <textarea id="org_description" name="org_description" length="300" placeholder="Например: <?=$event->description; ?>"><?=$event->description; ?></textarea>
                        <label for="org_description">Описание мероприятия</label>
                        <span class="help-block">Данная информация поможет найти Ваше мероприятие через поисковые системы.</span>
                    </div>
                </div>

                <div class="row row-col">
                    <div class="input-field col-xs-12 col-md-6">
                        <input type="datetime-local" id="start" name="start" tabindex="-1" value="<?=$event->dt_start; ?>">
                        <label for="start" class="active">Дата начала</label>
                    </div>
                    <div class="input-field col-xs-12 col-md-6">
                        <input type="datetime-local" id="end" name="end" tabindex="-1" value="<?=$event->dt_end; ?>">
                        <label for="end" class="active">Дата завершения</label>
                    </div>
                </div>
                <div class="row row-col">
                    <div class="input-field col-xs-12 col-md-6">
                        <textarea id="address" name="address" length="200" tabindex="-1" placeholder="Наприсер: <?=$event->address; ?>"><?=$event->address; ?></textarea>
                        <label for="address">Адрес</label>
                        <span class="help-block">Укажите, где будет проходить мероприятие. Эта информация отразится на странице мероприятия.</span>
                    </div>
                    <div class="input-field col-xs-12 col-md-6">
                        <style>
                            .select2-dropdown {
                                display: none !important;
                            }
                        </style>
                        <select id="keywords" name="keywords[]" multiple="multiple" tabindex="-1"></select>
                        <label for="keywords" style="padding-left: 15px">Хэш-теги меропрития</label>
                    </div>
                </div>
            </div>

		</div>
		<div class="form_submit clear_fix">
			<button type="submit" class="btn btn_primary col-xs-12 col-md-4 col-lg-3 pull-right">
				Обновить информацию
			</button>
		</div>
	</form>
</div>


<!-- =============== PAGE SCRIPTS ===============-->
<script type="text/javascript" src="<?=$assets; ?>vendor/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?=$assets; ?>vendor/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>
<script type="text/javascript" src="<?=$assets; ?>static/js/event/settings-maininfo.js"></script>