<div class="block t-lh-50px mb-0 bb-0 pl-md-25 hidden-xs hidden-sm text-bold">
    Конкурсы
</div>

<div class="block">

    <div class="block__wrapper pt-10 fs-0_9 t-lh-1_4">
        <? if ($stagesJSON === "[]" || empty($judges)): ?>
            Для того, чтобы создать конкурс, необходимо внести информацию об
            <a class="link" href="<?= URL::site('event/' . $event->id . '/scenario/stages'); ?>">этапах</a> и
            <a class="link" href="<?= URL::site('event/' . $event->id . '/members/judges'); ?>">представитях жюри</a>.
        <? else: ?>
            <p>
                Создайте конкурсы, которые будут оценивать представители экспертного жюри. Каждый конкурс может проходить в
                однин или несколько этапов, которые указываются в формуле. Балл полученный участниками или командами за конкурс
                представляет собой сумму баллов полученных на выбранных в формуле этапах. Можно учесть "вес" конкурса, расставив
                соответствующие коэффициенты.
            </p>
            <a role="button" class="ui-btn ui-btn--1 collapse__btn" data-toggle="collapse" data-area="newContest" data-opened="false" data-textopened="Отмена создания" data-textclosed="Создать новый конкурс"></a>
        <? endif; ?>
        <input type="hidden" id="allStages" value='<?= $stagesJSON ?>'>
        <input type="hidden" id="eventID" value="<?= $event->id; ?>">
    </div>

</div>


<div id="newContest" class="collapse">

    <form class="block">

        <div class="block__wrapper p-20">

            <div class="form-group">
                <input type="text" id="newContestName" name="name" class="form-group__input" maxlength="60" autocomplete="off">
                <label for="newContestName" class="form-group__label">Название конкурса</label>
            </div>

            <div class="form-group">
                <textarea id="newContestDescription" name="description" class="form-group__textarea" maxlength="500" autocomplete="off"></textarea>
                <label for="newContestDescription" class="form-group__label">Описание конкурса</label>
            </div>

            <div class="form-group">
                <div class="fs-0_8 pb-5 text-brand-2">Жюри будут оценивать</div>

                <span>
                    <input type="radio" id="newContestMode1" name="newContestMode" class="radio" checked value="<?= Methods_Stages::MEMBERS_PARTICIPANTS; ?>">
                    <label for="newContestMode1" class="radio-label">участников</label>
                </span>

                <span class="ml-15">
                    <input type="radio" id="newContestMode2" name="newContestMode" class="radio" value="<?= Methods_Stages::MEMBERS_TEAMS; ?>">
                    <label for="newContestMode2" class="radio-label">команды</label>
                </span>
            </div>
            <div class="form-group">
                <label for="newContestJudges" class="fs-0_8 pb-5 text-brand-2">Представители жюри</label>
                <select id="newContestJudges" name="judges[]" class="form-group__input" multiple placeholder="выбрать">
                    <? foreach ($judges as $judge): ?>
                        <option value="<?= $judge->id; ?>"><?= $judge->name; ?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <div class="formula" id="newContestFormula"></div>
            </div>

        </div>

        <div class="block__footer pt-10 pb-10 pl-20 pr-20">
            <button type="submit" class="fl_r ui-btn ui-btn--1">Создать</button>
        </div>

    </form>

</div>

<div id="contestsArea">

    <? foreach ($contests as $contest): ?>

        <?= View::factory('events/blocks/scenario-contest-block', array('contest' => $contest)); ?>

    <? endforeach; ?>

</div>


<script type="text/javascript" src="<?=$assets; ?>vendor/choices/dist/choices.min.js?v=<?= filemtime("assets/vendor/choices/dist/choices.min.js") ?>"></script>
<script type="text/javascript" src="<?=$assets; ?>static/js/event-scenario-contests.js?v=<?= filemtime("assets/static/js/event-scenario-contests.js") ?>"></script>